<?php

session_start();

include "db.php";
// include("../includes/auth.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user_id = intval($_POST['user_id']);
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guest = intval($_POST['guests']);
    $request =$_POST['request'];

    $checkUserQuery = "SELECT user_id FROM user_form WHERE user_id = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
        $stmt->close();

        $insertQuery = "INSERT INTO table_bookings (user_id, name, phone ,email ,booking_date, booking_time, guests, special_requests, status) VALUES(?, ?, ?, ?, ? ,? ,? ,? ,'pending')";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("isssssss", $user_id, $name, $phone, $email, $date, $time, $guest, $request);

        if($stmt->execute()){
            $_SESSION['alert'] = ['message' => 'Your table booking request has been submitted. You will receive a notification once its reviewed.', 'type' => 'success'];
        }
        else{
            $_SESSION['alert'] = ['message' => 'Failed to submit booking request.', 'type' => 'error'];
        }

    }else {
        $_SESSION['alert'] = ['message' => 'Error: User ID does not exist.', 'type' => 'error'];
    }

    $stmt->close();
    $conn->close();

    header("Location: ../View/BookTable.php");
    exit;
    
}
?>