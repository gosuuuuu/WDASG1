<?php

$host = "localhost"; // using own localhost - MySql from xampp
$dbname = "utb_sport_facilities"; // my datase
$username = "root"; //mysql username
$password = "";

try { //try catch if database work if no catch error below
    $pdo = new PDO( // we use to communicate PHP and MySql
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) { // if database error
    die("Database connection failed: " . $e->getMessage());
}
?>