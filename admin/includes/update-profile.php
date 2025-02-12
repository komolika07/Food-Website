<?php
session_start();
include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; // Get user ID from the form
    $username = $_POST['username'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    // Update query
    $query = "UPDATE users SET username = ?, contact = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $username, $contact, $email, $id);

    if ($stmt->execute()) {
        // Update session username if it was changed
        // $_SESSION['username'] = $username;
        echo "<script>alert('Profile updated successfully!'); </script>";
        header("Location: ../View/dashboard.php");
    } else {
        echo "<script>alert('Failed to update profile.'); </script>";
    }
}
?>
