<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $is_logged_in = false;
} else {
    $is_logged_in = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate - Paw It Forward</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <div class="logo">
        <a href="index.php">🐾 Paw It Forward</a>
    </div>
    <nav>
        <a href="donate.php" class="nav-btn">Donate</a>
        <a href="about.php">Our Goal</a>
        <a href="contact.php">Contacts</a>
        <a href="account.php">Account</a>
    </nav>
</header>

<!-- Donate Page Content -->
<div class="left-section">
    <?php if (!$is_logged_in): ?>
        <h1>want to support <br> paw it forward?<br> start by creating <br> an account!</h1>
        <a href="register.php" class="btn yellow-btn">create account</a>
        <a href="account.php" class="btn outline-btn">log in</a> <!-- Redirects to account.php -->
    <?php else: ?>
        <?php header("Location: donate-form.php"); exit(); ?> <!-- Directly redirects to donate-form.php -->
    <?php endif; ?>
</div>

</body>
</html>
