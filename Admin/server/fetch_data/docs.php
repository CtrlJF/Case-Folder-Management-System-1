<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once(__DIR__ . '/../../../libraries/database.php');

    $hhid = $_POST['user_hhid'];
    /* $hhid = 123456789123412334; */
    $sql = "
        WITH approved_data AS (
            -- Retrieve all approved records with additional details from each table
            SELECT acc_id, 'National ID' AS table_name, id, name, famrole, img, upload FROM user_national_id WHERE status = 'approved'
            UNION ALL
            SELECT acc_id, 'Pantawid ID' AS table_name, id, name, NULL AS famrole, img, upload FROM user_pantawid_id WHERE status = 'approved'
            UNION ALL
            SELECT acc_id, 'Cash Card' AS table_name, id, name, NULL AS famrole, img, upload FROM user_cash_card WHERE status = 'approved'
            UNION ALL
            SELECT acc_id, 'Family Picture' AS table_name, id, name, NULL AS famrole, img, upload FROM user_family_photo WHERE status = 'approved'
            UNION ALL
            SELECT acc_id, 'Kasabutan' AS table_name, id, name, NULL AS famrole, img, upload FROM user_kasabutan WHERE status = 'approved'
            UNION ALL
            SELECT acc_id, 'Birth Certificate' AS table_name, id, name, famrole, img, upload FROM user_birth_certificate WHERE status = 'approved'
            UNION ALL
            SELECT acc_id, 'Marriage Contract' AS table_name, id, name, NULL AS famrole, img, upload FROM user_marriage_contract WHERE status = 'approved'
            UNION ALL
            SELECT acc_id, 'Immunization Record' AS table_name, id, name, NULL AS famrole, img, upload FROM user_immunization_record WHERE status = 'approved'
            UNION ALL
            SELECT acc_id, 'Grade Cards' AS table_name, id, name, NULL AS famrole, img, upload FROM user_grade_cards WHERE status = 'approved'
            UNION ALL
            SELECT acc_id, 'MDR' AS table_name, id, name, NULL AS famrole, img, upload FROM user_mdr WHERE status = 'approved'
            UNION ALL
            SELECT acc_id, 'Certificate of Attendance on Training Attended' AS table_name, id, name, NULL AS famrole, img, upload FROM user_certificate WHERE status = 'approved'
            UNION ALL
            SELECT acc_id, 'Beneficiary Profile' AS table_name, id, NULL AS name, NULL AS famrole, NULL AS img, upload FROM user_beneficiary_profile WHERE status = 'approved'
        ),
        inactive_users AS (
            -- Retrieve the specific inactive user
            SELECT
                ua.acc_id,
                ua.fname,
                ua.mname,
                ua.lname,
                ua.hhid
            FROM
                user_account ua
            WHERE
                ua.status = 'inactive'
                AND ua.hhid = '$hhid'  -- Specify the specific hhid here
        )
        -- Combine inactive users with their approved data, including additional details
        SELECT
            iu.acc_id,
            iu.fname,
            iu.mname,
            iu.lname,
            iu.hhid,
            ad.table_name,
            ad.id AS id,
            COALESCE(ad.name, 'Beneficiary Profile') AS name,
            COALESCE(ad.img, ' ') AS img,
            COALESCE(ad.famrole, ' ') AS role,
            ad.upload AS upload
        FROM
            inactive_users iu
        LEFT JOIN
            approved_data ad ON iu.acc_id = ad.acc_id
        ORDER BY
            iu.hhid, ad.table_name, ad.id;    
    ";

    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $data = [];
    foreach ($rows as $row) {
        $hhid = $row['hhid'];
        if (!isset($data[$hhid])) {
            $data[$hhid] = [
                'acc_id' => $row['acc_id'],
                'fullname' => $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'],
                'approved_data' => []
            ];
        }
        $data[$hhid]['approved_data'][] = [
            'table_name' => $row['table_name'],
            'id' => $row['id'],
            'name' => $row['name'],
            'img' => $row['img'],
            'role' => $row['role'],
            'upload' => $row['upload']
        ];
    }

    $directories = [
        'National ID' => '../uploads/nationalID/',
        'Family Picture' => '../uploads/fampick/',
        'Pantawid ID' => '../uploads/pantawidID/',
        'Cash Card' => '../uploads/cashcard/',
        'Kasabutan' => '../uploads/kasabutan/',
        'Birth Certificate' => '../uploads/birthcert/',
        'Marriage Contract' => '../uploads/marriagecont/',
        'Immunization Record' => '../uploads/immurec/',
        'Grade Cards' => '../uploads/gradecards/',
        'MDR' => '../uploads/mdr/',
        'Certificate of Attendance on Training Attended' => '../uploads/certattend/',
        'Beneficiary Profile' => '../user/formview2.php?id='
    ];

    // Generate HTML content
    $html = '<div class="container">'; // Start with a container if needed for padding/margin
    $html .= '<div class="row">'; // Start the row container

    foreach ($data as $hhid => $user) {
        foreach ($user['approved_data'] as $doc) {
            // Determine the image path
            $imagePath = ($doc['table_name'] === 'Beneficiary Profile') 
                ? $directories[$doc['table_name']] . $doc['id'] . '&type=view' 
                : (isset($directories[$doc['table_name']]) 
                    ? $directories[$doc['table_name']] . htmlspecialchars($doc['img']) 
                    : '#');

            // Check if the document is a PDF
            $isPdf = strtolower(pathinfo($doc['img'], PATHINFO_EXTENSION)) === 'pdf';

            // Append the document HTML
            $html .= '<div class="col-lg-2 col-md-4 col-sm-6 mb-4">';
            $html .= '<div class="card">';
            $html .= '<div class="card-body">';
            if ($doc['table_name'] === 'Beneficiary Profile') {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="assets/images/bp.png" class="card-img-top img-fluid" alt="' . htmlspecialchars($doc['table_name']) . '"> </a>';
            } else if ($isPdf) {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="assets/images/pdf.png" class="card-img-top img-fluid" alt="' . htmlspecialchars($doc['table_name']) . '"> </a>';
            } else {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="' . htmlspecialchars($imagePath) . '" class="card-img-top img-fluid" alt="' . htmlspecialchars($doc['table_name']) . '"> </a>';
            }
            $html .= '<p class="text-center mt-1">';
            $html .= '<span><i>' . htmlspecialchars($doc['table_name']) . '</i></span><br>';
            $html .= '<span><strong>Name:</strong> ' . htmlspecialchars($doc['name']) . '</span><br>';
            $html .= '<span><strong>Year:</strong> ' . htmlspecialchars($doc['upload']) . '</span><br>';

            if (isset($doc['role']) && trim($doc['role']) !== '') {
                $html .= '<strong><span>Family Role:</strong> ' . htmlspecialchars($doc['role']) . '</span>';
            }

            $html .= '</p>';
            $html .= '</div>'; // Close card-body
            $html .= '</div>'; // Close card
            $html .= '</div>'; // Close column
        }
    }

    $html .= '</div>'; // Close row
    $html .= '</div>'; // Close container
    echo $html;

    // Print the results in a formatted way for testing
   /*  echo '<pre>';
    print_r($data);
    echo '</pre>'; */
    
    
} 

/* $imgUrl = ($directories[$doc['table_name']] === 'Beneficiary Profile') ? $directories[$doc['table_name']] . $id . '&type=view': (isset($directories[$type]) ? $directories[$type] . $img : '#'); */
unset($pdo);

?>