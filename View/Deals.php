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
    SELECT d.id AS deal_id, d.deal_name, d.deal_image, d.deal_validity, d.deal_price, d.created_at
    FROM deals d
";
$result = $conn->query($query);
$deals = [];

while ($row = $result->fetch_assoc()) {
    $deal_id = $row['deal_id'];

    // Fetch associated menu items for this deal
    $itemsQuery = "
        SELECT m.name 
        FROM deal_items di 
        JOIN menu_items m ON di.product_id = m.id 
        WHERE di.deal_id = ?
    ";
    $stmt = $conn->prepare($itemsQuery);
    $stmt->bind_param('i', $deal_id);
    $stmt->execute();
    $itemsResult = $stmt->get_result();
    
    $itemNames = [];
    while ($itemRow = $itemsResult->fetch_assoc()) {
        $itemNames[] = $itemRow['name'];
    }

    // Store deal information
    $row['items'] = implode(", ", $itemNames);
    $row['expiry_date'] = date('Y-m-d H:i:s', strtotime($row['created_at'] . " + {$row['deal_validity']} days")); // Calculate expiry date
    $deals[] = $row;
}
?>

<div class="deals-container">
    <?php foreach ($deals as $deal): ?>
        <div class="deal-card">
            <div class="deal-image">
                <img src="../admin/<?= $deal['deal_image'] ?>" alt="<?= $deal['deal_name'] ?>">
            </div>
            <div class="deal-content">
                <h3><?= $deal['deal_name'] ?></h3>
                <p><strong>Items:</strong> <?= $deal['items'] ?></p>
                <p><strong>Price:</strong> ₹<?= $deal['deal_price'] ?></p>
                <p><strong>Valid Until:</strong> <span class="deal-timer" data-expiry="<?= $deal['expiry_date'] ?>"></span></p>
                <button class="add-to-cart-btn" data-id="<?= $deal['deal_id'] ?>">Add to Cart</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>



<?php include '../includes/Layout/footer.php'; ?>