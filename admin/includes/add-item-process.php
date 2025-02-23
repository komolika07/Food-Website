<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the item is a deal
    $isDeal = isset($_POST['is_deal']) ? 1 : 0;
    $uploadDir = '../Assets/uploads/';

    if ($isDeal) {
        // Deal-specific fields
        $dealName = mysqli_real_escape_string($conn, $_POST['deal_name']);
        $dealPrice = mysqli_real_escape_string($conn, $_POST['deal_price']);
        $dealValidity = mysqli_real_escape_string($conn, $_POST['deal_validity']);
        $selectedItems = $_POST['deal_items']; // Array of product IDs

        // Handle deal image upload
        $dealImageName = basename($_FILES['deal_image']['name']);
        $targetFile = $uploadDir . time() . '_' . $dealImageName;
        $dealImagePath = 'Assets/uploads/' . time() . '_' . $dealImageName;

        if (move_uploaded_file($_FILES['deal_image']['tmp_name'], $targetFile)) {
            // Insert deal into the `deals` table
            $query = "INSERT INTO deals (deal_name, deal_price, deal_validity, deal_image) 
                      VALUES ('$dealName', '$dealPrice', '$dealValidity', '$dealImagePath')";

            if (mysqli_query($conn, $query)) {
                $dealId = mysqli_insert_id($conn); // Get last inserted deal ID

                // Insert selected menu items into `deal_items` table
                foreach ($selectedItems as $productId) {
                    $query = "INSERT INTO deal_items (deal_id, product_id) VALUES ('$dealId', '$productId')";
                    mysqli_query($conn, $query);
                }

                $_SESSION['message'] = ['text' => 'New deal added successfully!', 'type' => 'success'];
            } else {
                $_SESSION['message'] = ['text' => 'Database Error: ' . mysqli_error($conn), 'type' => 'error'];
            }
        } else {
            $_SESSION['message'] = ['text' => 'Failed to upload the deal image.', 'type' => 'error'];
        }
    } else {
        // Regular menu item fields
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);
        $mealOp = mysqli_real_escape_string($conn, $_POST['meal-op']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $rating = mysqli_real_escape_string($conn, $_POST['rating']);
        $discount = isset($_POST['discount']) ? mysqli_real_escape_string($conn, $_POST['discount']) : 0;
        $description = mysqli_real_escape_string($conn, $_POST['description']);

        // Calculate discounted price
        $discountedPrice = ($price > 0 && $discount >= 0) ? $price - ($price * ($discount / 100)) : $price;

        // Handle item image upload
        $imageName = basename($_FILES['image']['name']);
        $targetFile = $uploadDir . time() . '_' . $imageName;
        $imagePath = 'Assets/uploads/' . time() . '_' . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Insert menu item into `menu_items` table
            $query = "INSERT INTO menu_items (name, category, price, status, discount, description, image_path, meal_op, discounted_price, rating)
                      VALUES ('$name', '$category', '$price', '$status', '$discount', '$description', '$imagePath', '$mealOp', '$discountedPrice', '$rating')";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION['message'] = ['text' => 'New menu item added successfully!', 'type' => 'success'];
            } else {
                $_SESSION['message'] = ['text' => 'Database Error: ' . mysqli_error($conn), 'type' => 'error'];
            }
        } else {
            $_SESSION['message'] = ['text' => 'Failed to upload the item image.', 'type' => 'error'];
        }
    }

    mysqli_close($conn);
    header('Location: ../view/add-new-item.php');
    exit();
}
?>
