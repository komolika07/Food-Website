<?php
include '../includes/db.php'; // Database connection
?>

<!-- Individual CSS file for this page -->
<?php
$pageTitle = "Menu";
$pageStyles = ["../Assets/css/page/add-new-item.css?v=1.0"]; // Add styles
include '../includes/layout/header.php';
?>

<!-- Handle session messages -->
<?php
$message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
unset($_SESSION['message']); // Clear the message after displaying it
?>

<div class="main-content">
    <h1>Add Item</h1>
    <p><a href="dashboard.php"><i class="fa-solid fa-house"></i> Home</a> / Manage Menu / Add New Item</p>
    <hr>

    <!-- Form to add items -->
    <form class="add-item-form" action="../includes/add-item-process.php" method="POST" enctype="multipart/form-data">
        <div class="upload-msg">
            <?php if ($message): ?>
                <div class="alert <?= htmlspecialchars($message['type']) ?>">
                    <?= htmlspecialchars($message['text']) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="food-item-group is-this-deal">
            <span><b>Is this a Deal?</b></span>
            <input type="checkbox" id="is-deal" name="is_deal" value="1"> Yes
        </div>

        <!-- Regular menu item form -->
        <div id="regular-form">
            <div class="food-item-group">
                <label for="product-name">Product Name:</label>
                <input type="text" id="product-name" name="name" placeholder="Enter Product Name" required>
            </div>

            <div class="flex">
                <div class="food-item-group">
                    <label for="select-category">Select Category:</label>
                    <select id="select-category" name="category" required>
                        <option value="">Select category</option>
                        <option value="rice">Rice</option>
                        <option value="noodles">Noodles</option>
                        <option value="soup">Soup</option>
                        <option value="starter">Starter</option>
                    </select>
                </div>

                <div class="food-item-group">
                    <label for="meal-op">Meal Option:</label>
                    <select id="meal-op" name="meal-op" required>
                        <option value="">Select option</option>
                        <option value="veg">Veg</option>
                        <option value="nonveg">Non-Veg</option>
                    </select>
                </div>

                <div class="food-item-group">
                    <label for="product-price">Price:</label>
                    <input type="number" id="product-price" name="price" placeholder="Enter Price" required>
                </div>
            </div>

            <div class="flex">
                <div class="food-item-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="in-stock">In Stock</option>
                        <option value="out-of-stock">Out of Stock</option>
                    </select>
                </div>

                <div class="food-item-group">
                    <label for="rating">Rating:</label>
                    <input type="number" id="rating" name="rating" placeholder="Enter rating" required>
                </div>

                <div class="food-item-group">
                    <label for="discount">Discount (Optional):</label>
                    <input type="number" id="discount" name="discount" placeholder="Enter discount percentage">
                </div>
            </div>

            <div class="food-item-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" placeholder="Enter product description"
                    rows="4"></textarea>
            </div>

            <!-- Upload Image -->
            <div class="food-item-group custom-file">
                <label for="food-image">Upload Food Image:</label>
                <input type="file" id="fileInput" name="image" required>
            </div>
        </div>

        <!-- Deal-specific form (hidden by default) -->
        <div id="deal-form" style="display: none;">
            <div class="food-item-group">
                <label for="deal-name">Deal Name:</label>
                <input type="text" id="deal-name" name="deal_name" placeholder="Enter Deal Name">
            </div>

            <div class="food-item-group">
                <label for="deal-price">Deal Price:</label>
                <input type="number" id="deal-price" name="deal_price" placeholder="Enter Deal Price">
            </div>

            <div class="food-item-group">
                <label for="deal-validity">Deal Validity (Days):</label>
                <input type="number" id="deal-validity" name="deal_validity" placeholder="Enter Validity in Days">
            </div>

            <div class="food-item-group">
                <label>Select Products for this Deal:</label>
                <select name="deal_items[]" multiple>
                    <?php
                    $menuQuery = "SELECT id, name FROM menu_items WHERE is_deal = 0"; // Exclude deals
                    $result = mysqli_query($conn, $menuQuery);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="food-item-group custom-file">
                <label for="deal-image">Upload Deal Image:</label>
                <input type="file" id="deal-image" name="deal_image">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-actions">
            <button type="submit" class="primary-btn add-item-btn">Add Item</button>
        </div>
    </form>
</div>


<!-- Footer included -->
<?php include '../includes/layout/footer.php'; ?>