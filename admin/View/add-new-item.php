<?php
$pageTitle = "Menu";
$pageStyles = [
    "../Assets/css/page/add-new-item.css?v=1.0", // Menu-specific styles
];
include '../includes/layout/header.php';
?>
<?php
session_start();
$message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
unset($_SESSION['message']); // Clear the message after displaying it
?>

<div class="main-content">
        <h1>Add item</h1>
        <p><a href="dashboard.php"><i class="fa-solid fa-house"></i> Home</a> / Manage Menu / Add New Item</p>

        <hr>
        <form class="add-item-form" action="../includes/add-item-process.php" method="POST" enctype="multipart/form-data">
            <div class="upload-msg">
                <?php if ($message): ?>
                    <div class="alert <?= htmlspecialchars($message['type']) ?>">
                        <?= htmlspecialchars($message['text']) ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="food-item-group">
                <label for="product-name">Product Name :</label>
                <input type="text" id="product-name" class="product-name" name="name" placeholder="Enter Product Name" required>
            </div>
            <div class="flex">
                <div class="food-item-group">
                    <label for="select-category">Select Category :</label>
                    <select id="select-category" name="category">
                        <option value="">Select category</option>
                        <option value="rice">Rice</option>
                        <option value="noodles">Noodles</option>
                        <option value="soup">Soup</option>
                        <option value="starter">Starter</option>
                    </select>
                </div>

                <div class="food-item-group">
                    <label for="meal-op">Meal Option:</label>
                    <select id="meal-op" name="meal-op">
                        <option value="">Select option</option>
                        <option value="veg">veg</option>
                        <option value="nonveg">nonveg</option>
                    </select>
                </div>

                <div class="food-item-group">
                    <label for="product-price">Price :</label>
                    <input type="number" id="product-price" class="product-price" name="price" placeholder="Enter Price"required>
                </div>

            </div>

            <div class="flex">
                <div class="food-item-group">
                    <label for="status">Status :</label>
                    <select id="status" name="status" required>
                        <option value="in-stock">In Stock</option>
                        <option value="out-of-stock">Out of Stock</option>
                    </select>
                </div>

                <!-- Discount (Optional) -->
                <div class="food-item-group">
                    <label for="discount">Discount (Optional):</label>
                    <input type="number" id="discount" name="discount" placeholder="Enter discount percentage">
                </div>
            </div>


            <div class="food-item-group">
                <label for="description">Description :</label>
                <textarea id="description" name="description" placeholder="Enter product description"></textarea>
            </div>

            <!-- Upload Image -->
            <div class="food-item-group custom-file">
                <label for="food-image">Upload Food Image :</label>
                <input type="file" id="fileInput" name="image">
            </div>

            <!-- Submit Button -->
            <div class="form-actions">
                <button type="submit " class="primary-btn">Add Menu Item</button>
            </div>
        </form>
    </div>

    <?php 
    include '../includes/layout/footer.php'
    ?>