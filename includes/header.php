<?php
session_start();
$allowed_pages = array("profile.php", "login.php", "signup.php", "classes.php", "index.php", "course_details.php", "change_password.php", "admin_index.php", "change_admin.php");

if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_type'])) {
    $current_page = basename($_SERVER['PHP_SELF']);
    if (!in_array($current_page, $allowed_pages)) {
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles/style.css">
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container head">
        <a class="navbar-brand" href="index.php"><img src="https://bridgemusic.in/wp-content/uploads/2022/09/bridgemusic-logo.jpg" alt="Music Academy Logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mr-2">
                    <a class="nav-link text-warning" href="index.php">HOME</a>
                </li>
                <li class="nav-item mr-2">
                    <a class="nav-link additional-nav-link" href="classes.php">CLASSES</a>
                </li>
                <?php if(isset($_SESSION['user_name']) && isset($_SESSION['user_type'])): ?>
                    <li class="nav-item mr-2">
                        <a href="profile.php" class="btn my-profile-button">MY PROFILE</a>
                    </li>
                    <li class="nav-item mr-2">
                        <a href="logout.php" class="btn btn-danger">Log Out</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item mr-2">
                        <button type="button" onclick="window.location.href='admin_index.php'" class="btn btn-warning"><i class="fas fa-lock"></i> Admin Login</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" onclick="window.location.href='login.php'" class="btn btn-primary mr-2">Login</button>
                        <button type="button" onclick="window.location.href='signup.php'" class="btn btn-success">Sign Up</button>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<body class="custom-body">
