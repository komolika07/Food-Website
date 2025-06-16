<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $f_name = mysqli_real_escape_string($conn, $_POST['name']);
    $l_name = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    // Check if first or last name contains anything other than letters
    if (!preg_match("/^[a-zA-Z]+$/", $f_name) || !preg_match("/^[a-zA-Z]+$/", $l_name)) {
        $_SESSION['message'] = [
            'text' => 'First and Last names should only contain letters.',
            'type' => 'error'
        ];
        header('Location: ../view/RegisterForm.php');
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = [
            'text' => 'Invalid email format.',
            'type' => 'error'
        ];
        header('Location: ../view/RegisterForm.php');
        exit();
    }

    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email='$email'") or die("query failed");

    if (mysqli_num_rows($select) > 0) {
        $_SESSION['message'] = [
            'text' => 'User Already Exists!',
            'type' => 'error'
        ];
        header('Location: ../view/RegisterForm.php');
    } else {
        $query = "INSERT INTO user_form (f_name, l_name, email, password)
                  VALUES ('$f_name', '$l_name', '$email', '$password')";
        
        if (mysqli_query($conn, $query)) {
            $_SESSION['message'] = [
                'text' => 'Registered Successfully! Please Login Now!',
                'type' => 'success'
            ];
            header('Location: ../view/RegisterForm.php');
        } else {
            $_SESSION['message'] = [
                'text' => 'Database Error: ' . mysqli_error($conn),
                'type' => 'error'
            ];
        }
    }

    mysqli_close($conn);
    exit();
}

?>
