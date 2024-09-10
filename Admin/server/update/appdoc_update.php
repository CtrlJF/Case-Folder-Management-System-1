<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once(__DIR__ . '/../../../libraries/database.php');
    // Retrieve form data
    $userId = $_POST['userId'];
    $docType = $_POST['docType'];
    $docId = $_POST['docId'];

    // Validate input
    if (empty($userId) || empty($docType) || empty($docId)) {
        echo 'Invalid input!';
        echo "<script>alert('Invalid input!');
        window.location='../../pendingDocs.php';</script>";
        exit;
    }

    // Prepare query based on action
    $status = 'approved';
    $table = '';
    
    switch ($docType) {
        case 'National ID':
            $table = 'user_national_id';
            break;
        case 'Family Picture':
            $table = 'user_family_photo';
            break;
        case 'Pantawid ID':
            $table = 'user_pantawid_id';
            break;
        case 'Cash Card':
            $table = 'user_cash_card';
            break;
        case 'Kasabutan':
            $table = 'user_kasabutan';
            break;
        case 'Birth Certificate':
            $table = 'user_birth_certificate';
            break;
        case 'Marriage Contract':
            $table = 'user_marriage_contract';
            break;
        case 'Grade Cards':
            $table = 'user_grade_cards';
            break;
        case 'Immunization Record':
            $table = 'user_immunization_record';
            break;
        case 'Beneficiary Profile':
            $table = 'user_beneficiary_profile';
            break;
        case 'MDR':
            $table = 'user_mdr';
            break;
        case 'Attendance on Training':
            $table = 'user_certificate';
            break;
        default:
            echo 'Unknown document type!';
            exit;
    }

    // Update document status in the specified table
    try {
        $sql = "UPDATE $table SET status = :status WHERE acc_id = :userId AND id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':status' => $status,
            ':userId' => $userId,
            ':id' => $docId
        ]);

        echo "<script>alert('Document Approved Successfully.');
        window.location='../../pendingDocs.php';</script>";
    } catch (PDOException $e) {
        $escapedMessage = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        echo "<script>
            alert('Error: " . $escapedMessage . "');
            window.location.href = '../../pendingDocs.php';
        </script>";
    }
} else {
    echo "<script>alert('Invalid request method!');
        window.location='../../pendingDocs.php';</script>";
}

?>