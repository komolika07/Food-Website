<?php
$pageTitle = "Menu";
$pageStyles = [
    "../assets/css/pages/menu.css?v=2.0", // Menu-specific styles
];
include '../includes/Layout/header.php';
// include '../includes/Layout/Loginform.php';
include '../includes/Layout/navbar.php';
?>

<?php
require_once '../includes/db.php';
include "../includes/auth.php";

?>

<?php
function renderMenuSection($conn, $category, $meal_op)
{
    $stmt = $conn->prepare("SELECT * FROM menu_items WHERE category = ? AND meal_op = ?");
    $stmt->bind_param("ss", $category, $meal_op);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="card" data-id="<?= htmlspecialchars($row['id']) ?>" data-name="<?= htmlspecialchars($row['name']) ?>"
                data-rating="<?= htmlspecialchars($row['rating']) ?>" data-price="<?= htmlspecialchars($row['discounted_price']) ?>"
                data-original-price="<?= htmlspecialchars($row['price']) ?>"
                data-image="../admin/<?= htmlspecialchars($row['image_path']) ?>"
                data-description="<?= htmlspecialchars($row['description']) ?>"
                data-meal-op="<?= htmlspecialchars($row['meal_op']) ?>" data-category="<?= htmlspecialchars($row['category']) ?>">

                <div class="card-icons">
                    <button class="wishlist-btn" title="Add To Wishlist"><i class="fa fa-heart"></i></button>
                    <button class="quick-view-btn" title="Quick View"><i class="fa-solid fa-eye"></i></button>
                </div>

                <?= $row['meal_op'] === 'veg' ? '<div class="veg-meal-op">Veg</div>' : '<div class="nonveg-meal-op">Non-Veg</div>' ?>

                <img src="../admin/<?= htmlspecialchars($row['image_path']) ?>" alt="<?= htmlspecialchars($row['name']) ?>"
                    loading="lazy" />

                <div class="card-name-rating">
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <span>⭐ <?= htmlspecialchars($row['rating']) ?>.0</span>
                </div>

                <div class="card-prices">
                    <span class="price">₹<?= htmlspecialchars($row['discounted_price']) ?></span>
                    <?php if ((float) $row['discount'] > 0): ?>
                        <span class="original-price">₹<?= htmlspecialchars($row['price']) ?></span>
                        <span class="discount">-<?= htmlspecialchars($row['discount']) ?>%</span>
                    <?php endif; ?>
                </div>

                <div class="card-actions">
                    <button class="add-to-cart primary-btn" data-id="<?= $row['id'] ?>">Add To Cart</button>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p>No items found in $category ($meal_op).</p>";
    }
}
?>


<section class="Common-sec container">
    <!-- <h3>Our <b>Menu</b></h3> -->
    <p><a href="HomePage.php"><i class="fa-solid fa-house"></i> Home</a> > Menu</p>
</section>

<section class="menu-container">

    <aside class="menu-sidebar">

        <div class="menu-siderbar-heading">
            <div class="heading">
                <span><i class="fa-solid fa-utensils"></i> Menu Categories</span>
            </div>
        </div>

        <ul>
            <li onclick="showSection('starter-section')" id="starter-section-tab" class="active"><i
                    class="fi fi-rr-drumstick"></i> Starter</li>
            <li onclick="showSection('soup-section')" id="soup-section-tab"><i class="fi fi-rr-soup"></i> Soup</li>
            <li onclick="showSection('noodles-section')" id="noodles-section-tab"><i
                    class="fi fi-tr-bowl-chopsticks-noodles"></i> Noodles</li>
            <li onclick="showSection('rice-section')" id="rice-section-tab"><i class="fa-solid fa-bowl-rice"></i> Rice
            </li>
        </ul>
    </aside>

    <!-- Content Area -->
    <main class="content">
        <?php
        $categories = ['starter', 'rice', 'noodles', 'soup']; // Define all categories
        $meal_options = ['veg', 'nonveg']; // Meal options
        
        foreach ($categories as $category) {
            $isStarter = ($category === 'starter');
            ?>
            <div id="<?= $category ?>-section" class="menu-card-section <?= $isStarter ? 'active' : '' ?>">
                <div class="content-heading">
                    <?= ucfirst($category) ?>

                    <div class="V_NV_op">
                        <ul>
                            <?php foreach ($meal_options as $meal_op): ?>
                                <li onclick="showCardSection('<?= $category . '-' . $meal_op ?>')"
                                    id="<?= $category . '-' . $meal_op ?>-tab"
                                    class="<?= $meal_op === 'veg' ? 'active v_tab' : 'nv_tab' ?>">
                                    <img src="../assets/images/<?= $meal_op ?>.png" alt="<?= ucfirst($meal_op) ?>">
                                    <?= ucfirst($meal_op) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <?php foreach ($meal_options as $meal_op): ?>
                    <div id="<?= $category . '-' . $meal_op ?>" class="starter-menu <?= $meal_op === 'veg' ? 'active' : '' ?>">
                        <div class="cards-container">
                            <?php renderMenuSection($conn, $category, $meal_op); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
        }
        ?>

    </main>
</section>


<div id="quickview-popup" class="popup-container" style="display: none;">
    <div class="popup-content">
        <button class="close-popup">&times;</button>
        <div class="popup-inner">
            <div class="popup-left">
                <div class="main-image">
                    <img id="popup-main-image" src="path-to-image.jpg" alt="Product Image">
                </div>
            </div>
            <div class="popup-right">
                <h2 id="popup-category">category</h2>
                <h2 id="popup-title">Product Name</h2>
                <p class="rating">
                    ⭐ <span id="popup-rating"></span>.0
                </p>
                <div class="price">
                    <span id="popup-price">$24.00</span> -
                    <span id="popup-original-price">$40.00</span>
                </div>
                <p id="popup-description">
                    Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                </p>
                <div class="quantity-add">
                    <div class="quantity-selector">
                        <button class="decrement-btn">-</button>
                        <input type="number" value="1" min="1" class="quantity-input" name="quantity">
                        <button class="increment-btn">+</button>
                    </div>
                    <div class="action-buttons">
                        <button class="popup-add-to-cart primary-btn" data-id="">Add To Cart</button>
                        <button class="buy-now-btn secondary-btn">Buy Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/Layout/footer.php'; ?>