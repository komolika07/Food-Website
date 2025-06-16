<?php
$host = "localhost";
$username = "Your username";
$password = "Your password";
$dbname = "your database name";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // echo "Database connected successfully!";
}
?>
