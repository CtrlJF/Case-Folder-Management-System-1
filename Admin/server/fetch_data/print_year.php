<?php
if(isset($_SESSION['id_no'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');

    // Initialize the result array
    $result = [];

    // Define the barangay
    /* $barangay = 'Barangay 10';
    $year = 2024; */
    // queries to get all the table data
    $queries = [
        'Natioinal ID' => "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, n.id AS row_id, n.name AS name, n.famrole AS famrole, YEAR(n.upload) AS upload_year
                                FROM user_national_id AS n
                                JOIN user_account AS u ON n.acc_id = u.acc_id
                                WHERE n.status = 'approved'
                                AND YEAR(n.upload) = '$year'
                                AND u.barangay = '$barangay'
                                GROUP BY u.barangay, u.acc_id, n.id, YEAR(n.upload);",
        'Pantawid ID' => "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, p.id AS row_id, p.name AS name, YEAR(p.upload) AS upload_year
                                FROM user_pantawid_id AS p
                                JOIN user_account AS u ON p.acc_id = u.acc_id
                                WHERE p.status = 'approved'
                                AND YEAR(p.upload) = '$year'
                                AND u.barangay = '$barangay'
                                GROUP BY u.barangay, u.acc_id, p.id, YEAR(p.upload);",
        'Cash Card' => "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, c.id AS row_id, c.name AS name, YEAR(c.upload) AS upload_year
                                FROM user_cash_card AS c
                                JOIN user_account AS u ON c.acc_id = u.acc_id
                                WHERE c.status = 'approved'
                                AND YEAR(c.upload) = '$year'
                                AND u.barangay = '$barangay'
                                GROUP BY u.barangay, u.acc_id, c.id, YEAR(c.upload);",
        'Kasabutan' => "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, k.id AS row_id, k.name AS name, YEAR(k.upload) AS upload_year
                                FROM user_kasabutan AS k
                                JOIN user_account AS u ON k.acc_id = u.acc_id
                                WHERE k.status = 'approved'
                                AND YEAR(k.upload) = '$year'
                                AND u.barangay = '$barangay'
                                GROUP BY u.barangay, u.acc_id, k.id, YEAR(k.upload);",
        'MDR' => "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, m.id AS row_id, m.name AS name, YEAR(m.upload) AS upload_year
                        FROM user_mdr AS m
                        JOIN user_account AS u ON m.acc_id = u.acc_id
                        WHERE m.status = 'approved'
                        AND YEAR(m.upload) = '$year'
                        AND u.barangay = '$barangay'
                        GROUP BY u.barangay, u.acc_id, m.id, YEAR(m.upload);",
        'Certificate Of Attendance On Training Attended' => "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, c.id AS row_id, c.name AS name, YEAR(c.upload) AS upload_year
                                                    FROM user_certificate AS c
                                                    JOIN user_account AS u ON c.acc_id = u.acc_id
                                                    WHERE c.status = 'approved'
                                                    AND YEAR(c.upload) = '$year'
                                                    AND u.barangay = '$barangay'
                                                    GROUP BY u.barangay, u.acc_id, c.id, YEAR(c.upload);",
        'Marriage Contract' => "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, m.id AS row_id, m.name AS name, YEAR(m.upload) AS upload_year
                                        FROM user_marriage_contract AS m
                                        JOIN user_account AS u ON m.acc_id = u.acc_id
                                        WHERE m.status = 'approved'
                                        AND YEAR(m.upload) = '$year'
                                        AND u.barangay = '$barangay'
                                        GROUP BY u.barangay, u.acc_id, m.id, YEAR(m.upload);",
        'Grade Cards' => "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, g.id AS row_id, g.name AS name, YEAR(g.upload) AS upload_year
                                FROM user_grade_cards AS g
                                JOIN user_account AS u ON g.acc_id = u.acc_id
                                WHERE g.status = 'approved'
                                AND YEAR(g.upload) = '$year'
                                AND u.barangay = '$barangay'
                                GROUP BY u.barangay, u.acc_id, g.id, YEAR(g.upload);",
        'Immunization Record' => "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, i.id AS row_id, i.name AS name, YEAR(i.upload) AS upload_year
                                        FROM user_immunization_record AS i
                                        JOIN user_account AS u ON i.acc_id = u.acc_id
                                        WHERE i.status = 'approved'
                                        AND YEAR(i.upload) = '$year'
                                        AND u.barangay = '$barangay'
                                        GROUP BY u.barangay, u.acc_id, i.id, YEAR(i.upload);",
        'Family Photo' => "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, f.id AS row_id, f.name AS name, YEAR(f.upload) AS upload_year
                                FROM user_family_photo AS f
                                JOIN user_account AS u ON f.acc_id = u.acc_id
                                WHERE f.status = 'approved'
                                AND YEAR(f.upload) = '$year'
                                AND u.barangay = '$barangay'
                                GROUP BY u.barangay, u.acc_id, f.id, YEAR(f.upload);",
        'Birth Certificate' => "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, b.id AS row_id, b.name AS name, b.famrole AS famrole, YEAR(b.upload) AS upload_year
                                    FROM user_birth_certificate AS b
                                    JOIN user_account AS u ON b.acc_id = u.acc_id
                                    WHERE b.status = 'approved'
                                    AND YEAR(b.upload) = '$year'
                                    AND u.barangay = '$barangay'
                                    GROUP BY u.barangay, u.acc_id, b.id, YEAR(b.upload);",
        'Beneficiary Profile' => "SELECT u.barangay, u.acc_id, u.hhid, u.fname, u.mname, u.lname, b.id AS row_id, YEAR(b.upload) AS upload_year
                                        FROM user_beneficiary_profile AS b
                                        JOIN user_account AS u ON b.acc_id = u.acc_id
                                        WHERE b.status = 'approved'
                                        AND YEAR(b.upload) = '$year'
                                        AND u.barangay = '$barangay'
                                        GROUP BY u.barangay, u.acc_id, b.id, YEAR(b.upload);"
    ];


    // Run the queries and process results
    foreach ($queries as $docType => $query) {
        // Execute the query (assume $pdo is your database connection)
        $stmt = $pdo->query($query);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($data as $row) {
            // Create a unique key based on fname, mname, lname
            $fullName = trim($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']);
    
            // Initialize the array structure if not already set
            if (!isset($result[$barangay][$docType][$fullName])) {
                $result[$barangay][$docType][$fullName] = [];
            }
    
            // Add the data to the result array
            $result[$barangay][$docType][$fullName][] = [
                'id' => $row['row_id'],
                'name' => $row['name'] ?? 'Beneficiary Profile',
                'family_role' => $row['famrole'] ?? '', // handle case where famrole might not exist
                'upload_date' => $row['upload_year'],
            ];
        }
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