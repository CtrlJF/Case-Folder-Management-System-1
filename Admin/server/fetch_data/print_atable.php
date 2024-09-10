<?php
if(isset($_SESSION['id_no'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');

    // Initialize the result array
    $result = [];

    // Define the barangay
   /*  $barangay = 'Barangay 10';
    $table = "user_national_id"; */
    // queries to get all the table data
    switch ($table) {
        case 'user_national_id':
            $sql = "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, n.id AS row_id, n.name AS name, n.famrole AS famrole, YEAR(n.upload) AS upload_year
                    FROM user_national_id AS n
                    JOIN user_account AS u ON n.acc_id = u.acc_id
                    WHERE n.status = 'approved'
                    AND u.barangay = '$barangay'
                    GROUP BY u.barangay, u.acc_id, n.id, YEAR(n.upload);";
            $tname = 'National ID';        
            break;
        case 'user_family_photo':
            $sql = "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, f.id AS row_id, f.name AS name, YEAR(f.upload) AS upload_year
                    FROM user_family_photo AS f
                    JOIN user_account AS u ON f.acc_id = u.acc_id
                    WHERE f.status = 'approved'
                    AND u.barangay = '$barangay'
                    GROUP BY u.barangay, u.acc_id, f.id, YEAR(f.upload);";
            $tname = 'Family Photo';    
            break;
        case 'user_pantawid_id':
            $sql = "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, p.id AS row_id, p.name AS name, YEAR(p.upload) AS upload_year
                    FROM user_pantawid_id AS p
                    JOIN user_account AS u ON p.acc_id = u.acc_id
                    WHERE p.status = 'approved'
                    AND u.barangay = '$barangay'
                    GROUP BY u.barangay, u.acc_id, p.id, YEAR(p.upload);";
            $tname = 'Pantawid ID';    
            break;
        case 'user_cash_card':
            $sql = "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, c.id AS row_id, c.name AS name, YEAR(c.upload) AS upload_year
                    FROM user_cash_card AS c
                    JOIN user_account AS u ON c.acc_id = u.acc_id
                    WHERE c.status = 'approved'
                    AND u.barangay = '$barangay'
                    GROUP BY u.barangay, u.acc_id, c.id, YEAR(c.upload);";
            $tname = 'Cash Card';    
            break;
        case 'user_kasabutan':
            $sql = "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, k.id AS row_id, k.name AS name, YEAR(k.upload) AS upload_year
                    FROM user_kasabutan AS k
                    JOIN user_account AS u ON k.acc_id = u.acc_id
                    WHERE k.status = 'approved'
                    AND u.barangay = '$barangay'
                    GROUP BY u.barangay, u.acc_id, k.id, YEAR(k.upload);";
            $tname = 'Kasabutan';    
            break;
        case 'user_birth_certificate':
            $sql = "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, b.id AS row_id, b.name AS name, b.famrole AS famrole, YEAR(b.upload) AS upload_year
                    FROM user_birth_certificate AS b
                    JOIN user_account AS u ON b.acc_id = u.acc_id
                    WHERE b.status = 'approved'
                    AND u.barangay = '$barangay'
                    GROUP BY u.barangay, u.acc_id, b.id, YEAR(b.upload);";
            $tname = 'Birth Certificate';    
            break;
        case 'user_marriage_contract':
            $sql = "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, m.id AS row_id, m.name AS name, YEAR(m.upload) AS upload_year
                    FROM user_marriage_contract AS m
                    JOIN user_account AS u ON m.acc_id = u.acc_id
                    WHERE m.status = 'approved'
                    AND u.barangay = '$barangay'
                    GROUP BY u.barangay, u.acc_id, m.id, YEAR(m.upload);";
            $tname = 'Marriage Contract';    
            break;
        case 'user_grade_cards':
            $sql = "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, g.id AS row_id, g.name AS name, YEAR(g.upload) AS upload_year
                    FROM user_grade_cards AS g
                    JOIN user_account AS u ON g.acc_id = u.acc_id
                    WHERE g.status = 'approved'
                    AND u.barangay = '$barangay'
                    GROUP BY u.barangay, u.acc_id, g.id, YEAR(g.upload);";
            $tname = 'Grade Cards';    
            break;
        case 'user_immunization_record':
            $sql = "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, i.id AS row_id, i.name AS name, YEAR(i.upload) AS upload_year
                    FROM user_immunization_record AS i
                    JOIN user_account AS u ON i.acc_id = u.acc_id
                    WHERE i.status = 'approved'
                    AND u.barangay = '$barangay'
                    GROUP BY u.barangay, u.acc_id, i.id, YEAR(i.upload);";
            $tname = 'Immunization Record';    
            break;
        case 'user_beneficiary_profile':
            $sql = "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, b.id AS row_id, YEAR(b.upload) AS upload_year
                    FROM user_beneficiary_profile AS b
                    JOIN user_account AS u ON b.acc_id = u.acc_id
                    WHERE b.status = 'approved'
                    AND u.barangay = '$barangay'
                    GROUP BY u.barangay, u.acc_id, b.id, YEAR(b.upload);";
            $tname = 'Beneficiary Profile';    
            break;
        case 'user_mdr':
            $sql = "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, m.id AS row_id, m.name AS name, YEAR(m.upload) AS upload_year
                    FROM user_mdr AS m
                    JOIN user_account AS u ON m.acc_id = u.acc_id
                    WHERE m.status = 'approved'
                    AND u.barangay = '$barangay'
                    GROUP BY u.barangay, u.acc_id, m.id, YEAR(m.upload);";
            $tname = 'MDR';    
            break;  
        case 'user_certificate':
            $sql = "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, c.id AS row_id, c.name AS name, YEAR(c.upload) AS upload_year
                    FROM user_certificate AS c
                    JOIN user_account AS u ON c.acc_id = u.acc_id
                    WHERE c.status = 'approved'
                    AND u.barangay = '$barangay'
                    GROUP BY u.barangay, u.acc_id, c.id, YEAR(c.upload);";
            $tname = 'Certificate of Attendance on Training Attended';    
            break;          
        default:
            echo 'Unknown document type!';
            exit;
    }

    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $row) {
        // Create a unique key based on fname, mname, lname
        $fullName = trim($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']);

        // Initialize the array structure if not already set
        if (!isset($result[$tname][$fullName])) {
            $result[$tname][$fullName] = [];
        }

        // Add the data to the result array
        $result[$tname][$fullName][] = [
            'id' => $row['row_id'],
            'name' => $row['name'] ?? 'Beneficiary Profile',
            'family_role' => $row['famrole'] ?? '', // handle case where famrole might not exist
            'upload_date' => $row['upload_year'],
        ];
    }
    
    $data = $result; 
    // Print the result for debugging
   /*  echo '<pre>';
    print_r($result);
    echo '</pre>'; */

    
} else {
    header('HTTP/1.1 403 Forbidden');
    echo 'Account ID not found in session.';
}

unset($pdo);

?>