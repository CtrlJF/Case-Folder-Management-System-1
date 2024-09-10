<?php
session_start();
if(isset($_SESSION['id_no'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');

    $queries = [
        'user_national_id' => "SELECT COUNT(*) AS count
                               FROM user_national_id AS n
                               JOIN user_account AS u ON n.acc_id = u.acc_id
                               WHERE n.status = 'pending' AND u.status IN ('active', 'inactive');",
        'user_pantawid_id' => "SELECT COUNT(*) AS count
                               FROM user_pantawid_id AS p
                               JOIN user_account AS u ON p.acc_id = u.acc_id
                               WHERE p.status = 'pending' AND u.status IN ('active', 'inactive');",
        'user_cash_card' => "SELECT COUNT(*) AS count
                             FROM user_cash_card AS c
                             JOIN user_account AS u ON c.acc_id = u.acc_id
                             WHERE c.status = 'pending' AND u.status IN ('active', 'inactive');",
        'user_kasabutan' => "SELECT COUNT(*) AS count
                             FROM user_kasabutan AS k
                             JOIN user_account AS u ON k.acc_id = u.acc_id
                             WHERE k.status = 'pending' AND u.status IN ('active', 'inactive');",
        'user_mdr' => "SELECT COUNT(*) AS count
                        FROM user_mdr AS m
                        JOIN user_account AS u ON m.acc_id = u.acc_id
                        WHERE m.status = 'pending' AND u.status IN ('active', 'inactive');",
        'user_certificate' => "SELECT COUNT(*) AS count
                               FROM user_certificate AS c
                               JOIN user_account AS u ON c.acc_id = u.acc_id
                               WHERE c.status = 'pending' AND u.status IN ('active', 'inactive');",
        'user_marriage_contract' => "SELECT COUNT(*) AS count
                                      FROM user_marriage_contract AS m
                                      JOIN user_account AS u ON m.acc_id = u.acc_id
                                      WHERE m.status = 'pending' AND u.status IN ('active', 'inactive');",
        'user_grade_cards' => "SELECT COUNT(*) AS count
                               FROM user_grade_cards AS g
                               JOIN user_account AS u ON g.acc_id = u.acc_id
                               WHERE g.status = 'pending' AND u.status IN ('active', 'inactive');",
        'user_immunization_record' => "SELECT COUNT(*) AS count
                                       FROM user_immunization_record AS i
                                       JOIN user_account AS u ON i.acc_id = u.acc_id
                                       WHERE i.status = 'pending' AND u.status IN ('active', 'inactive');",
        'user_family_photo' => "SELECT COUNT(*) AS count
                               FROM user_family_photo AS f
                               JOIN user_account AS u ON f.acc_id = u.acc_id
                               WHERE f.status = 'pending' AND u.status IN ('active', 'inactive');",
        'user_birth_certificate' => "SELECT COUNT(*) AS count
                                     FROM user_birth_certificate AS b
                                     JOIN user_account AS u ON b.acc_id = u.acc_id
                                     WHERE b.status = 'pending' AND u.status IN ('active', 'inactive');",
        'user_beneficiary_profile' => "SELECT COUNT(*) AS count
                                       FROM user_beneficiary_profile AS b
                                       JOIN user_account AS u ON b.acc_id = u.acc_id
                                       WHERE b.status = 'pending' AND u.status IN ('active', 'inactive');"
    ];

    // Initialize a variable to store the total count
    $totalCount = 0;

    foreach ($queries as $docType => $query) {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Add the count from this query to the total count
        $totalCount += (int)$row['count'];
    }

    // Output the total count
    echo $totalCount;
    
} else {
    header('HTTP/1.1 403 Forbidden');
    echo 'Account ID not found in session.';
}

unset($pdo);

?>