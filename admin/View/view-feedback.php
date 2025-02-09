<?php
$pageTitle = "Menu";
$pageStyles = [
    "../Assets/css/page/view-items.css?v=1.0", // Menu-specific styles
];
include '../includes/layout/header.php';
?>

<?php
include "../includes/db.php";
session_start();

?>




<div class="main-content">
        <h1>View Feedback</h1>
        <p><a href="dashboard.php"><i class="fa-solid fa-house"></i> Home</a> / Manage Feedback / View Feedback</p>

        <hr>

<?php
        $sql = "SELECT * FROM feedback";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<table border='1' class='menu-table'>";
                echo "<thead>
                        <tr>
                            <th>First name </th>
                            <th>Last name </th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                      </thead>";
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['f_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['l_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                echo "<td>
                <button 
                    class='delete-btn primary-btn' 
                    onclick='confirmDeleteFeedback(" . htmlspecialchars($row['feedback_id']) . ")'>
                    Delete
                </button>
            </td>";
            
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No any feedback recieved.</p>";
            }

            $stmt->close();
        
?>

</div>

<?php 
    include '../includes/layout/footer.php'
?>