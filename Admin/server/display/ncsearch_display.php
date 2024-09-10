<?php  
if(isset($_SESSION['id_no'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');

    $sql = "  
    WITH approved_data AS (
        -- Retrieve all approved records from the tables with user-friendly names
        SELECT acc_id, 'National ID' AS table_name FROM user_national_id WHERE status = 'approved'
        UNION ALL
        SELECT acc_id, 'Pantawid ID' AS table_name FROM user_pantawid_id WHERE status = 'approved'
        UNION ALL
        SELECT acc_id, 'Cash Card' AS table_name FROM user_cash_card WHERE status = 'approved'
        UNION ALL
        SELECT acc_id, 'Family Picture' AS table_name FROM user_family_photo WHERE status = 'approved'
        UNION ALL
        SELECT acc_id, 'Kasabutan' AS table_name FROM user_kasabutan WHERE status = 'approved'
        UNION ALL
        SELECT acc_id, 'Birth Certificate' AS table_name FROM user_birth_certificate WHERE status = 'approved'
        UNION ALL
        SELECT acc_id, 'Marriage Contract' AS table_name FROM user_marriage_contract WHERE status = 'approved'
        UNION ALL
        SELECT acc_id, 'Immunization Record' AS table_name FROM user_immunization_record WHERE status = 'approved'
        UNION ALL
        SELECT acc_id, 'Grade Cards' AS table_name FROM user_grade_cards WHERE status = 'approved'
        UNION ALL
        SELECT acc_id, 'MDR' AS table_name FROM user_mdr WHERE status = 'approved'
        UNION ALL
        SELECT acc_id, 'Certificate' AS table_name FROM user_certificate WHERE status = 'approved'
        UNION ALL
        SELECT acc_id, 'Beneficiary Profile' AS table_name FROM user_beneficiary_profile WHERE status = 'approved'
    ),
    all_tables AS (
        -- Define the list of all tables to check with user-friendly names
        SELECT 'National ID' AS table_name
        UNION ALL
        SELECT 'Pantawid ID'
        UNION ALL
        SELECT 'Cash Card'
        UNION ALL
        SELECT 'Family Picture'
        UNION ALL
        SELECT 'Kasabutan'
        UNION ALL
        SELECT 'Birth Certificate'
        UNION ALL
        SELECT 'Marriage Contract'
        UNION ALL
        SELECT 'Immunization Record'
        UNION ALL
        SELECT 'Grade Cards'
        UNION ALL
        SELECT 'MDR'
        UNION ALL
        SELECT 'Certificate'
        UNION ALL
        SELECT 'Beneficiary Profile'
    ),
    user_data AS (
        -- Retrieve all users with inactive status
        SELECT
            ua.acc_id,
            ua.fname,
            ua.mname,
            ua.lname,
            ua.hhid,
            ua.phone_number,
            ua.user_set,
            ua.purok,
            ua.barangay
        FROM
            user_account ua
        WHERE
            ua.status = 'inactive'
    ),
    user_data_missing AS (
        -- Find missing data for each user
        SELECT
            ud.acc_id,
            ud.fname,
            ud.mname,
            ud.lname,
            ud.hhid,
            ud.phone_number,
            ud.user_set,
            ud.purok,
            ud.barangay,
            GROUP_CONCAT(at.table_name ORDER BY at.table_name SEPARATOR ', ') AS no_data
        FROM
            user_data ud
        CROSS JOIN
            all_tables at
        LEFT JOIN
            approved_data ad ON ud.acc_id = ad.acc_id AND at.table_name = ad.table_name
        WHERE
            ad.table_name IS NULL
        GROUP BY
            ud.acc_id, ud.fname, ud.mname, ud.lname, ud.hhid, ud.phone_number, ud.user_set, ud.purok, ud.barangay
    ),
    user_data_has AS (
        -- Find approved data for each user
        SELECT
            ud.acc_id,
            GROUP_CONCAT(DISTINCT ad.table_name ORDER BY ad.table_name SEPARATOR ', ') AS has_data
        FROM
            user_data ud
        LEFT JOIN
            approved_data ad ON ud.acc_id = ad.acc_id
        GROUP BY
            ud.acc_id
    )
    SELECT
        ud.acc_id,
        ud.fname,
        ud.mname,
        ud.lname,
        ud.hhid,
        ud.phone_number,
        ud.user_set,
        ud.purok,
        ud.barangay,
        COALESCE(udm.no_data, '') AS no_data,
        COALESCE(udh.has_data, '') AS has_data
    FROM
        user_data ud
    LEFT JOIN
        user_data_missing udm ON ud.acc_id = udm.acc_id
    LEFT JOIN
        user_data_has udh ON ud.acc_id = udh.acc_id
    ORDER BY
        ud.barangay, ud.hhid;         
    ";

    // Execute the query
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

     // Initialize the structure
     $barangayGroups = [];

     // Transform the results into the desired structure
     foreach ($results as $row) {
         $barangay = $row['barangay'];
         $nameKey = $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'] . ' (' . $row['hhid'] . ')' ; //. ' ' . $row['acc_id'] 
         
         // Initialize barangay group if it does not exist
         if (!isset($barangayGroups[$barangay])) {
             $barangayGroups[$barangay] = [];
         }
         
         // Initialize user entry if it does not exist
         if (!isset($barangayGroups[$barangay][$nameKey])) {
             $barangayGroups[$barangay][$nameKey] = [
                 'phone_number' => $row['phone_number'],
                 'user_set' => $row['user_set'],
                 'purok' => $row['purok'],
                 'no_data' => [],
                 'has_data' => []
             ];
         }
         
         // Add missing data to the user entry
         $barangayGroups[$barangay][$nameKey]['no_data'][] = $row['no_data'];
         $barangayGroups[$barangay][$nameKey]['has_data'][] = $row['has_data'];
     }
      
    $data = $barangayGroups;
     /* // Output the structure
     echo '<pre>' . print_r($barangayGroups, true) . '</pre>'; */





    function formathhid($hhid) {
        // Assuming $hhid is a string with 18 characters
        return substr($hhid, 0, 9) . '-' . substr($hhid, 9, 4) . '-' . substr($hhid, 13);
    }


} else {
    echo "Account ID not found in session.";
    echo "<script>window.location='pages/login.php';</script>";
}

unset($pdo);
?>