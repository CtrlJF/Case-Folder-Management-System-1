<?php 
require_once(__DIR__ . '/../../../libraries/database.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate and sanitize user input
    $userId = isset($_POST['userIdDel']) ? intval($_POST['userIdDel']) : null;

    if ($userId === null) {
        // Handle case where userId is not provided or invalid
        echo "<script>alert('Invalid user ID!');
              window.location='../../pendingUsers.php';</script>";
        exit();
    }

    $query = "DELETE FROM user_account WHERE acc_id = :acc_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':acc_id', $userId, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        // Success message with redirect
        echo "<script>alert('Account Rejected Successfully!');
              window.location='../../pendingUsers.php';</script>";
        exit();
    } else {
        // Error message with redirect
        echo "<script>alert('Account Rejection Failed!');
              window.location='../../pendingUsers.php';</script>";
        exit();
    }

}
?>