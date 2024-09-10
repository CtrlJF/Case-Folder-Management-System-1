<?php
session_start();
require_once(__DIR__ . '/../../../libraries/database.php');

if (isset($_SESSION['acc_id']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $bp_id = $_POST['userId'];

    try {
        // Start a transaction
        $pdo->beginTransaction();

        $sql2 = "DELETE FROM user_beneficiary_profile WHERE acc_id = :acc_id AND id = :bp_id";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(':acc_id', $_SESSION['acc_id'], PDO::PARAM_INT);
        $stmt2->bindParam(':bp_id', $bp_id, PDO::PARAM_INT);
        $stmt2->execute();

        // Commit the transaction if all deletions were successful
        $pdo->commit();
        echo "<script>alert('Successful Deletion!'); window.location='../../beneprofile.php';</script>";
        exit();
    } catch (PDOException $e) {
        // Rollback the transaction on database error
        $pdo->rollBack();
        echo "<script>alert('Database Error: " . $e->getMessage() . "'); window.location='../../beneprofile.php';</script>";
        error_log('Database Error: ' . $e->getMessage());
    } catch (Exception $e) {
        // Rollback the transaction on unexpected error
        $pdo->rollBack();
        echo "<script>alert('Unexpected Error: " . $e->getMessage() . "'); window.location='../../beneprofile.php';</script>";
        error_log('Unexpected Error: ' . $e->getMessage());
    }
}
?>
