<?php
if(isset($_SESSION['id_no'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');

    // Queries to execute
$queries = [
    'user_national_id' => "SELECT n.acc_id, u.hhid, u.fname, u.mname, u.lname, n.id, n.img, n.remarks
                            FROM user_national_id AS n
                            JOIN user_account AS u ON n.acc_id = u.acc_id
                            WHERE n.status = 'pending' AND u.status IN ('active', 'inactive')
                            ORDER BY u.fname;",
    'user_pantawid_id' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, p.id, p.img, p.remarks
                            FROM user_pantawid_id AS p
                            JOIN user_account AS u ON p.acc_id = u.acc_id
                            WHERE p.status = 'pending' AND u.status IN ('active', 'inactive')
                            ORDER BY u.fname;",
    'user_cash_card' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, c.id, c.img, c.remarks
                            FROM user_cash_card AS c
                            JOIN user_account AS u ON c.acc_id = u.acc_id
                            WHERE c.status = 'pending' AND u.status IN ('active', 'inactive')
                            ORDER BY u.fname;",
    'user_kasabutan' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, k.id, k.img, k.remarks
                            FROM user_kasabutan AS k
                            JOIN user_account AS u ON k.acc_id = u.acc_id
                            WHERE k.status = 'pending' AND u.status IN ('active', 'inactive')
                            ORDER BY u.fname;",
    'user_mdr' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, m.id, m.img, m.remarks
                    FROM user_mdr AS m
                    JOIN user_account AS u ON m.acc_id = u.acc_id
                    WHERE m.status = 'pending' AND u.status IN ('active', 'inactive')
                    ORDER BY u.fname;",
    'user_certificate' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, c.id, c.img, c.remarks
                            FROM user_certificate AS c
                            JOIN user_account AS u ON c.acc_id = u.acc_id
                            WHERE c.status = 'pending' AND u.status IN ('active', 'inactive')
                            ORDER BY u.fname;",
    'user_marriage_contract' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, m.id, m.img, m.remarks
                                    FROM user_marriage_contract AS m
                                    JOIN user_account AS u ON m.acc_id = u.acc_id
                                    WHERE m.status = 'pending' AND u.status IN ('active', 'inactive')
                                    ORDER BY u.fname;",
    'user_grade_cards' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, g.id, g.img, g.remarks
                            FROM user_grade_cards AS g
                            JOIN user_account AS u ON g.acc_id = u.acc_id
                            WHERE g.status = 'pending' AND u.status IN ('active', 'inactive')
                            ORDER BY u.fname;",
    'user_immunization_record' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, i.id, i.img, i.remarks
                                    FROM user_immunization_record AS i
                                    JOIN user_account AS u ON i.acc_id = u.acc_id
                                    WHERE i.status = 'pending' AND u.status IN ('active', 'inactive')
                                    ORDER BY u.fname;",
    'user_family_photo' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, f.id, f.img, f.remarks
                            FROM user_family_photo AS f
                            JOIN user_account AS u ON f.acc_id = u.acc_id
                            WHERE f.status = 'pending' AND u.status IN ('active', 'inactive')
                            ORDER BY u.fname;",
    'user_birth_certificate' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, b.id, b.img, b.remarks
                                FROM user_birth_certificate AS b
                                JOIN user_account AS u ON b.acc_id = u.acc_id
                                WHERE b.status = 'pending' AND u.status IN ('active', 'inactive')
                                ORDER BY u.fname;",
    'user_beneficiary_profile' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, b.id, b.upload, b.remarks
                                    FROM user_beneficiary_profile AS b
                                    JOIN user_account AS u ON b.acc_id = u.acc_id
                                    WHERE b.status = 'pending' AND u.status IN ('active', 'inactive')
                                    ORDER BY u.fname;"
    ];

    // Initialize an array to store results
    $docGroups = [];

    // Execute each query and process results
    foreach ($queries as $docType => $query) {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Store the result in the $docGroups array
        $docGroups[$docType] = $data;
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

     $docDirectory = [
        'user_national_id' => '../uploads/nationalID/',
        'user_family_photo' => '../uploads/fampick/',
        'user_pantawid_id' => '../uploads/pantawidID/',
        'user_cash_card' => '../uploads/cashcard/',
        'user_kasabutan' => '../uploads/kasabutan/',
        'user_birth_certificate' => '../uploads/birthcert/',
        'user_marriage_contract' => '../uploads/marriagecont/',
        'user_grade_cards' => '../uploads/gradecards/',
        'user_immunization_record' => '../uploads/immurec/',
        'user_beneficiary_profile' => '../user/formview2.php?id=',
        'user_mdr' => '../uploads/mdr/',
        'user_certificate' => '../uploads/certattend/',
    ];

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