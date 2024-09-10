<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once(__DIR__ . '/../../../libraries/database.php');
    // Check if userId and file were passed in the request
    if (isset($_POST['userId']) && isset($_FILES['file'])) {
        
        // Retrieve userId from POST data
        $userId = $_POST['userId'];
        $userName = $_POST['userName'];
        $date = date("Y-m-d");

        // File details
        $file = $_FILES['file'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileError = $file['error'];
        
        // Example directory to upload files
        $uploadDir = '../../../uploads/gis/';
        
        // Check if file was uploaded without errors
        if ($fileError === 0) {
            // Generate unique filename to avoid overwriting existing files
            $uniqueFileName = uniqid('', true) . '_' . $fileName;
            $targetPath = $uploadDir . $uniqueFileName;
            
            // Move uploaded file to destination directory
            if (move_uploaded_file($fileTmpName, $targetPath)) {
                // File upload successful
                
                // Update `img` field in `user_cash_card` table
                $sql = "INSERT INTO user_gis (name, upload_date, img, acc_id) VALUES (:name, :upload_date, :imgFileName, :userId)";
                $stmt = $pdo->prepare($sql);

                // Bind parameters
                $stmt->bindParam(':name', $userName);
                $stmt->bindParam(':upload_date', $date);
                $stmt->bindParam(':imgFileName', $uniqueFileName);
                $stmt->bindParam(':userId', $userId);

                $stmt->execute();
                
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
