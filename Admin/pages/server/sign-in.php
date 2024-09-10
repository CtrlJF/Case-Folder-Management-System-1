<?php
session_start();
require_once(__DIR__ . '/../../../libraries/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_no = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id_no, password, fname, lname FROM admin_account WHERE id_no = :id_no";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_no', $id_no);
    $stmt->execute();

    // Check if the user exists
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashedPassword = $row['password'];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct
            $_SESSION['loggedin'] = true;
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            $_SESSION['id_no'] = $row['id_no'];
            $_SESSION['mname'] = $row['mname'];
            // Redirect the user to the dashboard or perform any other actions
            header("Location: ../../index.php");
            exit();
        } else {
            // Password is incorrect
            echo "<script>alert('Invalid Id Number or Password')</script>";
            echo "<script>window.location='../login.php';</script>";
        }
    } else {
        // User does not exist
        echo "<script>alert('Invalid Id Number or Password')</script>";
        echo "<script>window.location='../login.php';</script>";
    }
}
?>