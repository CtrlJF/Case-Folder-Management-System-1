<?php
// Check if acc_id is set in the session
if(isset($_SESSION['acc_id'])) {
    // Get the account ID from the session
    $acc_id = $_SESSION['acc_id'];

    // Perform the database query using the acc_id
    $sql = "SELECT * FROM user_account WHERE acc_id = :acc_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':acc_id', $acc_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch data from the result set
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Check if data is fetched successfully
    if(!$data) {
        echo "No data found for this account ID.";
    }


    $query = "
        SELECT 
            ua.acc_id AS user_acc_id,
            ubc.id AS ubc_id, ubc.name AS ubc_name, ubc.famrole AS ubc_famrole, ubc.img AS ubc_img, ubc.status AS ubc_status, ubc.upload AS ubc_upload,
            ucc.id AS ucc_id, ucc.name AS ucc_name, ucc.img AS ucc_img, ucc.status AS ucc_status, ucc.upload AS ucc_upload,
            uc.id AS uc_id, uc.name AS uc_name, uc.img AS uc_img, uc.status AS uc_status, uc.upload AS uc_upload,
            uf.id AS uf_id, uf.name AS uf_name, uf.upload AS uf_upload, uf.img AS uf_img, uf.status AS uf_status,
            ugc.id AS ugc_id, ugc.name AS ugc_name, ugc.upload AS ugc_upload, ugc.img AS ugc_img, ugc.status AS ugc_status,
            uir.id AS uir_id, uir.name AS uir_name, uir.img AS uir_img, uir.status AS uir_status, uir.upload AS uir_upload,
            uk.id AS uk_id, uk.name AS uk_name, uk.img AS uk_img, uk.status AS uk_status, uk.upload AS uk_upload,
            umc.id AS umc_id, umc.name AS umc_name, umc.img AS umc_img, umc.status AS umc_status, umc.upload AS umc_upload,
            umdr.id AS umdr_id, umdr.name AS umdr_name, umdr.img AS umdr_img, umdr.status AS umdr_status, umdr.upload AS umdr_upload,
            un.id AS un_id, un.name AS un_name, un.famrole AS un_famrole, un.status AS un_status, un.img AS un_img, un.upload AS un_upload,
            up.id AS up_id, up.img AS up_img, up.status AS up_status, up.name AS up_name, up.upload AS up_upload,
            ubp.id AS ubp_id, ubp.upload AS ubp_upload, ubp.status AS ubp_status

        FROM user_account ua
        LEFT JOIN user_birth_certificate ubc ON ua.acc_id = ubc.acc_id
        LEFT JOIN user_cash_card ucc ON ua.acc_id = ucc.acc_id
        LEFT JOIN user_certificate uc ON ua.acc_id = uc.acc_id
        LEFT JOIN user_family_photo uf ON ua.acc_id = uf.acc_id
        LEFT JOIN user_grade_cards ugc ON ua.acc_id = ugc.acc_id
        LEFT JOIN user_immunization_record uir ON ua.acc_id = uir.acc_id
        LEFT JOIN user_kasabutan uk ON ua.acc_id = uk.acc_id
        LEFT JOIN user_marriage_contract umc ON ua.acc_id = umc.acc_id
        LEFT JOIN user_mdr umdr ON ua.acc_id = umdr.acc_id
        LEFT JOIN user_national_id un ON ua.acc_id = un.acc_id
        LEFT JOIN user_pantawid_id up ON ua.acc_id = up.acc_id
        LEFT JOIN user_beneficiary_profile ubp ON ua.acc_id = ubp.acc_id

        WHERE ua.acc_id = :id
        ";

    // Execute query
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $acc_id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Initialize an empty array to hold structured data
    $structuredData = [
        'birth_certificate' => [],
        'cash_card' => [],
        'certificate' => [],
        'family_photo' => [],
        'grade_cards' => [],
        'immunization_record' => [],
        'kasabutan' => [],
        'marriage_contract' => [],
        'mdr' => [],
        'national_id' => [],
        'pantawid_id' => [],
        'beneficiary_profile' => []
    ];

    // Helper function to add unique entries
    function addUniqueEntry(&$array, $type, $entry) {
        if (!isset($array[$type])) {
            $array[$type] = [];
        }
        $uniqueKey = $entry['id']; // Use 'id' to check uniqueness; adjust if needed
        if (!array_key_exists($uniqueKey, $array[$type])) {
            $array[$type][$uniqueKey] = $entry;
        }
    }

    // Iterate through each row of the fetched data
    foreach ($result as $row) {
        // Birth Certificate
        if (!empty($row['ubc_id'])) {
            addUniqueEntry($structuredData, 'birth_certificate', [
                'id' => $row['ubc_id'],
                'name' => $row['ubc_name'],
                'family_role' => $row['ubc_famrole'],
                'img' => $row['ubc_img'],
                'status' => $row['ubc_status'],
                'upload_date' => $row['ubc_upload']
            ]);
        }

        // Cash Card
        if (!empty($row['ucc_id'])) {
            addUniqueEntry($structuredData, 'cash_card', [
                'id' => $row['ucc_id'],
                'name' => $row['ucc_name'],
                'img' => $row['ucc_img'],
                'status' => $row['ucc_status'],
                'upload_date' => $row['ucc_upload']
            ]);
        }

        // Certificate
        if (!empty($row['uc_id'])) {
            addUniqueEntry($structuredData, 'certificate', [
                'id' => $row['uc_id'],
                'name' => $row['uc_name'],
                'img' => $row['uc_img'],
                'status' => $row['uc_status'],
                'upload_date' => $row['uc_upload']
            ]);
        }

        // Family Photo
        if (!empty($row['uf_id'])) {
            addUniqueEntry($structuredData, 'family_photo', [
                'id' => $row['uf_id'],
                'name' => $row['uf_name'],
                'upload_date' => $row['uf_upload'],
                'img' => $row['uf_img'],
                'status' => $row['uf_status']
            ]);
        }

        // Grade Cards
        if (!empty($row['ugc_id'])) {
            addUniqueEntry($structuredData, 'grade_cards', [
                'id' => $row['ugc_id'],
                'name' => $row['ugc_name'],
                'upload_date' => $row['ugc_upload'],
                'img' => $row['ugc_img'],
                'status' => $row['ugc_status']
            ]);
        }

        // Immunization Record
        if (!empty($row['uir_id'])) {
            addUniqueEntry($structuredData, 'immunization_record', [
                'id' => $row['uir_id'],
                'name' => $row['uir_name'],
                'img' => $row['uir_img'],
                'status' => $row['uir_status'],
                'upload_date' => $row['uir_upload']
            ]);
        }

        // Kasabutan
        if (!empty($row['uk_id'])) {
            addUniqueEntry($structuredData, 'kasabutan', [
                'id' => $row['uk_id'],
                'name' => $row['uk_name'],
                'img' => $row['uk_img'],
                'status' => $row['uk_status'],
                'upload_date' => $row['uk_upload']
            ]);
        }

        // Marriage Contract
        if (!empty($row['umc_id'])) {
            addUniqueEntry($structuredData, 'marriage_contract', [
                'id' => $row['umc_id'],
                'name' => $row['umc_name'],
                'img' => $row['umc_img'],
                'status' => $row['umc_status'],
                'upload_date' => $row['umc_upload']
            ]);
        }

        // MDR
        if (!empty($row['umdr_id'])) {
            addUniqueEntry($structuredData, 'mdr', [
                'id' => $row['umdr_id'],
                'name' => $row['umdr_name'],
                'img' => $row['umdr_img'],
                'status' => $row['umdr_status'],
                'upload_date' => $row['umdr_upload']
            ]);
        }

        // National ID
        if (!empty($row['un_id'])) {
            addUniqueEntry($structuredData, 'national_id', [
                'id' => $row['un_id'],
                'name' => $row['un_name'],
                'family_role' => $row['un_famrole'],
                'status' => $row['un_status'],
                'img' => $row['un_img'],
                'upload_date' => $row['un_upload']
            ]);
        }

        // Pantawid ID
        if (!empty($row['up_id'])) {
            addUniqueEntry($structuredData, 'pantawid_id', [
                'id' => $row['up_id'],
                'img' => $row['up_img'],
                'name' => $row['up_name'],
                'status' => $row['up_status'],
                'upload_date' => $row['up_upload']
            ]);
        }

        // Beneficiary Profile
        if (!empty($row['ubp_id'])) {
            addUniqueEntry($structuredData, 'beneficiary_profile', [
                'id' => $row['ubp_id'],
                'upload_date' => $row['ubp_upload'],
                'status' => $row['ubp_status']
            ]);
        }
    }

    // Convert arrays back to indexed arrays for display
    foreach ($structuredData as $type => &$entries) {
        $entries = array_values($entries); // Re-index array
    }

    $directories = [
        'national_id' => '../uploads/nationalID/',
        'family_photo' => '../uploads/fampick/',
        'pantawid_id' => '../uploads/pantawidID/',
        'cash_card' => '../uploads/cashcard/',
        'kasabutan' => '../uploads/kasabutan/',
        'birth_certificate' => '../uploads/birthcert/',
        'marriage_contract' => '../uploads/marriagecont/',
        'immunization_record' => '../uploads/immurec/',
        'grade_cards' => '../uploads/gradecards/',
        'mdr' => '../uploads/mdr/',
        'certificate' => '../uploads/certattend/',
        'beneficiary_profile' => 'formview2.php?id='
    ];

} else {
    echo "Account ID not found in session.";
    echo "<script>window.location='pages/login.php';</script>";
}

// Close database connection
unset($pdo);

// Return the query result or data
return $data;
?>
