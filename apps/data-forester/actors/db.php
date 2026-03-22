<?php
$host = "localhost";
$dbname = "forester";
$username = "forester_user";
$password = "password123";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>