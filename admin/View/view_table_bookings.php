
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
    "../Assets/css/page/view-booking.css?v=1.0", // Menu-specific styles
];
include '../includes/layout/header.php';
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


<?php
function renderBookingSection($conn, $category)
{
    $sql = "SELECT * FROM table_bookings WHERE status = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table border='1' class='booking-display-table'>";
        echo "<thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Guest</th>
                            <th>Special Request</th>
                            <th>Status</th>
                            <th>Table Number</th>
                            <th>Actions</th>
                        </tr>
                      </thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['booking_date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['booking_time']) . "</td>";
            echo "<td>" . htmlspecialchars($row['guests']) . "</td>";
            echo "<td>" . htmlspecialchars($row['special_requests']) . "</td>";

            // Form for Status and Table Number Update
            echo "<td colspan='2'>
                <form action='../includes/update-booking.php' method='POST'>
                    <input type='hidden' name='booking_id' value='" . htmlspecialchars($row['booking_id']) . "'>
                    <select name='status' required>
                        <option value='Pending' " . ($row['status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                        <option value='Accepted' " . ($row['status'] == 'Accepted' ? 'selected' : '') . ">Accepted</option>
                        <option value='Rejected' " . ($row['status'] == 'Rejected' ? 'selected' : '') . ">Rejected</option>
                    </select>
                    <input type='number' name='table_number' value='" . htmlspecialchars($row['table_number']) . "'  placeholder='Table Number'>
                    <button type='submit' class='primary-btn book-update-btn'>Update</button>
                </form>
            </td>";

            // Delete Button
            echo "<td>
                <button 
                    class='delete-btn secondary-btn' 
                    onclick='confirmDelete(" . htmlspecialchars($row['booking_id']) . ")'>
                    Delete
                </button>
            </td>";

            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No items found in $category.</p>";
    }

    $stmt->close();
}
?>


<div class="main-content">

<!-- Alert msg  -->
<div id="custom-alert" class="alert-msg hidden">

</div>

    <h1>View Table Bookings
    </h1>
    <p><a href="dashboard.php"><i class="fa-solid fa-house"></i> Home</a> / Manage Table Bookings / View Table Bookings
    </p>

    <hr>

    <div class="view-Booking-container">

        <ul class="booking-category" id="booking-category">
            <li onclick="showBookingSection('pending-section')" id="pending-section-tab" class="tab active">
                <i class="fa-solid fa-spinner"></i> Pending
            </li>
            <li onclick="showBookingSection('accepted-section')" id="accepted-section-tab" class="tab">
                <i class="fa-solid fa-check"></i> Accepted
            </li>
            <li onclick="showBookingSection('rejected-section')" id="rejected-section-tab" class="tab">
                <i class="fa-solid fa-xmark"></i> Rejected
            </li>
        </ul>
    </div>


    <div class="booking-content">
        <?php
        $categories = ['pending', 'accepted', 'rejected'];

        foreach ($categories as $category) {
            $isPending = ($category === 'pending'); // Set Starter as active by default
            ?>
            <div id="<?= $category ?>-section" class="display-section <?= $isPending ? 'active' : '' ?>">
                <div class="content-heading">
                    <h3><?= ucfirst($category) ?></h3>


                    <?php renderBookingSection($conn, $category); ?>
                </div>

            </div>
        <?php } ?>
    </div>
</div>


<?php
include '../includes/layout/footer.php'
    ?>