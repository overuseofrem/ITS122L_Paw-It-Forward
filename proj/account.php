<?php
session_start();
$error_message = "";

// Handle Login Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $account_type = $_POST["account_type"];

    // Dummy authentication (Replace with database verification)
    if ($account_type === "user" && $email === "user@example.com" && $password === "password") {
        $_SESSION['user_id'] = 1;
        $_SESSION['role'] = "user";
        header("Location: donate.php"); // Redirect to donation page
        exit();
    } elseif ($account_type === "admin" && $email === "admin@example.com" && $password === "adminpass") {
        $_SESSION['admin_id'] = 1;
        $_SESSION['role'] = "admin";
        header("Location: admin-dashboard.php"); // Redirect to Admin Dashboard
        exit();
    } else {
        $error_message = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - Paw It Forward</title>
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

<!-- Account Login Page -->
<div class="left-section">
    <h1>login</h1>

    <!-- Account Type Selection -->
    <div class="account-switch">
        <button id="userBtn" class="account-btn active">user account</button>
        <button id="adminBtn" class="account-btn">admin account</button>
    </div>

    <!-- Display Error Message -->
    <?php if (!empty($error_message)) : ?>
        <p class="error"><?= $error_message; ?></p>
    <?php endif; ?>

    <!-- Login Form (User & Admin) -->
    <form action="account.php" method="POST">
        <input type="hidden" id="accountType" name="account_type" value="user">
        <input type="email" name="email" placeholder="email address" required>
        <input type="password" name="password" placeholder="password" required>

        <button type="submit" class="btn yellow-btn">login in</button>
        <a href="register.php" class="btn outline-btn" id="createAccountBtn">create an account</a>
    </form>
</div>

<script>
    // Switch between user and admin login forms
    document.getElementById("userBtn").addEventListener("click", function() {
        document.getElementById("accountType").value = "user";
        document.getElementById("createAccountBtn").style.display = "inline-block";
        this.classList.add("active");
        document.getElementById("adminBtn").classList.remove("active");
    });

    document.getElementById("adminBtn").addEventListener("click", function() {
        document.getElementById("accountType").value = "admin";
        document.getElementById("createAccountBtn").style.display = "none"; // Hide create account for admin
        this.classList.add("active");
        document.getElementById("userBtn").classList.remove("active");
    });
</script>

</body>
</html>
