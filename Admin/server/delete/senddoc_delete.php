<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once(__DIR__ . '/../../../libraries/database.php');
    // Retrieve form data
    $rowId = $_POST['rowId'];
    $docType = $_POST['docType'];

    // Validate input
    if (empty($rowId) || empty($docType)) {
        echo 'Invalid input!';
        echo "<script>alert('Invalid input!');
        window.location='../../submitDocs.php';</script>";
        exit;
    }

    // Prepare query based on action
    $table = '';
    
    switch ($docType) {
        case 'GIS':
            $table = 'user_gis';
            break;
        case 'SWDI':
            $table = 'user_swdi_result';
            break;
        case 'HAF':
            $table = 'user_haf';
            break;
        case 'SCSR':
            $table = 'user_scsr';
            break;
        case 'CAR':
            $table = 'user_car';
            break;
        case 'AER':
            $table = 'user_aer';
            break;
        case 'PN':
            $table = 'user_progress_notes';
            break;
        case 'PSMS':
            $table = 'user_psms';
            break;
        case 'RL':
            $table = 'user_referral_letters';
            break;
        default:
            echo 'Unknown document type!';
            exit;
    }

    // Update document status in the specified table
    try {
        $sql = "DELETE FROM $table WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $rowId);
        $stmt->execute();

        echo "<script>alert('Document Deleted Successfully.');
        window.location='../../submitDocs.php';</script>";
    } catch (PDOException $e) {
        $escapedMessage = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        echo "<script>
            alert('Error: " . $escapedMessage . "');
            window.location.href = '../../submitDocs.php';
        </script>";
    }
} else {
    echo "<script>alert('Invalid request method!');
        window.location='../../submitDocs.php';</script>";
}

?>