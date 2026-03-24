<?php
$host = "localhost";
$dbname = "your-dn";
$username = "your-username";
$password = "your-pass****";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>