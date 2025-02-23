<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'super_admin') {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_SESSION['id']; // Get admin's ID from session
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the admin's current password from the database
    $query = "SELECT password FROM admin_user WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        // Verify old password
        if (password_verify($old_password, $hashed_password)) {
            // Check if new passwords match
            if ($new_password === $confirm_password) {
                // Hash the new password
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the database
                $update_query = "UPDATE admin_user SET password = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("si", $new_hashed_password, $admin_id);

                if ($update_stmt->execute()) {
                    echo "<script>alert('Password changed successfully!');</script>";
                    header("Location:../view/dashboard.php");
                    session_destroy();
                    echo "<script>
                                alert('Password changed successfully! Please log in again.');
                                window.location.href = '../view/admin_login.php';
                          </script>";
                    exit;
                } else {
                    echo "<script>alert('Error updating password.');</script>";
                }
            } else {
                echo "<script>alert('New passwords do not match.');</script>";
            }
        } else {
            echo "<script>alert('Old password is incorrect.');</script>";
        }
    }
}
?>