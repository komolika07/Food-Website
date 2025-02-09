<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'db.php'; // Include your database connection file

    // Sanitize form data
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = floatval($_POST['price']);
    $status = $_POST['status'];
    $discount = floatval($_POST['discount']);
    $description = $_POST['description'];
    $mealOp = $_POST['meal_op'];
    $discountedPrice = floatval($_POST['discounted_price']);
    $rating = floatval($_POST['rating']);

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imagePath = 'Assets/uploads/' . $imageName; // Specify the folder where images will be saved

        // Move the uploaded image to the desired folder
        move_uploaded_file($imageTmpName, '../' . $imagePath);
        
    } else {
        // If no new image is uploaded, retain the existing image (can pass the existing image path if needed)
        $imagePath = $_POST['image_path']; // Pass this via the form if needed
    }

    // Prepare the SQL query to update the product
    $sql = "UPDATE menu_items 
            SET name = ?, category = ?, price = ?, status = ?, discount = ?, description = ?, image_path = ?, meal_op = ?, discounted_price = ?, rating = ? 
            WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters and execute query
        $stmt->bind_param("ssdsdssssdi", $name, $category, $price, $status, $discount, $description, $imagePath, $mealOp, $discountedPrice, $rating, $id);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Item updated successfully!');
                    window.location.href = '../view/view-items.php'; // Redirect to the view-items page
                  </script>";
         // Success message
        } else {
            echo "error: failed to update product"; // Error message
        }

        $stmt->close();
    } else {
        echo "error: failed to prepare statement";
    }

    $conn->close();
}
?>
