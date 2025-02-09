<?php
session_start();
include "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user-id'];
    $id = intval($_POST['id']); // Address ID
    $user_name = $_POST['user-name'];
    $phone = $_POST['phone'];
    $address_line = $_POST['address_line'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];

    // Validate that the user owns this address
    $sql = "SELECT * FROM user_addresses WHERE address_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update the address
        $updateSql = "UPDATE user_addresses SET user_name = ?, phone = ?, address_line = ?, city = ?, state = ?, zip_code = ? WHERE address_id = ? AND user_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sssssiii", $user_name, $phone, $address_line, $city, $state, $zip, $id, $user_id);

        if ($updateStmt->execute()) {
        //    header("Location: ../View/profile.php");
        //    echo "<script>
        //           showAlert('Address Updated successfully!','success');
        //         </script>";
            $_SESSION['alert'] = ['message' => 'Address Updated successfully.', 'type' => 'success'];

        } else {
            // echo "error: " . $updateStmt->error;
            // header("Location: ../View/profile.php");
            // echo "<script>
            //         showAlert('Failed to update address','error'); 
            //       </script>";
            $_SESSION['alert'] = ['message' => 'Failed to update address.', 'type' => 'error'];

                  
        }

        $updateStmt->close();
    } else {
        // echo "error: address not found or unauthorized access.";
        $_SESSION['alert'] = ['message' => 'Address not found or unauthorized access.', 'type' => 'error'];

    }

    header("Location: ../View/profile.php");
    $stmt->close();
    $conn->close();
}

?>
