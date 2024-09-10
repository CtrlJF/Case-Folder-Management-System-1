<?php
if(isset($_SESSION['id_no'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');

    $pending = "pending";
    $completed = "completed";


    $sql = "SELECT acc_id, hhid, fname, mname, lname, phone_number, barangay, purok, user_set FROM user_account WHERE status NOT IN (:pending, :completed)
    ORDER BY fname";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pending', $pending);
    $stmt->bindParam(':completed', $completed);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    function formathhid($hhid) {
        // Assuming $hhid is a string with 18 characters
        return substr($hhid, 0, 9) . '-' . substr($hhid, 9, 4) . '-' . substr($hhid, 13);
    }

} else {
    echo "Account ID not found in session.";
    echo "<script>window.location='pages/login.php';</script>";
}

unset($pdo);

?>