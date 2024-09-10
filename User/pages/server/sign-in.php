<?php
session_start();
ob_start();

// Include the database connection file
require_once(__DIR__ . '/../../../libraries/database.php');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Retrieve hhid and password from the form
            $hhid = preg_replace("/[^0-9]/", "", $_POST['hhid']);
            $password = $_POST['password'];
            $pending = 'pending';

            // Prepare SQL statement to fetch user information based on the provided hhid
            $sql = "SELECT acc_id, hhid, password, fname, lname, password_length FROM user_account WHERE hhid = :hhid AND status != :pending";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':hhid', $hhid);
            $stmt->bindParam(':pending', $pending);
            $stmt->execute();

            // Check if the user exists
            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $hashedPassword = $row['password'];

                // Verify the password
                if (password_verify($password, $hashedPassword)) {
                    // Password is correct
                    // Set session variable
                    $_SESSION['acc_id'] = $row['acc_id'];
                    $_SESSION['password'] = $row['password'];
                    $_SESSION['password_length'] = $row['password_length'];
                    /* $_SESSION['fname'] = $row['fname'];
                    $_SESSION['lname'] = $row['lname'];
                    $_SESSION['hhid'] = $hhid; */
                    $_SESSION['loggedin'] = true;

                    // Redirect the user to the dashboard or perform any other actions
                    header("Location: ../../index.php");
                    exit();

                } else {
                    // Password is incorrect
                    echo "<script>alert('Invalid hhid or Password')</script>";
                    echo "<script>window.location='../login.php';</script>";
                }
            } else {
                // User does not exist
                echo "<script>alert('Invalid hhid or Password')</script>";
                /* echo "<script>alert('User does not exist')</script>"; */
                echo "<script>window.location='../login.php';</script>";
            }
        }
?>