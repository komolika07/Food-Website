<?php
session_start();
require_once '../includes/db.php';
include '../includes/auth.php';

if (!isset($_SESSION['user-id'])) {
    $_SESSION['alert'] = ['message' => 'Please log in to update your profile.', 'type' => 'error'];
    header("Location: ../View/loginForm.php");
    exit;
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$gender = $_POST['gender'];

if (!preg_match('/^\d{10,15}$/', $phone_number)) {
    $_SESSION['alert'] = ['message' => 'Please enter a valid phone number (10 to 15 digits).', 'type' => 'error'];
    header("Location: ../View/profile.php");
    exit;
}

$sql = "UPDATE user_form SET f_name = ?, l_name = ?, email = ?, phone_number = ?, gender = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssi', $first_name, $last_name, $email, $phone_number, $gender, $_SESSION['user-id']);

if ($stmt->execute()) {
    $_SESSION['alert'] = ['message' => 'Profile updated successfully.', 'type' => 'success'];
} else {
    $_SESSION['alert'] = ['message' => 'Failed to update profile.', 'type' => 'error'];
}

$stmt->close();
$conn->close();

header("Location: ../View/profile.php");
exit;
?>
