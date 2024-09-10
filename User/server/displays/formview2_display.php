<?php
if (isset($_GET['id'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');
    
    $id = intval($_GET['id']); // Sanitize the ID
    
    function formathhid($hhid) {
        // Assuming $hhid is a string with 18 characters
        return substr($hhid, 0, 9) . '-' . substr($hhid, 9, 4) . '-' . substr($hhid, 13);
    }

    if (empty($id)) {
        echo "<script>alert('Invalid input!');</script>";
        exit;
    }

    $sql = "
SELECT
    ubp.id AS beneficiary_id,
    ubp.probinsya,
    ubp.lungsod,
    ubp.barangay,
    ubp.purok,
    ubp.household_id,
    ubp.membro_tribo,
    ubp.name_tribo,
    ubp.relihiyon,
    ubp.family_size,
    ubp.philhealth,
    ubp.usergrant,
    ubp.account_num,
    ubp.hh_status,
    ubp.daily_income,
    ubp.use_money,
    ubp.upload,
    ubp.status AS beneficiary_status,
    ubp.remarks,
    ubp.acc_id,
    bcr.id AS cash_received_id,
    bcr.year,
    bcr.dec_jan,
    bcr.feb_mar,
    bcr.apr_may,
    bcr.june_jul,
    bcr.aug_sept,
    bcr.oct_nov,
    bhm.id AS member_id,
    bhm.lname,
    bhm.fname,
    bhm.mname,
    bhm.birthday,
    bhm.gender,
    bhm.family_relation,
    bhm.civil_status,
    bhm.buntis,
    bhm.school,
    bhm.grade,
    bhm.register_grant,
    bhm.livelihood
FROM
    user_beneficiary_profile ubp
LEFT JOIN
    bp_cash_received bcr ON ubp.id = bcr.bp_id
LEFT JOIN
    bp_hh_member bhm ON ubp.id = bhm.bp_id
WHERE
    ubp.id = :id;
";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize the structure
    $data = [
        'beneficiary_profile' => [
            'info' => [
                'cash_received' => [],
                'hh_member' => []
            ]
        ]
    ];

    // Temporary arrays to store cash received and hh member data
$cashReceived = [];
$hhMembers = [];

// Flag to track if beneficiary profile has been added
$beneficiaryAdded = false;

// Process results
foreach ($results as $row) {
    // Add beneficiary profile info only once
    if (!$beneficiaryAdded) {
        $data['beneficiary_profile']['info'] = [
            'beneficiary_id' => $row['beneficiary_id'],
            'probinsya' => $row['probinsya'],
            'lungsod' => $row['lungsod'],
            'barangay' => $row['barangay'],
            'purok' => $row['purok'],
            'household_id' => $row['household_id'],
            'membro_tribo' => $row['membro_tribo'],
            'name_tribo' => $row['name_tribo'],
            'relihiyon' => $row['relihiyon'],
            'family_size' => $row['family_size'],
            'philhealth' => $row['philhealth'],
            'usergrant' => $row['usergrant'],
            'account_num' => $row['account_num'],
            'hh_status' => $row['hh_status'],
            'daily_income' => $row['daily_income'],
            'use_money' => $row['use_money'],
            'upload' => $row['upload'],
            'status' => $row['beneficiary_status'],
            'remarks' => $row['remarks'],
            'acc_id' => $row['acc_id']
        ];
        $beneficiaryAdded = true; // Set flag to true to avoid duplication
    }

    // Aggregate cash_received data
    if ($row['cash_received_id']) {
        $cashReceived[$row['cash_received_id']] = [
            'cash_received_id' => $row['cash_received_id'],
            'year' => $row['year'],
            'dec_jan' => $row['dec_jan'],
            'feb_mar' => $row['feb_mar'],
            'apr_may' => $row['apr_may'],
            'june_jul' => $row['june_jul'],
            'aug_sept' => $row['aug_sept'],
            'oct_nov' => $row['oct_nov']
        ];
    }

    // Aggregate hh_member data
    if ($row['member_id']) {
        $hhMembers[$row['member_id']] = [
            'member_id' => $row['member_id'],
            'lname' => $row['lname'],
            'fname' => $row['fname'],
            'mname' => $row['mname'],
            'birthday' => $row['birthday'],
            'gender' => $row['gender'],
            'family_relation' => $row['family_relation'],
            'civil_status' => $row['civil_status'],
            'buntis' => $row['buntis'],
            'school' => $row['school'],
            'grade' => $row['grade'],
            'register_grant' => $row['register_grant'],
            'livelihood' => $row['livelihood']
        ];
    }
}

// Assign the aggregated data to the final structure
$data['beneficiary_profile']['info']['cash_received'] = array_values($cashReceived);
$data['beneficiary_profile']['info']['hh_member'] = array_values($hhMembers);

    // Output the structured data
  /*   echo '<pre>';
    print_r($data);
    echo '</pre>'; */

}

// Close database connection
unset($pdo);

?>