<?php
/* session_start(); */
// Include the database connection file
require_once(__DIR__ . '/../../../libraries/database.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize an array to store any errors
    $errors = [];

    // Retrieve form data
    /* $hhid = $_POST['hhid']; */
    $hhid = preg_replace("/[^0-9]/", "", $_POST['hhid']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $barangay = $_POST['barangay'];
    $purok = $_POST['purok'];
    $set = $_POST['set'];
    /* $phylsis_id = $_POST['phylsis_id']; */
    $phylsis_id = preg_replace("/[^0-9]/", "", $_POST['phylsis_id']);
    $date = date("Y-m-d");
    $status = 'pending';

    // Function to capitalize the first letter of each word
    function capitalizeName($name) {
        // Trim any extra spaces
        $trimmedName = trim($name);
        
        // Capitalize the first letter of each word
        $capitalizedName = ucwords(strtolower($trimmedName));
        
        return $capitalizedName;
    }

    // Process each name input
    $first_name = capitalizeName($first_name);
    $middle_name = capitalizeName($middle_name);
    $last_name = capitalizeName($last_name);

    // List of existing barangays with "Barangay" prefix
    $existingBarangays = [
        'Barangay Abilan', 'Barangay Agong-ong', 'Barangay Alubijid', 'Barangay Guinabsan', 
        'Barangay Macalang', 'Barangay Malapong', 'Barangay Malpoc', 'Barangay Manapa', 
        'Barangay Matabao', 'Barangay 1', 'Barangay 2', 'Barangay 3', 'Barangay 4', 
        'Barangay 5', 'Barangay 6', 'Barangay 7', 'Barangay 8', 'Barangay 9', 
        'Barangay 10', 'Barangay Rizal', 'Barangay Sacol', 'Barangay Sangay', 
        'Barangay Talo-ao', 'Barangay Lower Olave', 'Barangay Simbalan'
    ];

    // Example input from user (for testing purposes)
    $inputBarangay = $barangay;

    // Trim any extra spaces
    $trimmedInput = trim($inputBarangay);

    // Convert to title case
    $formattedInput = ucwords(strtolower($trimmedInput));

    // Check if the input already includes 'Barangay'
    if (!preg_match('/^Barangay\s/', $formattedInput)) {
        // If the input does not start with 'Barangay', prepend 'Barangay '
        $barangay = 'Barangay ' . $formattedInput;
    } else {
        // If 'Barangay' is already included, use the input as is
        $barangay = $formattedInput;
    }


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



    // Validate HHID number (hhid)
    if (empty($hhid)) {
        $errors[] = "HHID number is required.";
    }

    // Validate password
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    // Confirm password
    if ($password != $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if there are any errors
    if (empty($errors)) {
        // Check if the hhid already exists in the database
        $query_check = "SELECT COUNT(*) FROM user_account WHERE hhid = ?";
        $stmt_check = $pdo->prepare($query_check);
        $stmt_check->execute([$hhid]);
        $count = $stmt_check->fetchColumn();

        if ($count > 0) {
            // Hhid already exists, display an error message to the user
            echo "<script>alert('HHID already exists!');";
            echo "window.location='../sign-up.php';</script>";
            exit();
        } else {
            // Hhid does not exist, proceed with the insertion
            // Hash the password before storing it
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            /* $_SESSION['pass_length'] = strlen($password); */
            $password_length = strlen($password);

            // Prepare the SQL statement to avoid SQL injection
            $query = "INSERT INTO user_account (hhid, password, fname, mname, lname, phone_number, barangay, purok, user_set, phylsis_id, status, dateEntered, password_length) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($query);

            // Execute the statement with parameters
            if ($stmt->execute([$hhid, $hashed_password, $first_name, $middle_name, $last_name, $phone_number, $barangay, $purok, $set, $phylsis_id, $status, $date, $password_length])) {
                echo "<script>alert('Registration Successful!');";
                echo "window.location='../login.php';</script>";
                exit();
            } else {
                echo "<script>alert('Registration Failed!');";
                echo "window.location='../login.php';</script>";
                exit();
            }
        }
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<script>alert('$error');";
            echo "window.location='../sign-up.php';</script>";
        }
    }
}
?>
