<?php
include '../includes/db.php';
// session_start(); // Start the session

// Check if the user is logged in and has the correct role
// if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'super_admin') {
//     // Redirect to the login page
//     header("Location: admin_login.php");
//     exit;
// }

// Admin panel content goes here
// echo "Welcome, " . htmlspecialchars($_SESSION['username']) . "! This is the Admin Panel.";
?>

<?php
$pageTitle = "Menu";
$pageStyles = [
    "../Assets/css/page/view-items.css?v=1.0", // Menu-specific styles
];
include '../includes/layout/header.php';
?>



<?php
function renderMenuSection($conn, $category, $option)
{
    $sql = "SELECT * FROM menu_items WHERE category = ? AND meal_op = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $category, $option);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table border='1' class='menu-table'>";
        echo "<thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Discounted Price</th>
                            <th>Rating</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                      </thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><img src='../" . htmlspecialchars($row['image_path']) . "' alt='" . htmlspecialchars($row['name']) . "' width='50'></td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>$" . number_format($row['price'], 2) . "</td>";
            echo "<td>$" . number_format($row['discounted_price'], 2) . "</td>";
            echo "<td>" . number_format($row['rating'], 1) . "</td>";
            echo "<td>
                <button class='edit-btn primary-btn' 
                data-id='" . $row['id'] . "' 
                data-name='" . htmlspecialchars($row['name']) . "'
                data-category='" . htmlspecialchars($row['category']) . "' 
                data-price='" . htmlspecialchars($row['price']) . "' 
                data-status='" . htmlspecialchars($row['status']) . "' 
                data-discount='" . htmlspecialchars($row['discount']) . "' 
                data-description='" . htmlspecialchars($row['description']) . "' 
                data-image='" . htmlspecialchars($row['image_path']) . "' 
                data-meal-op='" . htmlspecialchars($row['meal_op']) . "' 
                data-discounted-price='" . htmlspecialchars($row['discounted_price']) . "' 
                data-rating='" . htmlspecialchars($row['rating']) . "'
                onclick='openEditForm(this)'>Edit</button>
                </td>";

            echo "<td>
                <button 
                    class='delete-btn secondary-btn' 
                    onclick='confirmDelete(" . htmlspecialchars($row['id']) . ")'>
                    Delete
                </button>
            </td>";


            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No items found for $option in $category.</p>";
    }

    $stmt->close();
}
?>

<div class="main-content">
    <h1>View Items</h1>
    <p><a href="dashboard.php"><i class="fa-solid fa-house"></i> Home</a> / Manage Menu / View Item</p>

    <hr>

    <div class="view-menu-container">

        <ul class="menu-category" id="menu-category">
            <li onclick="showSection('Starter-section')" id="Starter-section-tab" class="tab active">
                <img src="../assets/images/2.png">Starter
            </li>
            <li onclick="showSection('Soup-section')" id="Soup-section-tab" class="tab">
                <img src="../assets/images/3.png">Soup
            </li>
            <li onclick="showSection('Noodles-section')" id="Noodles-section-tab" class="tab">
                <img src="../assets/images/1.png">Noodles
            </li>
            <li onclick="showSection('Rice-section')" id="Rice-section-tab" class="tab">
                <img src="../assets/images/4.png">Rice
            </li>
        </ul>
    </div>

    <div class="menu-content">
        <?php
        $categories = ['Starter', 'Soup', 'Noodles', 'Rice'];
        $meal_ops = ['Veg', 'Nonveg'];

        foreach ($categories as $category) {
            $isStarter = ($category === 'Starter'); // Set Starter as active by default
            ?>
            <div id="<?= $category ?>-section" class="menu-display-section <?= $isStarter ? 'active' : '' ?>">
                <div class="content-heading">
                    <h3><?= $category ?></h3>

                    <div class="meals_options">
                        <ul class="V_NV_tabs">
                            <?php foreach ($meal_ops as $option): ?>
                                <li onclick="showCardSection('<?= $category . '-' . ($option) ?>')"
                                    id="<?= $category . '-' . ($option) ?>-tab"
                                    class="<?= ($option) === 'Veg' ? 'active v_tab' : 'nv_tab' ?>">
                                    <img src="../assets/images/<?= ($option) ?>.png" alt="<?= $option ?>">
                                    <?= $option ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <?php foreach ($meal_ops as $option): ?>
                    <div id="<?= $category . '-' . ($option) ?>" class="menu <?= ($option) === 'Veg' ? 'active' : '' ?>">
                        <div class="cards-container">
                            <?php renderMenuSection($conn, $category, $option); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php } ?>
    </div>

    <div class="form-container">
        <div id="edit-form">
            <form action="../includes/update-product.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="edit-product-id" name="id">
                <div class="flex">
                    <div class="input">
                        <label for="edit-name">Product Name:</label>
                        <input type="text" id="edit-name" name="name" required>
                    </div>
                    <div class="input">
                        <label for="edit-category">Category:</label>
                        <input type="text" id="edit-category" name="category" required>
                    </div>
                </div>

                <div class="flex">
                    <div class="input">
                        <label for="edit-status">Status:</label>
                        <select id="edit-status" name="status" required>
                            <option value="in-stock">In Stock</option>
                            <option value="out-of-stock">Out of Stock</option>
                        </select>
                    </div>
                    <div class="input">
                        <label for="edit-meal-op">Meal Option:</label>
                        <select id="edit-meal-op" name="meal_op" required>
                            <option value="Veg">Veg</option>
                            <option value="Nonveg">Nonveg</option>
                        </select>
                    </div>
                    <div class="input">
                        <label for="edit-rating">Rating:</label>
                        <input type="number" id="edit-rating" name="rating" required>
                    </div>
                </div>

                <div class="flex">
                    <div class="input">
                        <label for="edit-price">Price:</label>
                        <input type="number" id="edit-price" name="price" step="0.01" required>
                    </div>
                    <div class="input">
                        <label for="edit-discounted-price">Discounted Price:</label>
                        <input type="number" id="edit-discounted-price" name="discounted_price" required>
                    </div>
                    <div class="input">
                        <label for="edit-discount">Discount:</label>
                        <input type="number" id="edit-discount" name="discount" required>
                    </div>

                </div>
                <label for="edit-description">Description:</label>
                <textarea id="edit-description" name="description" required></textarea>

                <label for="edit-image">Current Image:</label>
                <input type="hidden" name="image_path" id="edit-image-path" value="">
                <img id="edit-image" alt="Current Product Image" width="100">

                <label for="new-image">Change Image (Optional):</label>
                <input type="file" id="new-image" name="image">

                <button type="submit" class="primary-btn">Save Changes</button>
                <button type="button" id="cancel-btn">Cancel</button>
            </form>
        </div>
    </div>

    <!-- </div> -->


    <?php
    include '../includes/layout/footer.php'
        ?>