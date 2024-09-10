<?php
if(isset($_SESSION['id_no'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');

    // Queries to execute
$queries = [
    'user_national_id' => "SELECT u.barangay, YEAR(n.upload) AS upload_year, COUNT(*) AS total_count
                           FROM user_national_id AS n
                           JOIN user_account AS u ON n.acc_id = u.acc_id
                           WHERE n.status = 'approved'
                           GROUP BY u.barangay, YEAR(n.upload)",
    'user_pantawid_id' => "SELECT u.barangay, YEAR(p.upload) AS upload_year, COUNT(*) AS total_count
                           FROM user_pantawid_id AS p
                           JOIN user_account AS u ON p.acc_id = u.acc_id
                           WHERE p.status = 'approved'
                           GROUP BY u.barangay, YEAR(p.upload)",
    'user_cash_card' => "SELECT u.barangay, YEAR(c.upload) AS upload_year, COUNT(*) AS total_count
                         FROM user_cash_card AS c
                         JOIN user_account AS u ON c.acc_id = u.acc_id
                         WHERE c.status = 'approved'
                         GROUP BY u.barangay, YEAR(c.upload)",
    'user_kasabutan' => "SELECT u.barangay, YEAR(k.upload) AS upload_year, COUNT(*) AS total_count
                         FROM user_kasabutan AS k
                         JOIN user_account AS u ON k.acc_id = u.acc_id
                         WHERE k.status = 'approved'
                         GROUP BY u.barangay, YEAR(k.upload)",
    'user_mdr' => "SELECT u.barangay, YEAR(m.upload) AS upload_year, COUNT(*) AS total_count
                   FROM user_mdr AS m
                   JOIN user_account AS u ON m.acc_id = u.acc_id
                   WHERE m.status = 'approved'
                   GROUP BY u.barangay, YEAR(m.upload)",
    'user_certificate' => "SELECT u.barangay, YEAR(c.upload) AS upload_year, COUNT(*) AS total_count
                           FROM user_certificate AS c
                           JOIN user_account AS u ON c.acc_id = u.acc_id
                           WHERE c.status = 'approved'
                           GROUP BY u.barangay, YEAR(c.upload)",
    'user_marriage_contract' => "SELECT u.barangay, YEAR(m.upload) AS upload_year, COUNT(*) AS total_count
                                 FROM user_marriage_contract AS m
                                 JOIN user_account AS u ON m.acc_id = u.acc_id
                                 WHERE m.status = 'approved'
                                 GROUP BY u.barangay, YEAR(m.upload)",
    'user_grade_cards' => "SELECT u.barangay, YEAR(g.upload) AS upload_year, COUNT(*) AS total_count
                           FROM user_grade_cards AS g
                           JOIN user_account AS u ON g.acc_id = u.acc_id
                           WHERE g.status = 'approved'
                           GROUP BY u.barangay, YEAR(g.upload)",
    'user_immunization_record' => "SELECT u.barangay, YEAR(i.upload) AS upload_year, COUNT(*) AS total_count
                                   FROM user_immunization_record AS i
                                   JOIN user_account AS u ON i.acc_id = u.acc_id
                                   WHERE i.status = 'approved'
                                   GROUP BY u.barangay, YEAR(i.upload)",
    'user_family_photo' => "SELECT u.barangay, YEAR(f.upload) AS upload_year, COUNT(*) AS total_count
                            FROM user_family_photo AS f
                            JOIN user_account AS u ON f.acc_id = u.acc_id
                            WHERE f.status = 'approved'
                            GROUP BY u.barangay, YEAR(f.upload)",
    'user_birth_certificate' => "SELECT u.barangay, YEAR(b.upload) AS upload_year, COUNT(*) AS total_count
                                 FROM user_birth_certificate AS b
                                 JOIN user_account AS u ON b.acc_id = u.acc_id
                                 WHERE b.status = 'approved'
                                 GROUP BY u.barangay, YEAR(b.upload)",
    'user_beneficiary_profile' => "SELECT u.barangay, YEAR(b.upload) AS upload_year, COUNT(*) AS total_count
                                   FROM user_beneficiary_profile AS b
                                   JOIN user_account AS u ON b.acc_id = u.acc_id
                                   WHERE b.status = 'approved'
                                   GROUP BY u.barangay, YEAR(b.upload)"
];

    // Initialize an array to store results
    $barangayGroups = [];

    // Execute each query and process results
    foreach ($queries as $docType => $query) {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($data as $row) {
            $barangay = $row['barangay'];
            $count = $row['total_count'];
            $uploadYear = $row['upload_year']; // Get the year from the query result

            if (!isset($barangayGroups[$barangay])) {
                $barangayGroups[$barangay] = []; // Initialize empty array for each barangay
            }
            
            // Initialize yearly count if not set
            if (!isset($barangayGroups[$barangay][$uploadYear])) {
                $barangayGroups[$barangay][$uploadYear] = [
                    'National ID' => 0,
                    'Family Picture' => 0,
                    'Pantawid ID' => 0,
                    'Cash Card' => 0,
                    'Kasabutan' => 0,
                    'Birth Certificate' => 0,
                    'Marriage Contract' => 0,
                    'Immunization Record' => 0,
                    'Grade Cards' => 0,
                    'MDR' => 0,
                    'Attendance on Training' => 0,
                    'Beneficiary Profile' => 0,
                ];
            }
            
            // Map document type to the corresponding name
            $docTypeMap = [
                'user_national_id' => 'National ID',
                'user_family_photo' => 'Family Picture',
                'user_pantawid_id' => 'Pantawid ID',
                'user_cash_card' => 'Cash Card',
                'user_kasabutan' => 'Kasabutan',
                'user_birth_certificate' => 'Birth Certificate',
                'user_marriage_contract' => 'Marriage Contract',
                'user_grade_cards' => 'Grade Cards',
                'user_immunization_record' => 'Immunization Record',
                'user_beneficiary_profile' => 'Beneficiary Profile',
                'user_mdr' => 'MDR',
                'user_certificate' => 'Attendance on Training',
            ];
            
            $documentType = isset($docTypeMap[$docType]) ? $docTypeMap[$docType] : $docType;

            if (isset($barangayGroups[$barangay][$uploadYear][$documentType])) {
                $barangayGroups[$barangay][$uploadYear][$documentType] += $count;
            }
        }
    }
    // Get the selected year from the request (default to the current year)
    $selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : null;

    // Capture the selected barangay if needed for the filtering
    $selectedBarangay = isset($_GET['barangay']) ? $_GET['barangay'] : null;

    $_SESSION['rbrgy'] =  $selectedBarangay;
    $_SESSION['ryear'] =  $selectedYear;

} else {
    echo "Account ID not found in session.";
    echo "<script>window.location='pages/login.php';</script>";
}

unset($pdo);
?>