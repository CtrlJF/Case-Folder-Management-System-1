<?php 
require_once(__DIR__ . '/../../../libraries/database.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate and sanitize user input
    $userId = isset($_POST['userId']) ? intval($_POST['userId']) : null;
    $status = "completed";

    if ($userId === null) {
        // Handle case where userId is not provided or invalid
        echo "<script>alert('Invalid user ID!');
              window.location='../../dropgrantee.php';</script>";
        exit();
    }

    $query = "UPDATE user_account SET status = :status WHERE acc_id = :acc_id";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':acc_id', $userId, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        // Success message with redirect
        echo "<script>alert('Account Completed Successfully!');
              window.location='../../dropgrantee.php';</script>";
        exit();
    } else {
        // Error message with redirect
        echo "<script>alert('Account Completion Failed!');
              window.location='../../dropgrantee.php';</script>";
        exit();
    }

}
?>