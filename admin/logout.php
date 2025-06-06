<?php
session_start();
session_destroy();
header('Location: /Shoe Shop/login.php'); // Redirect to login page
exit();
?>
