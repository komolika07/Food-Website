<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email='$email' AND password ='$password'") or die("query failed");

    if(mysqli_num_rows($select) > 0){
        $rows = mysqli_fetch_assoc($select);
        $_SESSION['user-id'] = $rows['user_id'];
        header('Location: ../view/HomePage.php');
    }
    else{
        $_SESSION['message'] = [
            'text' => 'Incorrect credentials!',
            'type' => 'error'
           ];
           header('Location: ../view/loginForm.php'); 
    }

    mysqli_close($conn);
    exit();
}
?>