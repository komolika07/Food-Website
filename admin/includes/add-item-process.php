<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $meal_op = mysqli_real_escape_string($conn, $_POST['meal-op']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $discount = isset($_POST['discount']) ? mysqli_real_escape_string($conn, $_POST['discount']) : null;
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Handle file upload
    $uploadDir = '../Assets/uploads/';
    $imageName = basename($_FILES['image']['name']);
    $targetFile = $uploadDir . time() . '_' . $imageName; // Add timestamp to avoid overwriting
    $imagePath = 'Assets/uploads/' . time() . '_' . $imageName; // Save relative path for database

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        // Insert into database
        $query = "INSERT INTO menu_items (name, category, price, status, discount, description, image_path, meal_op)
                  VALUES ('$name', '$category', '$price', '$status', '$discount', '$description', '$imagePath', '$meal_op')";
        
        if (mysqli_query($conn, $query)) {
            $_SESSION['message'] = [
                'text' => 'New item added successfully!',
                'type' => 'success'
            ];
        } else {
            $_SESSION['message'] = [
                'text' => 'Database Error: ' . mysqli_error($conn),
                'type' => 'error'
            ];
        }
    } else {
        $_SESSION['message'] = [
            'text' => 'Failed to upload the image.',
            'type' => 'error'
        ];
    }

    mysqli_close($conn);
    header('Location: ../view/add-new-item.php');
    exit();
}
?>
