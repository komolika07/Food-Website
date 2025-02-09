<?php
$user_id = $_SESSION['user-id'];
// Ensure the session is started
if (!isset($_SESSION['user-id'])) {
    header('location:../view/loginForm.php');
    exit();
}

?>