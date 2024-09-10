<?php
session_start();
if(isset($_SESSION['id_no'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');

    $pending = "pending";

    $sql = "SELECT COUNT(*) AS count FROM user_account WHERE status = :pending";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pending', $pending);
    $stmt->execute();

    // Fetch the count from the query result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $row['count'];
    
} else {
    header('HTTP/1.1 403 Forbidden');
    echo 'Account ID not found in session.';
}

unset($pdo);

?>