<?php
session_start();
session_destroy();
header("Location: ../View/admin_login.php");
exit;
?>
