<?php
session_start();
$error_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Simple validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Normally, you'd insert into the database here
        $_SESSION['user_id'] = 1; // Dummy session ID
        $_SESSION['user_name'] = $first_name;
        header("Location: donate.php"); // Redirect to donate page
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account - Paw It Forward</title>
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
        <a href="account.php" class="active">Account</a>
    </nav>
</header>

<!-- Registration Form Section -->
<div class="left-section">
    <h1>create an <br> account</h1>

    <!-- Display Error Message -->
    <?php if (!empty($error_message)) : ?>
        <p class="error"><?= $error_message; ?></p>
    <?php endif; ?>

    <form action="register.php" method="POST">
        <div class="name-fields">
            <input type="text" name="first_name" placeholder="first name" required>
            <input type="text" name="last_name" placeholder="last name" required>
        </div>
        <input type="email" name="email" placeholder="email address" required>
        <input type="password" name="password" placeholder="password" required>
        <input type="password" name="confirm_password" placeholder="confirm password" required>

        <button type="submit" class="btn yellow-btn">create account</button>
    </form>
</div>

</body>
</html>
