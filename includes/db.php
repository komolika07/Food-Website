<?php
$host = "localhost:3307";
$username = "root";
$password = "";
$dbname = "food_delivery";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>