<?php
$host = "localhost";
$dbname = "hkliuste_dataforestry";
$username = "hkliuste_JNN202";
$password = "j-8v33eBvPq)f6*";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>