<?php
if(isset($_SESSION['acc_id'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');
    $sql = "SELECT * FROM user_immunization_record WHERE acc_id = :acc_id ORDER BY id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':acc_id', $_SESSION['acc_id'], PDO::PARAM_INT);
    $stmt->execute();

}else {
    echo "Account ID not found in session.";
    echo "<script>window.location='pages/login.php';</script>";
}

// Close database connection
unset($pdo);

?>