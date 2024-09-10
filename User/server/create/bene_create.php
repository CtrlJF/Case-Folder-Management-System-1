<?php
session_start();
require_once(__DIR__ . '/../../../libraries/database.php');

if (isset($_SESSION['acc_id']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecting data from POST request
    $probinsya = $_POST['probinsya'];
    $lungsod = $_POST['lungsod'];
    $barangay = $_POST['barangay'];
    $hhid = preg_replace("/[^0-9]/", "", $_POST['hhid']);
    $purok = $_POST['purok'];
    $member_tribe = $_POST['option1'];
    $nametribe = $_POST['nametribe'];
    $relihiyon = $_POST['relihiyon'];
    $numlivehouse = $_POST['numlivehouse'];
    $philhealth = $_POST['option'];
    $usergrant = $_POST['option2'];
    $accnum = $_POST['accnum'];
    $hhstat = $_POST['hhstat'];
    $dailyincome = $_POST['dailyincome'];

    $case_use_1 = $_POST['cash-use-1'];
    $case_use_2 = $_POST['cash-use-2'];
    $case_use_3 = $_POST['cash-use-3'];
    $case_use_4 = $_POST['cash-use-4'];
    $case_use = $case_use_1 . ' ' . $case_use_2 . ' ' . $case_use_3 . ' ' . $case_use_4;

    $date = date("Y-m-d");
    $status = "pending";
    /* $year = date("Y"); */ // Assuming current year for insertion

    function capitalizeName($name) {
        // Trim any extra spaces
        $trimmedName = trim($name);
        
        // Capitalize the first letter of each word
        $capitalizedName = ucwords(strtolower($trimmedName));
        
        return $capitalizedName;
    }
    // Process each name input
    $nametribe = capitalizeName($nametribe);
    $relihiyon = capitalizeName($relihiyon);
    $hhstat = capitalizeName($hhstat);

    // Trim any extra spaces
    $trimmedInput = trim($purok);
    // Check if the input starts with 'Purok'
    if (stripos($trimmedInput, 'Purok ') === 0) {
        // Remove the 'Purok ' prefix
        $processedInput = substr($trimmedInput, strlen('Purok '));
    } else {
        // No change if 'Purok' is not in the input
        $processedInput = $trimmedInput;
    }
    // Capitalize the first letter of each word
    $purok = ucwords(strtolower($processedInput));


    try {
        // Insert into user_beneficiary_profile
        $query = "INSERT INTO user_beneficiary_profile 
        (probinsya, lungsod, barangay, purok, household_id, membro_tribo, name_tribo, relihiyon, family_size, philhealth, usergrant, account_num, hh_status, daily_income, use_money, upload, status, acc_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(1, $probinsya);
        $stmt->bindParam(2, $lungsod);
        $stmt->bindParam(3, $barangay);
        $stmt->bindParam(4, $purok);
        $stmt->bindParam(5, $hhid);
        $stmt->bindParam(6, $member_tribe);
        $stmt->bindParam(7, $nametribe);
        $stmt->bindParam(8, $relihiyon);
        $stmt->bindParam(9, $numlivehouse, PDO::PARAM_INT);
        $stmt->bindParam(10, $philhealth);
        $stmt->bindParam(11, $usergrant);
        $stmt->bindParam(12, $accnum);
        $stmt->bindParam(13, $hhstat);
        $stmt->bindParam(14, $dailyincome, PDO::PARAM_STR); // Use PDO::PARAM_STR for decimal values
        $stmt->bindParam(15, $case_use);
        $stmt->bindParam(16, $date, PDO::PARAM_STR);
        $stmt->bindParam(17, $status);
        $stmt->bindParam(18, $_SESSION['acc_id'], PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();
        $lastInsertId = $pdo->lastInsertId();

        if ($lastInsertId) {
            // Insert into bp_hh_member
            $stmt = $pdo->prepare("
            INSERT INTO bp_hh_member 
            (lname, fname, mname, birthday, gender, family_relation, civil_status, buntis, school, grade, register_grant, livelihood, bp_id)
            VALUES (:lname, :fname, :mname, :birthday, :gender, :family_relation, :civil_status, :buntis, :school, :grade, :register_grant, :livelihood, :bp_id)
        ");

             // Iterate over 15 records
            for ($i = 1; $i <= 15; $i++) {
                $lname = filter_input(INPUT_POST, "lname_$i", FILTER_SANITIZE_STRING) ?? '';
                $fname = filter_input(INPUT_POST, "fname_$i", FILTER_SANITIZE_STRING) ?? '';
                $mname = filter_input(INPUT_POST, "mname_$i", FILTER_SANITIZE_STRING) ?? '';
                $birthday = filter_input(INPUT_POST, "birthday_$i", FILTER_SANITIZE_STRING) ?? '';
                $gender = filter_input(INPUT_POST, "gender_$i", FILTER_SANITIZE_STRING) ?? '';
                $family_relation = filter_input(INPUT_POST, "family_relation_$i", FILTER_SANITIZE_STRING) ?? '';
                $civil_status = filter_input(INPUT_POST, "civil_status_$i", FILTER_SANITIZE_STRING) ?? '';
                $buntis = filter_input(INPUT_POST, "buntis_$i", FILTER_SANITIZE_STRING) ?? '';
                $school = filter_input(INPUT_POST, "school_$i", FILTER_SANITIZE_STRING) ?? '';
                $grade = filter_input(INPUT_POST, "grade_$i", FILTER_SANITIZE_STRING) ?? '';
                $register_grantee = filter_input(INPUT_POST, "register_grantee_$i", FILTER_SANITIZE_STRING) ?? '';
                $work_living = filter_input(INPUT_POST, "work_living_$i", FILTER_SANITIZE_STRING) ?? '';
                $bp_id = $lastInsertId;

                $lname = capitalizeName($lname);
                $fname = capitalizeName($fname);
                $mname = capitalizeName($mname);
                $gender = capitalizeName($gender);
                $family_relation = capitalizeName($family_relation);
                $civil_status = capitalizeName($civil_status);
                $buntis = capitalizeName($buntis);
                $school = capitalizeName($school);
                $grade = capitalizeName($grade);
                $register_grantee = capitalizeName($register_grantee);

                // Check if any of the required fields for insertion are not empty
                if (!empty($lname) || !empty($fname) || !empty($mname) || !empty($birthday) || !empty($gender) || !empty($family_relation) || !empty($civil_status) || !empty($buntis) || !empty($school) || !empty($grade) || !empty($register_grantee) || !empty($work_living)) {

                    // Bind parameters
                    $stmt->bindParam(':lname', $lname);
                    $stmt->bindParam(':fname', $fname);
                    $stmt->bindParam(':mname', $mname);
                    $stmt->bindParam(':birthday', $birthday);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':family_relation', $family_relation);
                    $stmt->bindParam(':civil_status', $civil_status);
                    $stmt->bindParam(':buntis', $buntis);
                    $stmt->bindParam(':school', $school);
                    $stmt->bindParam(':grade', $grade);
                    $stmt->bindParam(':register_grant', $register_grantee);
                    $stmt->bindParam(':livelihood', $work_living);
                    $stmt->bindParam(':bp_id', $bp_id);

                    // Execute the prepared statement
                    $stmt->execute();
                }
            }

            // Get the current year
            $currentYear = date('Y');
            // Define the range of years you want to display
            $startYear = $currentYear - 2; // 2 years before the current year
            $endYear = $currentYear + 2;   // 3 years after the current year

            // Array to hold all years and their corresponding values
            $yearsData = [];

            // Loop through each year in the range
            for ($year = $startYear; $year <= $endYear; $year++) {
                // Collect form data for each year
                $yearsData[] = [
                    'year' => $year,
                    'dec_jan' => isset($_POST["dec-jan_$year"]) ? (int)$_POST["dec-jan_$year"] : 0,
                    'feb_mar' => isset($_POST["feb-mar_$year"]) ? (int)$_POST["feb-mar_$year"] : 0,
                    'apr_may' => isset($_POST["apr-may_$year"]) ? (int)$_POST["apr-may_$year"] : 0,
                    'june_jul' => isset($_POST["june-jul_$year"]) ? (int)$_POST["june-jul_$year"] : 0,
                    'aug_sept' => isset($_POST["aug-sept_$year"]) ? (int)$_POST["aug-sept_$year"] : 0,
                    'oct_nov' => isset($_POST["oct-nov_$year"]) ? (int)$_POST["oct-nov_$year"] : 0,
                ];
            }

            // Prepare SQL query for bp_cash_received
            $query = "INSERT INTO bp_cash_received 
            (year, dec_jan, feb_mar, apr_may, june_jul, aug_sept, oct_nov, bp_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt1 = $pdo->prepare($query);

            
            // Bind and execute the statement for each year
            foreach ($yearsData as $data) {
                if ($data['dec_jan'] > 0 || $data['feb_mar'] > 0 || $data['apr_may'] > 0 || $data['june_jul'] > 0 || $data['aug_sept'] > 0 || $data['oct_nov'] > 0) {
                    $stmt1->bindValue(1, $data['year'], PDO::PARAM_INT);
                    $stmt1->bindValue(2, $data['dec_jan'], PDO::PARAM_INT);
                    $stmt1->bindValue(3, $data['feb_mar'], PDO::PARAM_INT);
                    $stmt1->bindValue(4, $data['apr_may'], PDO::PARAM_INT);
                    $stmt1->bindValue(5, $data['june_jul'], PDO::PARAM_INT);
                    $stmt1->bindValue(6, $data['aug_sept'], PDO::PARAM_INT);
                    $stmt1->bindValue(7, $data['oct_nov'], PDO::PARAM_INT);
                    $stmt1->bindValue(8, $lastInsertId, PDO::PARAM_INT); // Use lastInsertId from user_beneficiary_profile

                    // Execute the query
                    $stmt1->execute();
                }
            }

            echo "<script>alert('Successfully Created!');";
            echo "window.location='../../beneprofile.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to Create!');";
            echo "window.location='../../beneprofile.php';</script>";
            exit();
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
