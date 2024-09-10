<?php
session_start();
require_once(__DIR__ . '/../../../libraries/database.php');

if(isset($_SESSION['acc_id']) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $status = "pending";
    $date = date("Y-m-d");

    $query = "INSERT INTO user_family_photo (name, upload, status, acc_id ) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);

    if ($stmt->execute([$name, $date, $status, $_SESSION['acc_id']])) {
        echo "<script>alert('Successfully Created!');";
        echo "window.location='../../familypicture.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to Create!');";
        echo "window.location='../../familypicture.php';</script>";
        exit();
    }

}

?>