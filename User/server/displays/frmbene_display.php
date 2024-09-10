<?php
if(isset($_SESSION['acc_id'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');
    $sql = "SELECT hhid, barangay, purok FROM user_account WHERE acc_id = :acc_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':acc_id', $_SESSION['acc_id'], PDO::PARAM_INT);
    $stmt->execute();

     // Fetch data from the result set
     $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
     // Check if data is fetched successfully
     if(!$data) {
         echo "No data found for this account ID.";
     }

}else {
    echo "Account ID not found in session.";
    echo "<script>window.location='pages/login.php';</script>";
}

// Close database connection
unset($pdo);

// Return the query result or data
return $data;

?>