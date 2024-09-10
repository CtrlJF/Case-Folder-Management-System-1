<?php
if(isset($_SESSION['id_no'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');

    function formathhid($hhid) {
        // Assuming $hhid is a string with 18 characters
        return substr($hhid, 0, 9) . '-' . substr($hhid, 9, 4) . '-' . substr($hhid, 13);
    }

    /* all data by year */
     $query = "
        SELECT 
        ua.acc_id,
        ua.hhid,
        ua.fname,
        ua.mname,
        ua.lname,
        ua.barangay,
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
        user_gis gis ON ua.acc_id = gis.acc_id
    LEFT JOIN 
        user_referral_letters url ON ua.acc_id = url.acc_id
    LEFT JOIN 
        user_haf uh ON ua.acc_id = uh.acc_id
    LEFT JOIN 
        user_scsr us ON ua.acc_id = us.acc_id
    LEFT JOIN 
        user_swdi_result usr ON ua.acc_id = usr.acc_id
    LEFT JOIN 
        user_car uc ON ua.acc_id = uc.acc_id
    LEFT JOIN 
        user_progress_notes upn ON ua.acc_id = upn.acc_id
    LEFT JOIN 
        user_psms ups ON ua.acc_id = ups.acc_id
    LEFT JOIN 
        user_aer uaer ON ua.acc_id = uaer.acc_id
    WHERE 
        ua.status NOT IN ('pending', 'completed')
    ORDER BY 
        ua.barangay,
        gis.upload_date DESC,
        url.upload_date DESC,
        uh.upload_date DESC,
        us.upload_date DESC,
        usr.upload_date DESC,
        uc.upload_date DESC,
        upn.upload_date DESC,
        ups.upload_date DESC,
        uaer.upload_date DESC;  
        ";


    // Execute the query
    $statement = $pdo->query($query);
    $outputs= $statement->fetchAll(PDO::FETCH_ASSOC);
 
     // Define the helper function to add documents
    function addDocument(&$array, $type, $id, $img, $year) {
        $key = $id . '-' . $year;
        if (!isset($array[$key])) {
            $array[$key] = [
                "{$type}_id" => $id,
                "{$type}_img" => $img,
                "{$type}_year" => $year
            ];
        }
    }

    // Initialize the array to store the organized data
    $organizedData = [];

    // Process each result row
    foreach ($outputs as $row) {
        // Check if the necessary keys exist
        if (isset($row['fname'], $row['lname'], $row['hhid'], $row['barangay'])) {
            $barangay = $row['barangay'];
            $nameHhid = $row['fname'] . ' ' .  $row['mname'] . ' ' . $row['lname'] . ' (' . $row['hhid'] . ')';

            // Initialize the barangay group if not already set
            if (!isset($organizedData[$barangay])) {
                $organizedData[$barangay] = [];
            }

            // Initialize the name and HHID group within barangay
            if (!isset($organizedData[$barangay][$nameHhid])) {
                $organizedData[$barangay][$nameHhid] = [
                    'gis' => [],
                    'swdi' => [],
                    'haf' => [],
                    'scsr' => [],
                    'car' => [],
                    'pn' => [],
                    'psms' => [],
                    'aer' => [],
                    'rl' => []
                ];
            }

            // Add documents to the appropriate type and year
            foreach (['gis', 'rl', 'haf', 'scsr', 'swdi', 'car', 'pn', 'psms', 'aer'] as $type) {
                $idKey = "{$type}_id";
                $imgKey = "{$type}_img";
                $yearKey = "{$type}_year";

                if (isset($row[$idKey], $row[$imgKey], $row[$yearKey])) {
                    addDocument($organizedData[$barangay][$nameHhid][$type], $type, $row[$idKey], $row[$imgKey], $row[$yearKey]);
                }
            }
        } else {
            // Debugging: Output missing keys information
            echo "Missing keys in row: ";
            print_r($row);
        }
    }

    // Remove the intermediate array keys to clean up the structure
    foreach ($organizedData as &$barangayData) {
        foreach ($barangayData as &$nameHhidData) {
            foreach ($nameHhidData as &$typeData) {
                $typeData = array_values($typeData); // Convert associative array to indexed array
            }
        }
    }

    /* $data = $organizedData; */

   /*  echo '<pre>';
    print_r($organizedData);
    echo '</pre>'; */

} else {
    echo "Account ID not found in session.";
}

unset($pdo);

?>