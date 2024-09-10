<?php
if(isset($_SESSION['id_no'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');

    $sql = "  
    -- Step 1: Find the latest approved upload year for each user
WITH LatestApprovedYear AS (
    SELECT
        acc_id,
        YEAR(MAX(upload)) AS latest_approved_year
    FROM
        user_grade_cards
    WHERE
        status = 'approved'
    GROUP BY
        acc_id
),

-- Step 2: Get the latest approved grade card details
LatestApprovedGradeCards AS (
    SELECT
        ugc.acc_id,
        GROUP_CONCAT(ugc.id) AS grade_card_ids,
        GROUP_CONCAT(ugc.img) AS grade_card_imgs,
        GROUP_CONCAT(ugc.upload) AS grade_card_uploads  -- Added for upload
    FROM
        user_grade_cards ugc
    JOIN
        LatestApprovedYear lay
    ON
        ugc.acc_id = lay.acc_id
        AND YEAR(ugc.upload) = lay.latest_approved_year
    WHERE
        ugc.status = 'approved'
    GROUP BY
        ugc.acc_id
),

-- Step 3: Fetch the latest approved documents for each user
LatestApprovedDocuments AS (
    SELECT
        ua.acc_id,
        ua.hhid,
        ua.fname,
        ua.mname,
        ua.lname,
        ua.barangay,
        -- Fetch the latest approved user_pantawid_id document
        MAX(CASE WHEN upi.status = 'approved' THEN upi.id END) AS pantawid_id,
        MAX(CASE WHEN upi.status = 'approved' THEN upi.img END) AS pantawid_img,
        -- Similarly for other documents
        MAX(CASE WHEN ucc.status = 'approved' THEN ucc.id END) AS cash_card_id,
        MAX(CASE WHEN ucc.status = 'approved' THEN ucc.img END) AS cash_card_img,
        MAX(CASE WHEN uk.status = 'approved' THEN uk.id END) AS kasabutan_id,
        MAX(CASE WHEN uk.status = 'approved' THEN uk.img END) AS kasabutan_img,
        MAX(CASE WHEN umc.status = 'approved' THEN umc.id END) AS marriage_contract_id,
        MAX(CASE WHEN umc.status = 'approved' THEN umc.img END) AS marriage_contract_img,
        MAX(CASE WHEN um.status = 'approved' THEN um.id END) AS mdr_id,
        MAX(CASE WHEN um.status = 'approved' THEN um.img END) AS mdr_img,
        MAX(CASE WHEN uir.status = 'approved' THEN uir.id END) AS immunization_record_id,
        MAX(CASE WHEN uir.status = 'approved' THEN uir.img END) AS immunization_record_img,
        MAX(CASE WHEN uc.status = 'approved' THEN uc.id END) AS certificate_id,
        MAX(CASE WHEN uc.status = 'approved' THEN uc.img END) AS certificate_img,
        MAX(CASE WHEN fp.status = 'approved' THEN fp.id END) AS family_photo_id,
        MAX(CASE WHEN fp.status = 'approved' THEN fp.img END) AS family_photo_img,
        MAX(CASE WHEN fp.status = 'approved' THEN fp.upload END) AS family_photo_upload,  -- Added for upload
        MAX(CASE WHEN bp.status = 'approved' THEN bp.id END) AS beneficiary_profile_id,
        MAX(CASE WHEN bp.status = 'approved' THEN bp.upload END) AS beneficiary_profile_upload,  -- Added for upload
        -- Count and gather IDs and images for approved National IDs
        COUNT(DISTINCT CASE WHEN uni.status = 'approved' THEN uni.id END) AS national_id_count,
        GROUP_CONCAT(DISTINCT CASE WHEN uni.status = 'approved' THEN uni.id END) AS national_id_ids,
        GROUP_CONCAT(DISTINCT CASE WHEN uni.status = 'approved' THEN uni.img END) AS national_id_imgs,
        -- Count and gather IDs and images for approved Birth Certificates
        COUNT(DISTINCT CASE WHEN ubc.status = 'approved' THEN ubc.id END) AS birth_certificate_count,
        GROUP_CONCAT(DISTINCT CASE WHEN ubc.status = 'approved' THEN ubc.id END) AS birth_certificate_ids,
        GROUP_CONCAT(DISTINCT CASE WHEN ubc.status = 'approved' THEN ubc.img END) AS birth_certificate_imgs
    FROM
        user_account ua
    LEFT JOIN
        user_pantawid_id upi ON ua.acc_id = upi.acc_id
    LEFT JOIN
        user_cash_card ucc ON ua.acc_id = ucc.acc_id
    LEFT JOIN
        user_kasabutan uk ON ua.acc_id = uk.acc_id
    LEFT JOIN
        user_marriage_contract umc ON ua.acc_id = umc.acc_id
    LEFT JOIN
        user_mdr um ON ua.acc_id = um.acc_id
    LEFT JOIN
        user_immunization_record uir ON ua.acc_id = uir.acc_id
    LEFT JOIN
        user_certificate uc ON ua.acc_id = uc.acc_id
    LEFT JOIN
        user_family_photo fp ON ua.acc_id = fp.acc_id
    LEFT JOIN
        user_beneficiary_profile bp ON ua.acc_id = bp.acc_id
    LEFT JOIN
        user_national_id uni ON ua.acc_id = uni.acc_id
    LEFT JOIN
        user_birth_certificate ubc ON ua.acc_id = ubc.acc_id
    WHERE
        ua.status = 'active'
    GROUP BY
        ua.acc_id,
        ua.hhid,
        ua.fname,
        ua.mname,
        ua.lname,
        ua.barangay
)

-- Step 4: Combine document data with the latest approved grade card details
SELECT
    lad.acc_id,
    lad.hhid,
    lad.fname,
    lad.mname,
    lad.lname,
    lad.barangay,
    lad.pantawid_id,
    lad.pantawid_img,
    lad.cash_card_id,
    lad.cash_card_img,
    lad.kasabutan_id,
    lad.kasabutan_img,
    lad.marriage_contract_id,
    lad.marriage_contract_img,
    lad.mdr_id,
    lad.mdr_img,
    lad.immunization_record_id,
    lad.immunization_record_img,
    lad.certificate_id,
    lad.certificate_img,
    lad.family_photo_id,
    lad.family_photo_img,
    lad.family_photo_upload,  -- Added to SELECT
    lad.beneficiary_profile_id,
    lad.beneficiary_profile_upload,  -- Added to SELECT
    lad.national_id_count,
    lad.national_id_ids,
    lad.national_id_imgs,
    lad.birth_certificate_count,
    lad.birth_certificate_ids,
    lad.birth_certificate_imgs,
    lac.grade_card_ids,
    lac.grade_card_imgs,
    lac.grade_card_uploads  -- Added to SELECT
FROM
    LatestApprovedDocuments lad
LEFT JOIN
    LatestApprovedGradeCards lac ON lad.acc_id = lac.acc_id
ORDER BY
    lad.barangay, lad.hhid;
    ";


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

    // most of the table td
    function renderFileCell($userId, $fileId, $filePath, $iconClass = 'fas fa-check text-success') {
        if ($fileId === null) {
            return "<td class='text-center'>
                <i class='fas fa-times text-danger'></i>
            </td>";
        } else {
            return "<td class='text-center'>
                <a href='{$filePath}' target='_blank' class='icon-box-md cursor-pointer'>
                    <i class='{$iconClass}'></i>
                </a>
            </td>";
        }
    }

    // national id and birthcertificate td
    function renderCountCell($userId, $rowCount, $rowIds, $rowImgs, $doc_type, $iconClass = 'fas fa-check text-success') {
        if ($rowCount === 0) {
            return "<td class='text-center'>
                <i class='fas fa-times text-danger'></i>
            </td>";
        } else {
            // Convert comma-separated lists into arrays
            $ids = explode(',', $rowIds);
            $imgs = explode(',', $rowImgs);
            
            $filepath = $doc_type === 'national_id' ? '../uploads/nationalID/' : '../uploads/birthcert/';

            // Start building the HTML output
            $html = "<td class='text-center'>";
    
            // Ensure there are images to display
            if (count($ids) > 0) {
                foreach ($imgs as $index => $img) {
                    $html .= "<a href='" . $filepath . $img . "' target='_blank' class='icon-box-md cursor-pointer'>
                        <i class='fas fa-check text-success'></i>
                    </a> ";
                }
            } else {
                $html .= "<i class='fas fa-times text-danger'></i>";
            }
            
            $html .= "</td>";
            return $html;
        }
    }

    // beneficiary profile td
    function renderViewCell($userId, $rowId, $iconClass = 'fas fa-check text-success') {
        if ($rowId === null) {
            return "<td class='text-center'>
                <i class='fas fa-times text-danger'></i>
            </td>";
        } else {
            return "<td class='text-center'>
                <a href='../user/formview2.php?id={$rowId}&type=view' target='_blank' class='icon-box-md cursor-pointer'>
                    <i class='{$iconClass}'></i>
                </a>
            </td>";
        }
    }

    // grade cards td
    function renderCell($userId, $rowIds, $rowImgs, $iconClass = 'fas fa-check text-success') {
        if ($rowIds === null) {
            return "<td class='text-center'>
                <i class='fas fa-times text-danger'></i>
            </td>";
        } else {
            $imgs = explode(',', $rowImgs);
            
            $filepath = '../uploads/gradecards/';

            // Start building the HTML output
            $html = "<td class='text-center'>";
            // Ensure there are images to display
            foreach ($imgs as $index => $img) {
                $html .= "<a href='" . $filepath . $img . "' target='_blank' class='icon-box-md cursor-pointer'>
                    <i class='fas fa-check text-success'></i>
                </a> ";
            }
            $html .= "</td>";
            return $html;
        }
    }



    // all years data
    $query = "  
    -- Get approved records from user_pantawid_id
    SELECT
        ua.fname,
        ua.mname,
        ua.lname,
        ua.hhid,
        ua.barangay,
        'user_pantawid_id' AS table_name,
        upi.acc_id,
        upi.id,
        upi.img,
        upi.upload
    FROM
        user_account ua
    JOIN
        user_pantawid_id upi ON ua.acc_id = upi.acc_id
    WHERE
        ua.status = 'active'
        AND upi.status = 'approved'
    
    UNION ALL
    
    -- Get approved records from user_cash_card
    SELECT
        ua.fname,
        ua.mname,
        ua.lname,
        ua.hhid,
        ua.barangay,
        'user_cash_card' AS table_name,
        ucc.acc_id,
        ucc.id,
        ucc.img,
        ucc.upload
    FROM
        user_account ua
    JOIN
        user_cash_card ucc ON ua.acc_id = ucc.acc_id
    WHERE
        ua.status = 'active'
        AND ucc.status = 'approved'
    
    UNION ALL
    
    -- Get approved records from user_kasabutan
    SELECT
        ua.fname,
        ua.mname,
        ua.lname,
        ua.hhid,
        ua.barangay,
        'user_kasabutan' AS table_name,
        uk.acc_id,
        uk.id,
        uk.img,
        uk.upload
    FROM
        user_account ua
    JOIN
        user_kasabutan uk ON ua.acc_id = uk.acc_id
    WHERE
        ua.status = 'active'
        AND uk.status = 'approved'
    
    UNION ALL
    
    -- Get approved records from user_marriage_contract
    SELECT
        ua.fname,
        ua.mname,
        ua.lname,
        ua.hhid,
        ua.barangay,
        'user_marriage_contract' AS table_name,
        umc.acc_id,
        umc.id,
        umc.img,
        umc.upload
    FROM
        user_account ua
    JOIN
        user_marriage_contract umc ON ua.acc_id = umc.acc_id
    WHERE
        ua.status = 'active'
        AND umc.status = 'approved'
    
    UNION ALL
    
    -- Get approved records from user_mdr
    SELECT
        ua.fname,
        ua.mname,
        ua.lname,
        ua.hhid,
        ua.barangay,
        'user_mdr' AS table_name,
        um.acc_id,
        um.id,
        um.img,
        um.upload
    FROM
        user_account ua
    JOIN
        user_mdr um ON ua.acc_id = um.acc_id
    WHERE
        ua.status = 'active'
        AND um.status = 'approved'
    
    UNION ALL
    
    -- Get approved records from user_immunization_record
    SELECT
        ua.fname,
        ua.mname,
        ua.lname,
        ua.hhid,
        ua.barangay,
        'user_immunization_record' AS table_name,
        uir.acc_id,
        uir.id,
        uir.img,
        uir.upload
    FROM
        user_account ua
    JOIN
        user_immunization_record uir ON ua.acc_id = uir.acc_id
    WHERE
        ua.status = 'active'
        AND uir.status = 'approved'
    
    UNION ALL
    
    -- Get approved records from user_certificate
    SELECT
        ua.fname,
        ua.mname,
        ua.lname,
        ua.hhid,
        ua.barangay,
        'user_certificate' AS table_name,
        uc.acc_id,
        uc.id,
        uc.img,
        uc.upload
    FROM
        user_account ua
    JOIN
        user_certificate uc ON ua.acc_id = uc.acc_id
    WHERE
        ua.status = 'active'
        AND uc.status = 'approved'
    
    UNION ALL
    
    -- Get approved records from user_family_photo
    SELECT
        ua.fname,
        ua.mname,
        ua.lname,
        ua.hhid,
        ua.barangay,
        'user_family_photo' AS table_name,
        fp.acc_id,
        fp.id,
        fp.img,
        fp.upload
    FROM
        user_account ua
    JOIN
        user_family_photo fp ON ua.acc_id = fp.acc_id
    WHERE
        ua.status = 'active'
        AND fp.status = 'approved'
    
    UNION ALL
    
    -- Get approved records from user_beneficiary_profile
    SELECT
        ua.fname,
        ua.mname,
        ua.lname,
        ua.hhid,
        ua.barangay,
        'user_beneficiary_profile' AS table_name,
        bp.acc_id,
        bp.id,
        NULL AS img,  -- img column does not exist
        bp.upload
    FROM
        user_account ua
    JOIN
        user_beneficiary_profile bp ON ua.acc_id = bp.acc_id
    WHERE
        ua.status = 'active'
        AND bp.status = 'approved'
    
    UNION ALL
    
    -- Get approved records from user_national_id
    SELECT
        ua.fname,
        ua.mname,
        ua.lname,
        ua.hhid,
        ua.barangay,
        'user_national_id' AS table_name,
        uni.acc_id,
        uni.id,
        uni.img,
        uni.upload
    FROM
        user_account ua
    JOIN
        user_national_id uni ON ua.acc_id = uni.acc_id
    WHERE
        ua.status = 'active'
        AND uni.status = 'approved'
    
    UNION ALL
    
    -- Get approved records from user_birth_certificate
    SELECT
        ua.fname,
        ua.mname,
        ua.lname,
        ua.hhid,
        ua.barangay,
        'user_birth_certificate' AS table_name,
        ubc.acc_id,
        ubc.id,
        ubc.img,
        ubc.upload
    FROM
        user_account ua
    JOIN
        user_birth_certificate ubc ON ua.acc_id = ubc.acc_id
    WHERE
        ua.status = 'active'
        AND ubc.status = 'approved'
    
    UNION ALL
    
    -- Get approved records from user_grade_cards
    SELECT
        ua.fname,
        ua.mname,
        ua.lname,
        ua.hhid,
        ua.barangay,
        'user_grade_cards' AS table_name,
        ugc.acc_id,
        ugc.id,
        ugc.img,
        ugc.upload
    FROM
        user_account ua
    JOIN
        user_grade_cards ugc ON ua.acc_id = ugc.acc_id
    WHERE
        ua.status = 'active'
        AND ugc.status = 'approved'
    
    -- Order by barangay
    ORDER BY
        barangay, hhid;        
    ";


    // Execute the query
    $statement = $pdo->query($query);
    $outputs = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Transform outputs into hierarchical array structure
    $barangayGroups1 = [];

    foreach ($outputs as $row) {
        $barangay = $row['barangay'];
        $nameKey = $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'] . ' (' . $row['hhid'] . ')';
        
        if (!isset($barangayGroups1[$barangay])) {
            $barangayGroups1[$barangay] = [];
        }
        
        if (!isset($barangayGroups1[$barangay][$nameKey])) {
            $barangayGroups1[$barangay][$nameKey] = [];
        }
        
        $table = $row['table_name'];
        
        if (!isset($barangayGroups1[$barangay][$nameKey][$table])) {
            $barangayGroups1[$barangay][$nameKey][$table] = [];
        }
        
        $barangayGroups1[$barangay][$nameKey][$table][] = [
            'id' => $row['id'],
            'img' => $row['img'],
            'upload' => $row['upload']
        ];
    }
    $data = $barangayGroups1;


} else {
    echo "Account ID not found in session.";
    echo "<script>window.location='pages/login.php';</script>";
}

unset($pdo);

?>