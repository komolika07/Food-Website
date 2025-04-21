<?php
$pageTitle = "Menu";
$pageStyles = [
  "../assets/css/pages/order_summary.css?v=3.0", // Menu-specific styles
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
if (isset($_GET['order_id'])) {
  $order_id = intval($_GET['order_id']);
  $sql = "SELECT o.*, u.email, u.phone_number, a.*
          FROM orders o
          JOIN user_form u ON o.user_id = u.user_id
          JOIN user_addresses a ON o.address_id = a.address_id
          WHERE u.user_id = ? AND o.order_id = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $user_id, $order_id);
  $stmt->execute();
  $order_result = $stmt->get_result();
  $order = $order_result->fetch_assoc();
  $stmt->close();


  $order_item_fetch_query = "SELECT o.*, m.name FROM order_items o JOIN menu_items m ON o.product_id = m.id WHERE o.order_id = ?";
  $stmt2 = $conn->prepare($order_item_fetch_query);
  $stmt2->bind_param("i", $order_id);
  $stmt2->execute();
  $result = $stmt2->get_result();

  $order_item = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $order_item[] = $row;
    }
  }
  $stmt2->close();
}


?>
<!-- Alert msg  -->
<div id="custom-alert" class="alert-msg hidden">

</div>
<section class="main">
  <section class="Common-sec container">
    <!-- <h3>Contact <b>Us</b></h3> -->
    <p><a href="HomePage.php"><i class="fa-solid fa-house"></i> Home</a> > Order </p>
  </section>


  <section class="order-details-container margin-inline">
    <!-- <div class="order-success-message">Thank You. Your order has been recieved.</div> -->

    <div class="order-details-dl">
      <div class="order-subdetails">
        
        <p class="order-subdetails-summary">Order #<b><?= htmlspecialchars($order_id) ?></b> was placed on
          <b><?= date('d-m-Y', strtotime($order['created_at'])) ?></b> and is currently
          <b><?= htmlspecialchars($order['order_status']) ?></b> .
        </p>


        <!-- order status line -->
        <?php
        $order_status = htmlspecialchars($order['order_status']);
        $status_steps = ["Confirmed", "Processing", "Out For Delivery", "Delivered"];
        $isCancelled = ($order_status === "Cancelled"); // Check if the order is cancelled
        
        // Determine the current index of the order status
        $currentIndex = array_search($order_status, $status_steps);

        echo '<div class="order-tracker">';

        foreach ($status_steps as $index => $step) {
          // Grey for pending, Green if reached this step
          $completedClass = ($currentIndex === false || $currentIndex < $index) ? "" : "completed";

          echo '<div class="step ' . $completedClass . '">
            <div class="circle">' . ($completedClass ? "✔" : "") . '</div>
            <p>' . $step . '</p>
          </div>';

          // Add line between steps
          if ($index < count($status_steps) - 1 || $isCancelled) {
            echo '<div class="line ' . ($completedClass ? "completed-line" : "") . '"></div>';
          }
        }

        // If order is cancelled, show cancelled step with a red line after "Delivered"
        if ($isCancelled) {
          echo '<div class="step cancelled">
            <div class="circle">✖</div>
            <p>Cancelled</p>
          </div>';
        }

        echo '</div>';
        ?>

      </div>

      <div class="order-details">
        <h4>Order Details</h4>

        <table class="order-details-product-table">
          <thead>
            <tr>
              <th>Product</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody id="order-details-product-body">
            <?php foreach ($order_item as $item): ?>
              <tr>
                <td><?= htmlspecialchars($item['name']) ?> X <?= htmlspecialchars($item['quantity']) ?></td>
                <td><?= htmlspecialchars($item['price']) ?></td>
              </tr>
            <?php endforeach; ?>
            <tr class="Subtotal">
              <td>Subtotal:</td>
              <td><?php echo htmlspecialchars($order['total_price']) ?></td>
            </tr>
            <tr>
              <td>Payment Method:</td>
              <td><?php echo ($order['payment_method'] === 'COD') ? "Cash On Delivery" : "Online Payment" ?></td>
            </tr>
            <tr class="total">
              <td>Total:</td>
              <td><?php echo ($order['total_price']) ?></td>
            </tr>
            <!-- Wishlist items will be dynamically inserted here -->

          </tbody>
        </table>
      </div>

      <div class="billing-details">
        <h4>Billing Details</h4>
        <hr>
        <div class="billing-Address">
          <p><?php echo htmlspecialchars($order['user_name']); ?></p>
          <p><?php echo htmlspecialchars($order['address_line']); ?></p>
          <p><?php echo htmlspecialchars($order['city']) . ' ' . htmlspecialchars($order['zip_code']) ?></p>
          <p><?php echo htmlspecialchars($order['state']) . ", India" ?></p>
          <p><i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars($order['phone']) ?> </p>
          <p class="email-field"><i class="fa-solid fa-envelope"></i> <?php echo htmlspecialchars($order['email']) ?>
          </p>
        </div>
      </div>
      <a href="../includes/generate-reciept.php?order_id=<?= $order_id ?>&total_price=<?= $order['total_price'] ?>&payment_method=<?= $order['payment_method'] ?>&order_date=<?= date('Y-m-d', strtotime($order['created_at'])) ?>"
        class=" primary-btn dl-btn">Download Receipt</a>

    </div>
  </section>


</section>

<?php include '../includes/Layout/footer.php'; ?>