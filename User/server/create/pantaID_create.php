<?php
session_start();
require_once(__DIR__ . '/../../../libraries/database.php');

if(isset($_SESSION['acc_id']) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $status = "pending";
    $date = date("Y-m-d");

    $query = "INSERT INTO user_pantawid_id (status, acc_id, name, upload) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);

    if ($stmt->execute([$status, $_SESSION['acc_id'], $name, $date])) {
        echo "<script>alert('Successfully Created!');";
        echo "window.location='../../pantawidID.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to Create!');";
        echo "window.location='../../pantawidID.php';</script>";
        exit();
    }

}



?>