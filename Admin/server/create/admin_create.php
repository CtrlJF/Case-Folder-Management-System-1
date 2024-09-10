<?php
require_once(__DIR__ . '/../../../libraries/database.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize an array to store any errors
    $errors = [];

    $id_no = $_POST['id_num'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];


    // Validate password
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // Confirm password
    if ($password != $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if there are any errors
    if (empty($errors)) {
        $query_check = "SELECT COUNT(*) FROM admin_account WHERE id_no = ?";
        $stmt_check = $pdo->prepare($query_check);
        $stmt_check->execute([$id_no]);
        $count = $stmt_check->fetchColumn();

        if ($count > 0) {
            echo "<script>alert('ID number already exists!');";
            echo "window.location='../../CreateAdmin.php';</script>";
            exit();
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO admin_account (id_no, password, fname, mname, lname) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($query);

            // Bind parameters in the same order as placeholders
            $stmt->bindParam(1, $id_no, PDO::PARAM_STR);
            $stmt->bindParam(2, $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(3, $fname, PDO::PARAM_STR);
            $stmt->bindParam(4, $mname, PDO::PARAM_STR);
            $stmt->bindParam(5, $lname, PDO::PARAM_STR);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>alert('Registration Successful!');";
                echo "window.location='../../CreateAdmin.php';</script>";
                exit();
            } else {
                echo "<script>alert('Registration Failed!');";
                echo "window.location='../../CreateAdmin.php';</script>";
                exit();
            }
        }
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<script>alert('$error');";
            echo "window.location='../../CreateAdmin.php';</script>";
        }
    }
}
?>
