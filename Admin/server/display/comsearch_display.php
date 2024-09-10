<?php
if(isset($_SESSION['id_no'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');

    /* $sql = "
    -- Step 1: Get the latest user_beneficiary_profile for each user
WITH LatestUserProfile AS (
    SELECT
        ubp.id,
        ubp.acc_id,
        ubp.usergrant,
        ubp.upload
    FROM
        user_beneficiary_profile ubp
    INNER JOIN (
        SELECT
            acc_id,
            MAX(upload) AS latest_upload
        FROM
            user_beneficiary_profile
        WHERE 
            status = 'approved'
        GROUP BY
            acc_id
    ) latest ON ubp.acc_id = latest.acc_id AND ubp.upload = latest.latest_upload
)

-- Step 2: Calculate the total 'Oo' and count of 18 or older based on the latest profiles
SELECT
    ua.acc_id,
    ua.hhid,
    ua.fname,
    ua.mname,
    ua.lname,
    ua.phone_number,
    ua.user_set,
    ua.purok,
    ua.phylsis_id,
    ua.status,
    ua.barangay,
    IFNULL(total_Oo.total_Oo, 0) AS total_Oo,
    IFNULL(count_18_or_older.count_18_or_older, 0) AS count_18_or_older
FROM
    user_account ua
LEFT JOIN (
    SELECT
        COUNT(*) AS total_Oo,
        ubp.acc_id
    FROM
        bp_hh_member bphm
    JOIN LatestUserProfile ubp ON bphm.bp_id = ubp.id
    WHERE
        bphm.register_grant = 'Oo'
    GROUP BY
        ubp.acc_id
) AS total_Oo ON ua.acc_id = total_Oo.acc_id
LEFT JOIN (
    SELECT
        COUNT(*) AS count_18_or_older,
        ubp.acc_id
    FROM
        bp_hh_member bphm
    JOIN LatestUserProfile ubp ON bphm.bp_id = ubp.id
    WHERE
        bphm.register_grant = 'Oo'
        AND TIMESTAMPDIFF(YEAR, bphm.birthday, CURDATE()) >= 18
    GROUP BY
        ubp.acc_id
    HAVING
        COUNT(*) > 0
) AS count_18_or_older ON ua.acc_id = count_18_or_older.acc_id
WHERE
    ua.status IN ('active', 'completed')
    AND (ua.status = 'completed' OR count_18_or_older.count_18_or_older > 0)
ORDER BY
    ua.barangay;
    "; */

    $sql = "SELECT acc_id, hhid, fname, mname, lname, phone_number, barangay, purok, user_set, phylsis_id, status, dateEntered FROM user_account WHERE status = 'completed' ORDER BY barangay, fname"; 

    // Execute the query
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Group the results by barangay
    $barangayGroups = [];

    foreach ($results as $row) {
        $barangayGroups[$row['barangay']][] = $row;
    }

    function formathhid($hhid) {
        // Assuming $hhid is a string with 18 characters
        return substr($hhid, 0, 9) . '-' . substr($hhid, 9, 4) . '-' . substr($hhid, 13);
    }

    function formatid($id) {
        // Assuming $id is a string with 16 characters
        return substr($id, 0, 4) . '-' . substr($id, 4, 4) . '-' . substr($id, 8, 4) . '-' . substr($id, 12);
    }

} else {
    echo "Account ID not found in session.";
    echo "<script>window.location='pages/login.php';</script>";
}

unset($pdo);

?>