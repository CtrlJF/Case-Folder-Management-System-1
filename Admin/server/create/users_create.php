<?php
require '../../vendor/autoload.php'; // Include PhpSpreadsheet autoload file
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Check for file upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("File upload error!");
    }

    // Validate file type
    $allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'application/vnd.ms-excel.sheet.macroEnabled.12'];
    //'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
    //'application/vnd.ms-excel', // .xls
    //'application/vnd.ms-excel.sheet.macroEnabled.12' // .xlsm
    if (!in_array($file['type'], $allowedTypes)) {
        /* die("Invalid file type! Please upload an Excel file."); */
        echo "<script>alert('Invalid file type! Please upload an Excel file.'); window.location='../../CreateUser.php';</script>";
    }

    // Load the spreadsheet
    $spreadsheet = IOFactory::load($file['tmp_name']);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = [];

    // Loop through each row of the spreadsheet and collect data
    foreach ($worksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false); // Loop through all cells

        $rowData = [];
        foreach ($cellIterator as $cell) {
            $rowData[] = $cell->getValue();
        }

        // Skip empty rows
        if (array_filter($rowData)) {
            $data[] = $rowData;
        }
    }

    require_once(__DIR__ . '/../../../libraries/database.php');

    // Prepare the SQL statement for inserting users
    $query = "INSERT INTO user_account (hhid, password, fname, mname, lname, phone_number, barangay, purok, user_set, phylsis_id, status, dateEntered, password_length) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
    $stmt = $pdo->prepare($query);

    function capitalizeName($name) {
        // Trim any extra spaces
        $trimmedName = trim($name);
        // Capitalize the first letter of each word
        return ucwords(strtolower($trimmedName));
    }

    // Loop through the data and insert into the database
    foreach ($data as $row) {
        // Assuming the columns in the spreadsheet are in the following order:
        // HHID, Password, First Name, Middle Name, Last Name, Phone Number, Barangay, Purok, User Set, Phylsis ID
        list($hhid, $password, $fname, $mname, $lname, $number, $barangay, $purok, $set, $phylsis_id) = $row;

        // Capitalize names
        $fname = capitalizeName($fname);
        $mname = capitalizeName($mname);
        $lname = capitalizeName($lname);
        $barangay = capitalizeName($barangay);
        $purok = capitalizeName($purok); // Capitalizing purok
        $number = strpos($number, '0') === 0 ? $number : '0' . $number;   //$number = "0" . $number;

        // Check if the input already includes 'Barangay'
        if (!preg_match('/^Barangay\s/', $barangay)) {
            // If the input does not start with 'Barangay', prepend 'Barangay '
            $barangay = 'Barangay ' . $barangay;
        }

        // Check for 'Purok' prefix and remove if present
        if (stripos($purok, 'Purok ') === 0) {
            $purok = substr($purok, strlen('Purok '));
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Calculate the length of the hashed password
        $password_length = strlen($password);

        // Define the status (if it should be set to a default value like 'active')
        $status = 'pending'; 

        $hhid = preg_replace("/[^0-9]/", "", $hhid);
        $phylsis_id = preg_replace("/[^0-9]/", "", $phylsis_id);

        // Check if the length of $hhid is exactly 18
        if (strlen($hhid) !== 18) {
            /* die("HouseHold ID Should be 18 Numbers."); */
            echo "<script>alert('HouseHold ID Should be 18 Numbers!'); window.location='../../CreateUser.php';</script>";
        }

        try {
            // Execute the statement with parameters
            if (!$stmt->execute([$hhid, $hashed_password, $fname, $mname, $lname, $number, $barangay, $purok, $set, $phylsis_id, $status, $password_length])) {
                echo "Failed to insert user: " . implode(", ", $stmt->errorInfo());
                $flag = false;
            } else {
                $flag = true;
            }
        } catch (PDOException $e) {
            // Catch PDO exceptions
            if ($e->getCode() == 23000 && strpos($e->getMessage(), 'Duplicate entry') !== false) {
                echo "<script>alert('Failed to insert user: Duplicate HHID found.'); window.location='../../CreateUser.php';</script>";
            } 
        }
    }

    /* echo "<script>alert('Users created successfully!'); window.location='../../CreateUser.php';</script>"; */
    // Display an error if no records were inserted
    if ($flag === true) {
        echo "<script>alert('Users created successfully!'); window.location='../../CreateUser.php';</script>";
    } else {
        echo "<script>alert('Failed to create users! No records were inserted.'); window.location='../../CreateUser.php';</script>";
    }
}
?>