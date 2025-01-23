<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <script src="../assets/js/admin.js" defer></script>
    <style>
       
    </style>
</head>
<body>

<?php
    if (!empty($pageStyles)) {
        foreach ($pageStyles as $style) {
            echo "<link rel='stylesheet' href='$style'>";
        }
    }
    ?>


<?php
include '../includes/layout/sidebar.php';
?>