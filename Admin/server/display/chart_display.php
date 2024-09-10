<?php
function updateUserStatuses($pdo) {
    $query = "SELECT
    ua.hhid,
    (CASE WHEN COUNT(DISTINCT mdr.id) > 0 THEN 1 ELSE 0 END +
     CASE WHEN COUNT(DISTINCT kasabutan.id) > 0 THEN 1 ELSE 0 END +
     CASE WHEN COUNT(DISTINCT cash_card.id) > 0 THEN 1 ELSE 0 END +
     CASE WHEN COUNT(DISTINCT certificate.id) > 0 THEN 1 ELSE 0 END +
     CASE WHEN COUNT(DISTINCT pantawid_id.id) > 0 THEN 1 ELSE 0 END +
     CASE WHEN COUNT(DISTINCT marriage_contract.id) > 0 THEN 1 ELSE 0 END +
     CASE WHEN COUNT(DISTINCT grade_cards.id) > 0 THEN 1 ELSE 0 END +
     CASE WHEN COUNT(DISTINCT immunization_record.id) > 0 THEN 1 ELSE 0 END +
     CASE WHEN COUNT(DISTINCT birth_certificate.id) > 0 THEN 1 ELSE 0 END +
     CASE WHEN COUNT(DISTINCT family_photo.id) > 0 THEN 1 ELSE 0 END +
     CASE WHEN COUNT(DISTINCT national_id.id) > 0 THEN 1 ELSE 0 END +
     CASE WHEN COUNT(DISTINCT beneficiary_profile.id) > 0 THEN 1 ELSE 0 END
    ) AS passed_tables
    FROM user_account ua
    LEFT JOIN user_mdr mdr ON ua.acc_id = mdr.acc_id AND mdr.status = 'approved'
    LEFT JOIN user_kasabutan kasabutan ON ua.acc_id = kasabutan.acc_id AND kasabutan.status = 'approved'
    LEFT JOIN user_cash_card cash_card ON ua.acc_id = cash_card.acc_id AND cash_card.status = 'approved'
    LEFT JOIN user_certificate certificate ON ua.acc_id = certificate.acc_id AND certificate.status = 'approved'
    LEFT JOIN user_pantawid_id pantawid_id ON ua.acc_id = pantawid_id.acc_id AND pantawid_id.status = 'approved'
    LEFT JOIN user_marriage_contract marriage_contract ON ua.acc_id = marriage_contract.acc_id AND marriage_contract.status = 'approved'
    LEFT JOIN user_grade_cards grade_cards ON ua.acc_id = grade_cards.acc_id AND grade_cards.status = 'approved'
    LEFT JOIN user_immunization_record immunization_record ON ua.acc_id = immunization_record.acc_id AND immunization_record.status = 'approved'
    LEFT JOIN user_birth_certificate birth_certificate ON ua.acc_id = birth_certificate.acc_id AND birth_certificate.status = 'approved'
    LEFT JOIN user_family_photo family_photo ON ua.acc_id = family_photo.acc_id AND family_photo.status = 'approved'
    LEFT JOIN user_national_id national_id ON ua.acc_id = national_id.acc_id AND national_id.status = 'approved'
    LEFT JOIN user_beneficiary_profile beneficiary_profile ON ua.acc_id = beneficiary_profile.acc_id AND beneficiary_profile.status = 'approved'
    GROUP BY ua.hhid;";

    $statement = $pdo->prepare($query);
    $statement->execute();

    // Prepare the update query
    $updateQuery = "UPDATE user_account 
                SET status = :status
                WHERE hhid = :hhid AND status != 'completed' AND status != 'pending'"; /* AND status != 'completed'  */

    // Iterate over the results and update the status
    $updateStatement = $pdo->prepare($updateQuery);

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $userHHID = $row['hhid'];
    $passedTables = $row['passed_tables'];

    // Determine the status based on the number of passed tables
    $status = ($passedTables > 6) ? 'active' : 'inactive';

    // Update the status in the user_account table
    $updateStatement->execute([
        ':status' => $status,
        ':hhid' => $userHHID
    ]);

    /* echo "User $userHHID status updated to $status.\n"; */
    }

    // Prepare the queries
    $eligibleMembersQuery = "
    -- Step 1: Get the latest row from user_beneficiary_profile for each acc_id
    WITH LatestBeneficiaryProfile AS (
        SELECT
            acc_id,
            MAX(id) AS latest_id
        FROM user_beneficiary_profile
        WHERE status = 'approved'
        GROUP BY acc_id
    ),
    
    -- Step 2: Select bp_hh_member rows linked to the latest user_beneficiary_profile row
    LatestBpHhMember AS (
        SELECT
            bp.acc_id,
            bhm.bp_id,
            bhm.birthday,
            bhm.register_grant
        FROM LatestBeneficiaryProfile lbp
        JOIN user_beneficiary_profile bp ON lbp.acc_id = bp.acc_id AND lbp.latest_id = bp.id
        JOIN bp_hh_member bhm ON bp.id = bhm.bp_id
    ),
    
    -- Step 3: Identify users who have any 'Oo' with a person under 18
    UsersWithSomeBelow18 AS (
        SELECT DISTINCT acc_id
        FROM LatestBpHhMember
        WHERE register_grant = 'Oo' AND TIMESTAMPDIFF(YEAR, birthday, CURDATE()) < 18
    ),
    
    -- Step 4: Ensure all 'Oo' entries for a user are 18 or older
    EligibleMembers AS (
        SELECT lbp.acc_id
        FROM LatestBeneficiaryProfile lbp
        JOIN LatestBpHhMember lbp_bhm ON lbp.acc_id = lbp_bhm.acc_id
        WHERE lbp_bhm.register_grant = 'Oo'
        GROUP BY lbp.acc_id
        HAVING COUNT(*) = COUNT(CASE WHEN TIMESTAMPDIFF(YEAR, lbp_bhm.birthday, CURDATE()) >= 18 THEN 1 ELSE NULL END)
    )
    
    -- Final query to select desired columns from EligibleMembers
    SELECT
        acc_id
    FROM EligibleMembers;
    ";

    $dateEnteredQuery = "
        SELECT acc_id
        FROM user_account
        WHERE DATE_ADD(dateEntered, INTERVAL 8 YEAR) <= CURDATE();
    ";

    // Fetch eligible users based on bp_hh_member
    $statement = $pdo->prepare($eligibleMembersQuery);
    $statement->execute();
    $completedUsersFromBHM = $statement->fetchAll(PDO::FETCH_COLUMN, 0);

    // Fetch users based on dateEntered
    $statement = $pdo->prepare($dateEnteredQuery);
    $statement->execute();
    $completedUsersFromDateEntered = $statement->fetchAll(PDO::FETCH_COLUMN, 0);

    // Merge results
    $completedUsers = array_unique(array_merge($completedUsersFromBHM, $completedUsersFromDateEntered));

    // Prepare update query
    $updateQuery = "UPDATE user_account SET status = 'completed' WHERE acc_id = :acc_id";
    $updateStatement = $pdo->prepare($updateQuery);

    // Update status for all eligible users
    foreach ($completedUsers as $acc_id) {
        $updateStatement->execute([':acc_id' => $acc_id]);
       /*  echo "User $acc_id status updated to completed.\n"; */
    }
}

// Usage
if(isset($_SESSION['id_no'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');
    updateUserStatuses($pdo);

    $sql = "SELECT barangay, status FROM user_account WHERE status != 'pending' ORDER BY barangay";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
} else {
    echo "Account ID not found in session.";
    echo "<script>window.location='pages/login.php';</script>";
}

unset($pdo);

?>