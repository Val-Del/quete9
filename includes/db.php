<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = 'quete9';
$charset = '';


try {
    $conn = new PDO('mysql:host=' . $servername . ';dbname=' . $db . ';charset=UTF8', $username, $password,  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
