<?php
if(isset($_SESSION['id_no'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');

    // admin specific year
    $sql = "
    WITH LatestGis AS (
        SELECT
            acc_id,
            id AS gis_id,
            img AS gis_img,
            YEAR(upload_date) AS gis_year
        FROM user_gis
        WHERE YEAR(upload_date) = YEAR(CURDATE())
    ),
    LatestReferralLetters AS (
        SELECT
            acc_id,
            id AS rl_id,
            img AS rl_img,
            YEAR(upload_date) AS rl_year
        FROM user_referral_letters
        WHERE YEAR(upload_date) = YEAR(CURDATE())
    ),
    LatestHaf AS (
        SELECT
            acc_id,
            id AS haf_id,
            img AS haf_img,
            YEAR(upload_date) AS haf_year
        FROM user_haf
        WHERE YEAR(upload_date) = YEAR(CURDATE())
    ),
    LatestScsr AS (
        SELECT
            acc_id,
            id AS scsr_id,
            img AS scsr_img,
            YEAR(upload_date) AS scsr_year
        FROM user_scsr
        WHERE YEAR(upload_date) = YEAR(CURDATE())
    ),
    LatestSwdiResult AS (
        SELECT
            acc_id,
            id AS swdi_id,
            img AS swdi_img,
            YEAR(upload_date) AS swdi_year
        FROM user_swdi_result
        WHERE YEAR(upload_date) = YEAR(CURDATE())
    ),
    LatestCar AS (
        SELECT
            acc_id,
            id AS car_id,
            img AS car_img,
            YEAR(upload_date) AS car_year
        FROM user_car
        WHERE YEAR(upload_date) = YEAR(CURDATE())
    ),
    LatestProgressNotes AS (
        SELECT
            acc_id,
            id AS pn_id,
            img AS pn_img,
            YEAR(upload_date) AS pn_year
        FROM user_progress_notes
        WHERE YEAR(upload_date) = YEAR(CURDATE())
    ),
    LatestPsms AS (
        SELECT
            acc_id,
            id AS psms_id,
            img AS psms_img,
            YEAR(upload_date) AS psms_year
        FROM user_psms
        WHERE YEAR(upload_date) = YEAR(CURDATE())
    ),
    LatestAer AS (
        SELECT
            acc_id,
            id AS aer_id,
            img AS aer_img,
            YEAR(upload_date) AS aer_year
        FROM user_aer
        WHERE YEAR(upload_date) = YEAR(CURDATE())
    )
        
    SELECT 
        ua.acc_id,
        ua.hhid,
        ua.fname,
        ua.mname,
        ua.lname,
        ua.barangay,
        -- User Gis
        lgis.gis_id,
        lgis.gis_img,
        lgis.gis_year,
        -- User Referral Letters
        lrl.rl_id,
        lrl.rl_img,
        lrl.rl_year,
        -- User HAF
        lhaf.haf_id,
        lhaf.haf_img,
        lhaf.haf_year,
        -- User SCSR
        lscsr.scsr_id,
        lscsr.scsr_img,
        lscsr.scsr_year,
        -- User SWDI Result
        lswdi.swdi_id,
        lswdi.swdi_img,
        lswdi.swdi_year,
        -- User CAR
        lcar.car_id,
        lcar.car_img,
        lcar.car_year,
        -- User Progress Notes
        lpn.pn_id,
        lpn.pn_img,
        lpn.pn_year,
        -- User PSMs
        lpsms.psms_id,
        lpsms.psms_img,
        lpsms.psms_year,
        -- User AER
        laer.aer_id,
        laer.aer_img,
        laer.aer_year
    FROM 
        user_account ua
    LEFT JOIN LatestGis lgis ON ua.acc_id = lgis.acc_id
    LEFT JOIN LatestReferralLetters lrl ON ua.acc_id = lrl.acc_id
    LEFT JOIN LatestHaf lhaf ON ua.acc_id = lhaf.acc_id
    LEFT JOIN LatestScsr lscsr ON ua.acc_id = lscsr.acc_id
    LEFT JOIN LatestSwdiResult lswdi ON ua.acc_id = lswdi.acc_id
    LEFT JOIN LatestCar lcar ON ua.acc_id = lcar.acc_id
    LEFT JOIN LatestProgressNotes lpn ON ua.acc_id = lpn.acc_id
    LEFT JOIN LatestPsms lpsms ON ua.acc_id = lpsms.acc_id
    LEFT JOIN LatestAer laer ON ua.acc_id = laer.acc_id
    WHERE ua.status NOT IN ('pending', 'completed')
    ORDER BY 
        ua.barangay, 
        lgis.gis_year DESC, 
        lrl.rl_year DESC, 
        lhaf.haf_year DESC, 
        lscsr.scsr_year DESC, 
        lswdi.swdi_year DESC, 
        lcar.car_year DESC, 
        lpn.pn_year DESC, 
        lpsms.psms_year DESC, 
        laer.aer_year DESC;        
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

     /* echo '<pre>';
    print_r($barangayGroups);
    echo '</pre>'; */

} else {
    echo "Account ID not found in session.";
}

unset($pdo);

?>