<?php

    $host = 'localhost';
    $dbname = 'capstone123';
    $username = 'root';
    $password = '';

    $dsn = "mysql:host=$host;dbname=$dbname";

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("SET NAMES 'utf8'");
        /* echo "successfully connected to the database"; */
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

   /*  function executeStatement($sql, $params = []) {
        global $pdo;
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            // Handle SQL errors
            die("Error executing statement: " . $e->getMessage());
        }
    }

    function fetchSingleRow($sql, $params = []) {
        $stmt = executeStatement($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function fetchAllRows($sql, $params = []) {
        $stmt = executeStatement($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } */


    /* $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "website_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } */

?>