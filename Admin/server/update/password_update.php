<?php 
session_start();
require_once(__DIR__ . '/../../../libraries/database.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $password = $_POST['password'];

    // Validate password
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

     // Check if there are any errors
     if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE admin_account SET password = :password WHERE id_no = :id_no";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':id_no', $_SESSION['id_no'], PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Update Successful!');";
            echo "window.location='../../index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Update Failed!');</script>";
            echo "window.location='../../index.php';</script>";
            exit();
        }
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<script>alert('$error');";
            echo "window.location='../../index.php';</script>";
        }
    }

}

?>