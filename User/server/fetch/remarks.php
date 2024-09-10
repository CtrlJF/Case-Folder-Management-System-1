<?php
session_start();
require_once(__DIR__ . '/../../../libraries/database.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $type = $_POST['type'];

    if (empty($type)) {
        echo "<script>alert('Invalid input!');</script>";
        exit;
    }
    
    $table = '';
    
    switch ($type) {
        case 'National_ID':
            $table = 'user_national_id';
            break;
        case 'Beneficiary_Profile':
            $table = 'user_beneficiary_profile';
            break;
        case 'Pantawid_ID':
            $table = 'user_pantawid_id';
            break;  
        case 'Cash_Card':
            $table = 'user_cash_card';
            break;
        case 'Family_Photo':
            $table = 'user_family_photo';
            break;  
        case 'kasabutan':
            $table = 'user_kasabutan';
            break;
        case 'Birth_Certificate':
            $table = 'user_birth_certificate';
            break; 
        case 'Marriage_Contract':
            $table = 'user_marriage_contract';
            break; 
        case 'Immunization_Record':
            $table = 'user_immunization_record';
            break;
        case 'Grade_Cards':
            $table = 'user_grade_cards';
            break;
        case 'MDR':
            $table = 'user_mdr';
            break;  
        case 'Certificate':
            $table = 'user_certificate';
            break;                                   
        default:
            echo 'Unknown document type!';
            exit;
    }

        $sql = "SELECT remarks FROM $table WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($row['remarks'])) {
            echo htmlspecialchars('No Remarks!');
        } else {
            echo htmlspecialchars($row['remarks']); // Output remarks safely
        }

}
?>
