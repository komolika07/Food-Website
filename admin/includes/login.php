<?php
// Database connection
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role']; // super_admin or delivery_person
    $username = $_POST['admin-username'];
    $password = $_POST['admin-password'];

    if (empty($role) || empty($username) || empty($password)) {
        $_SESSION['message'] = [
            'text' => 'All Fields Required!',
            'type' => 'error'
           ];
    } else {
        // Fetch user from database
        $query = "SELECT * FROM admin_user WHERE username = ? AND role = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {

                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;


                if ($role === 'super_admin') {
                    // Redirect to Admin Panel
                    header("Location: ../view/dashboard.php");
                    exit;
                } elseif ($role === 'delivery_person') {
                    // Redirect to Delivery Panel
                    header("Location: ../view/delivery_panel.php");
                    exit;
                }
            } else {
                $_SESSION['message'] = [
                    'text' => 'Incorrect credentials!',
                    'type' => 'error'
                   ];
                   header("Location:../view/admin_login.php");
            }
        } else {
            $_SESSION['message'] = [
                'text' => 'User Not Found!',
                'type' => 'error'
               ];
               header("Location:../view/admin_login.php");
        }
    }
}
?>
