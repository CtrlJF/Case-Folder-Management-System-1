<?php 
session_start();
require_once(__DIR__ . '/../../libraries/database.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Initialize an array to store any errors
    $errors = [];

    // Retrieve form data
    /* $hhid = $_POST['hhid']; */
    $hhid = preg_replace("/[^0-9]/", "", $_POST['hhid']);
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $barangay = $_POST['barangay'];
    $purok = $_POST['purok'];
    $set = $_POST['set'];
    /* $phylsis_id = $_POST['phylsis_id']; */
    $phylsis_id = preg_replace("/[^0-9]/", "", $_POST['phylsis_id']);
    /* $date = date("Y-m-d"); */
   /*  $status = 'pending'; */

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
    
    $passwordLength = isset($_SESSION['password_length']) ? $_SESSION['password_length'] : 0;
    $asteriskPassword = str_repeat('*', $passwordLength);

    if ($password === $asteriskPassword) {
        $hashed_password = $_SESSION['password'];
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }



    if (empty($errors)) { 
        $password_length = strlen($password);

        $query = "UPDATE user_account 
                SET hhid = ?,
                    password = ?, 
                    fname = ?, 
                    mname = ?, 
                    lname = ?, 
                    phone_number = ?, 
                    barangay = ?, 
                    purok = ?, 
                    user_set = ?, 
                    phylsis_id = ?, 
                    password_length = ?
                WHERE acc_id = ?;";
        $stmt = $pdo->prepare($query);

        $params = [
            $hhid,
            $hashed_password, 
            $first_name, 
            $middle_name, 
            $last_name, 
            $phone_number, 
            $barangay, 
            $purok, 
            $set, 
            $phylsis_id,
            $password_length,
            $_SESSION['acc_id']
        ];

        if ($stmt->execute($params)) {
            echo "<script>alert('Update Successful!');";
            echo "window.location='../index.php';</script>";
            exit();
        }else {
            echo "<script>alert('Update Failed!');</script>";
            echo "window.location='../index.php';</script>";
        }
        
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo "<script>alert('" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "');</script>";
            echo "window.location='../index.php';</script>";
        }
    }
}




?>