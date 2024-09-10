<?php
// Usage
if(isset($_SESSION['id_no'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');

    $queries = [
        'user_gis' => "SELECT ua.acc_id, ua.hhid, ua.fname, ua.mname, ua.lname, ua.barangay, 
                              ug.id AS gis_id, ug.name AS gis_name, ug.upload_date, ug.img
                        FROM 
                            user_account ua
                        LEFT JOIN 
                            user_gis ug ON ua.acc_id = ug.acc_id AND YEAR(ug.upload_date) = YEAR(CURDATE())
                        WHERE 
                            YEAR(CURDATE()) = YEAR(ug.upload_date) OR ug.upload_date IS NULL;",
        'user_pantawid_id' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, p.id, p.img, p.remarks
                                FROM user_pantawid_id AS p
                                JOIN user_account AS u ON p.acc_id = u.acc_id
                                WHERE p.status = 'pending'
                                ORDER BY u.fname;",
        'user_cash_card' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, c.id, c.img, c.remarks
                                FROM user_cash_card AS c
                                JOIN user_account AS u ON c.acc_id = u.acc_id
                                WHERE c.status = 'pending'
                                ORDER BY u.fname;",
        'user_kasabutan' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, k.id, k.img, k.remarks
                                FROM user_kasabutan AS k
                                JOIN user_account AS u ON k.acc_id = u.acc_id
                                WHERE k.status = 'pending'
                                ORDER BY u.fname;",
        'user_mdr' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, m.id, m.img, m.remarks
                        FROM user_mdr AS m
                        JOIN user_account AS u ON m.acc_id = u.acc_id
                        WHERE m.status = 'pending'
                        ORDER BY u.fname;",
        'user_certificate' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, c.id, c.img, c.remarks
                                FROM user_certificate AS c
                                JOIN user_account AS u ON c.acc_id = u.acc_id
                                WHERE c.status = 'pending'
                                ORDER BY u.fname;",
        'user_marriage_contract' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, m.id, m.img, m.remarks
                                        FROM user_marriage_contract AS m
                                        JOIN user_account AS u ON m.acc_id = u.acc_id
                                        WHERE m.status = 'pending'
                                        ORDER BY u.fname;",
        'user_grade_cards' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, g.id, g.img, g.remarks
                                FROM user_grade_cards AS g
                                JOIN user_account AS u ON g.acc_id = u.acc_id
                                WHERE g.status = 'pending'
                                ORDER BY u.fname;",
        'user_immunization_record' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, i.id, i.img, i.remarks
                                        FROM user_immunization_record AS i
                                        JOIN user_account AS u ON i.acc_id = u.acc_id
                                        WHERE i.status = 'pending'
                                        ORDER BY u.fname;",
        'user_family_photo' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, f.id, f.img, f.remarks
                                FROM user_family_photo AS f
                                JOIN user_account AS u ON f.acc_id = u.acc_id
                                WHERE f.status = 'pending'
                                ORDER BY u.fname;",
        'user_birth_certificate' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, b.id, b.img, b.remarks
                                    FROM user_birth_certificate AS b
                                    JOIN user_account AS u ON b.acc_id = u.acc_id
                                    WHERE b.status = 'pending'
                                    ORDER BY u.fname;",
        'user_beneficiary_profile' => "SELECT u.acc_id, u.hhid, u.fname, u.mname, u.lname, b.id, b.upload, b.remarks
                                        FROM user_beneficiary_profile AS b
                                        JOIN user_account AS u ON b.acc_id = u.acc_id
                                        WHERE b.status = 'pending'
                                        ORDER BY u.fname;"
        ];

    /* $sql = "SELECT acc_id, hhid, fname, mname, lname, barangay FROM user_account ORDER BY barangay"; */

    $sql = "
    SELECT 
        ua.acc_id, ua.hhid, ua.fname, ua.mname, ua.lname, ua.barangay,
        -- User Gis
        gis.id AS gis_id,
        gis.img AS gis_img,
        YEAR(gis.upload_date) AS gis_year,
        -- User Referral Letters
        url.id AS rl_id,
        url.img AS rl_img,
        YEAR(url.upload_date) AS rl_year,
        -- User HAF
        uh.id AS haf_id,
        uh.img AS haf_img,
        YEAR(uh.upload_date) AS haf_year,
        -- User SCSR
        us.id AS scsr_id,
        us.img AS scsr_img,
        YEAR(us.upload_date) AS scsr_year,
        -- User SWDI Result
        usr.id AS swdi_id,
        usr.img AS swdi_img,
        YEAR(usr.upload_date) AS swdi_year,
        -- User CAR
        uc.id AS car_id,
        uc.img AS car_img,
        YEAR(uc.upload_date) AS car_year,
        -- User Progress Notes
        upn.id AS pn_id,
        upn.img AS pn_img,
        YEAR(upn.upload_date) AS pn_year,
        -- User PSMs
        ups.id AS psms_id,
        ups.img AS psms_img,
        YEAR(ups.upload_date) AS psms_year,
        -- User AER
        uaer.id AS aer_id,
        uaer.img AS aer_img,
        YEAR(uaer.upload_date) AS aer_year
    FROM 
        user_account ua
    LEFT JOIN 
        user_gis gis ON ua.acc_id = gis.acc_id AND YEAR(gis.upload_date) = YEAR(CURDATE())
    LEFT JOIN 
        user_referral_letters url ON ua.acc_id = url.acc_id AND YEAR(url.upload_date) = YEAR(CURDATE())
    LEFT JOIN 
        user_haf uh ON ua.acc_id = uh.acc_id AND YEAR(uh.upload_date) = YEAR(CURDATE())
    LEFT JOIN 
        user_scsr us ON ua.acc_id = us.acc_id AND YEAR(us.upload_date) = YEAR(CURDATE())
    LEFT JOIN 
        user_swdi_result usr ON ua.acc_id = usr.acc_id AND YEAR(usr.upload_date) = YEAR(CURDATE())
    LEFT JOIN 
        user_car uc ON ua.acc_id = uc.acc_id AND YEAR(uc.upload_date) = YEAR(CURDATE())
    LEFT JOIN 
        user_progress_notes upn ON ua.acc_id = upn.acc_id AND YEAR(upn.upload_date) = YEAR(CURDATE())
    LEFT JOIN 
        user_psms ups ON ua.acc_id = ups.acc_id AND YEAR(ups.upload_date) = YEAR(CURDATE())
    LEFT JOIN 
        user_aer uaer ON ua.acc_id = uaer.acc_id AND YEAR(uaer.upload_date) = YEAR(CURDATE())
    WHERE ua.status IN ('active', 'inactive')
    ORDER BY 
        ua.barangay;
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


} else {
    echo "Account ID not found in session.";
    echo "<script>window.location='pages/login.php';</script>";
}

unset($pdo);

?>