<?php
session_start();

unset($_SESSION['admin_username']);
unset($_SESSION['admin_id']);

header("Location: ../admin_index.php");
exit;
?>