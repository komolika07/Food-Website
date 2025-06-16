<?php
$pageTitle = "Menu";
$pageStyles = [
    "../assets/css/pages/deals.css?v=1.0", // Menu-specific styles
];
include '../includes/Layout/header.php';
// include '../includes/Layout/Loginform.php';
include '../includes/Layout/navbar.php';
?>
<?php
include "../includes/db.php";
include "../includes/auth.php";
?>

<?php
if (isset($_SESSION['alert'])):
    $message = $_SESSION['alert']['message'];
    $type = $_SESSION['alert']['type'];
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            showAlert("<?php echo htmlspecialchars($message); ?>", "<?php echo $type; ?>");
        });
    </script>
    <?php
    unset($_SESSION['alert']); // Clear the alert message after showing it
endif;
?>


<!-- Alert msg  -->
<div id="custom-alert" class="alert-msg hidden">

</div>
<section class="Common-sec container">
    <!-- <h3>Contact <b>Us</b></h3> -->
    <p><a href="HomePage.php"><i class="fa-solid fa-house"></i> Home</a> > Deals </p>
</section>




<?php
$query = "
SELECT d.id AS deal_id, d.deal_name, d.deal_image, d.deal_validity, d.deal_price, d.rating, d.description, d.created_at
FROM deals d
";

$result = $conn->query($query);
$deals = [];

while ($row = $result->fetch_assoc()) {
    $deal_id = $row['deal_id'];

    // Fetch associated menu items and their prices
    $itemsQuery = "
        SELECT m.*
        FROM deal_items di 
        JOIN menu_items m ON di.product_id = m.id 
        WHERE di.deal_id = ?
    ";
    $stmt = $conn->prepare($itemsQuery);
    $stmt->bind_param('i', $deal_id);
    $stmt->execute();
    $itemsResult = $stmt->get_result();

    $itemNames = [];
    $totalOriginalPrice = 0;
    while ($itemRow = $itemsResult->fetch_assoc()) {
        $itemNames[] = $itemRow['name'];
        $totalOriginalPrice += $itemRow['discounted_price']; // Sum up original prices
    }

    // Calculate discount percentage
    $dealPrice = $row['deal_price'];
    $discountPercentage = ($totalOriginalPrice > 0) ? round((($totalOriginalPrice - $dealPrice) / $totalOriginalPrice) * 100) : 0;

    // Store deal information
    $row['items'] = implode(", ", $itemNames);
    $row['total_original_price'] = $totalOriginalPrice;
    $row['discount_percentage'] = $discountPercentage;
    $row['expiry_date'] = date('Y-m-d H:i:s', strtotime($row['created_at'] . " + {$row['deal_validity']} days")); // Calculate expiry date
    $deals[] = $row;
}
?>

<div class="deals-section">
    <h2>Combo Deals</h2>
    <div class="deals-container">
        <?php foreach ($deals as $deal): ?>
            <div class="card deal-card" data-id="<?= $deal_id ?>" data-name="<?= htmlspecialchars($deal['deal_name']) ?>"
                data-rating="<?= htmlspecialchars($deal['rating']) ?>" data-price="<?= htmlspecialchars($deal['deal_price']) ?>"
                data-original-price="<?= htmlspecialchars(string: $deal['total_original_price']) ?>"
                data-discount="<?= htmlspecialchars($deal['discount_percentage']) ?>"
                data-image="../admin/<?= htmlspecialchars($deal['deal_image']) ?>"
                data-description="<?= htmlspecialchars($deal['description']) ?>"
                data-type="deal"
                data-items="<?= htmlspecialchars(json_encode(explode(" , ", $deal['items'])), ENT_QUOTES, 'UTF-8') ?>">

                <div class="deal-image">
                    <img src="../admin/<?= $deal['deal_image'] ?>" alt="<?= $deal['deal_name'] ?>">
                </div>
                <div class="card-icons">
                    <button class="wishlist-btn" data-type="deal"  data-original-price="<?= htmlspecialchars(string: $deal['total_original_price']) ?>" title="Add To Wishlist"><i class="fa fa-heart"></i></button>
                    <button class="deal-quick-view-btn" title="Quick View"><i class="fa-solid fa-eye"></i></button>
                </div>
                <div class="deal-content">
                    <h2><?= $deal['deal_name'] ?></h2>
                    <p><strong>Items:</strong> <?= $deal['items'] ?></p>
                    <div class="price">
                        <span id="deal-price">₹<?= number_format($deal['deal_price'], 2) ?></span>
                        <span id="deal-original-price">₹<?= number_format($deal['total_original_price'], 2) ?></span>
                        <span id="deal-discount"
                            style="color: green; font-weight: bold;"><?= $deal['discount_percentage'] ?>% OFF</span>
                    </div>
                    <!-- <p><strong>Original Price:</strong> ₹<?= number_format($deal['total_original_price'], 2) ?></p>
                <p><strong>Deal Price:</strong> ₹<?= number_format($deal['deal_price'], 2) ?></p>
                <p><strong>Discount:</strong> <span
                        style="color: green; font-weight: bold;"><?= $deal['discount_percentage'] ?>% OFF</span></p> -->
                    <p id="deal_validity"><strong></strong> <span class="deal-timer"
                            data-expiry="<?= $deal['expiry_date'] ?>"></span>
                    </p>
                    <button class="add-to-cart-btn primary-btn" data-id="<?= $deal['deal_id'] ?>">Add to Cart</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<div id="deal-popup" class="deal-container" style="display: none;">
  <div class="deal-content">
    <button class="deal-close-popup">&times;</button>
    <div class="deal-inner">
      <div class="deal-left">
        <div class="main-image">
          <img id="deal-main-image" src="" alt="Product Image">
        </div>
      </div>
      <div class="deal-right">
        <h2 id="deal-category"></h2>
        <h3 id="deal-title"></h3>
        <p class="rating">
          ⭐ <span id="deal-rating"></span>.0
        </p>
        <div class="popup-price">
          <span id="popup-deal-price"></span>
          <span id="popup-deal-original-price"></span>
          <span id="popup-deal-discount"></span>
        </div>
        <p id="deal-description">
          Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
        </p>
        
          <div id="deal-status">
            
          </div>
          <div class="action-buttons">
            <button class="deal-add-to-cart primary-btn" data-id="">Add To Cart</button>
            <button class="buy-now-btn secondary-btn" id="popup-buy-now" data-id="">Buy Now</button>

          </div>
       
      </div>
    </div>
  </div>
</div>
<?php include '../includes/Layout/footer.php'; ?>