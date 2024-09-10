<?php
session_start();
require_once(__DIR__ . '/../../../libraries/database.php');

if (isset($_SESSION['acc_id']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $userNID = $_POST['userId'];

    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Retrieve file details before deletion
        $sql = "SELECT img FROM user_national_id WHERE id = :userId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userId', $userNID, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
           $baseDir = '../../../uploads/nationalID/';
           $fileName = $row['img'];
           
           $filePath = $baseDir . $fileName;

           // Prepare the DELETE statement
           $sql = "DELETE FROM user_national_id WHERE id = :userId";
           $stmt = $pdo->prepare($sql);
           $stmt->bindParam(':userId', $userNID, PDO::PARAM_INT);

           // Execute the DELETE statement
           if ($stmt->execute()) {
               // Commit the transaction if deletion is successful
               $pdo->commit();

               // Delete the file from server
               if (file_exists($filePath)) {
                   unlink($filePath);
               }

               echo "<script>alert('Successful Deleted!');";
               echo "window.location='../../nationalID.php';</script>";
               exit();
           } else {
               // Rollback the transaction if deletion fails
               $pdo->rollBack();
               echo "<script>alert('Failed To Delete!');</script>";
           }
       } else {
           echo "<script>alert('Record not found!');</script>";
       }
    } catch (PDOException $e) {
        // Rollback the transaction on database error
        $pdo->rollBack();
        echo "<script>alert('Database Error: " . $e->getMessage() . "');</script>";
        // Log the error for debugging purposes
        error_log('Database Error: ' . $e->getMessage());
        /* echo "<script>window.location='../../nationalID.php';</script>"; */
    } catch (Exception $e) {
        // Rollback the transaction on unexpected error
        $pdo->rollBack();
        echo "<script>alert('Unexpected Error: " . $e->getMessage() . "');</script>";
        // Log the error for debugging purposes
        error_log('Unexpected Error: ' . $e->getMessage());
        /* echo "<script>window.location='../../nationalID.php';</script>"; */
    }
    echo "<script>window.location='../../nationalID.php';</script>";
}


?>