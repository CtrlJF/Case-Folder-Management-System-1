<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once(__DIR__ . '/../../../libraries/database.php');
    // Check if userId and file were passed in the request
    if (isset($_POST['userId']) && isset($_FILES['file'])) {
        
        // Retrieve userId from POST data
        $userId = $_POST['userId'];
        
        // File details
        $file = $_FILES['file'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileError = $file['error'];
        
        // Example directory to upload files
        $uploadDir = '../../../uploads/birthcert/';
        
        // Check if file was uploaded without errors
        if ($fileError === 0) {
            // Generate unique filename to avoid overwriting existing files
            $uniqueFileName = uniqid('', true) . '_' . $fileName;
            $targetPath = $uploadDir . $uniqueFileName;
            
            // Move uploaded file to destination directory
            if (move_uploaded_file($fileTmpName, $targetPath)) {
                // File upload successful
                
                // Update `img` field in `user_birth_certificate` table
                $sql = "UPDATE user_birth_certificate SET img = :imgFileName WHERE id = :userId";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    'imgFileName' => $uniqueFileName,
                    'userId' => $userId
                ));
                
                // Response data
                $response = array(
                    'success' => true,
                    'message' => 'File uploaded successfully.',
                    'userId' => $userId,
                    'fileName' => $uniqueFileName,
                    'filePath' => $targetPath
                );
                
                header('Content-Type: application/json');
                echo json_encode($response);
                
            } else {
                // Failed to move uploaded file
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Error uploading file. Please try again later.'
                ));
            }
        } else {
            // File upload error
            echo json_encode(array(
                'success' => false,
                'message' => 'Error: ' . $fileError
            ));
        }
    } /* else {
        // Missing userId or file in the request
        echo json_encode(array(
            'success' => false,
            'message' => 'Missing userId or file in the request.'
        ));
    } */
} /* else {
    // Invalid request method
    echo json_encode(array(
        'success' => false,
        'message' => 'Invalid request method. POST method required.'
    ));
} */
?>
