<?php

session_start();

include "db.php";
// include("../includes/auth.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user_id = intval($_POST['user_id']);
    $f_name = $_POST['user_name'];
    $l_name = $_POST['user_lname'];
    $email = $_POST['user_email'];
    $feedback_message = $_POST['feedback_message'];

    $checkUserQuery = "SELECT user_id FROM user_form WHERE user_id = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
        $stmt->close();

        $insertQuery = "INSERT INTO feedback (user_id,f_name,l_name,email,message) VALUES(?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("issss", $user_id, $f_name, $l_name, $email, $feedback_message);

        if($stmt->execute()){
            $_SESSION['alert'] = ['message' => 'Your Feedback Submitted.', 'type' => 'success'];
        }
        else{
            $_SESSION['alert'] = ['message' => 'Failed to submit address.', 'type' => 'error'];
        }

    }else {
        $_SESSION['alert'] = ['message' => 'Error: User ID does not exist.', 'type' => 'error'];
    }

    $stmt->close();
    $conn->close();

    header("Location: ../View/contact.php");
    exit;
    
}
?>