<?php
    $pageTitle = "Paw It Forward";
    include 'backend/paw_database.php'; // Connect to database -- dee

    session_start();

    if (isset($_SESSION['admin_id'])) {
        session_unset();  // Clears session variables
        session_destroy(); // Destroys the session completely

        header("Location: admin-login.php?success=" . urlencode("Logged out successfully"));
        exit();
    }
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="assets/css/style-gen.css">
</head>

<body>

    <!-- Site name + Nav -->
    <header>
        <a href="index.php" class="site-title" id="title">paw it forward</a>
        <div class="nav">
            <a href="donate-sign.php" class="nav-item-donate">donate</a>
            <a href="about.php" class="nav-item">our goal</a>
            <a href="contact.php" class="nav-item">contact</a>
            <a href="login.php" class="nav-item" id="active">account</a>
        </div>
    </header>

    <!-- Left Section w/ Content -->
    <div class="left-section">
        <div class="content-wrapper">
            <div class="content" id="sign-in">
                <div class="content-header">admin login</div>
                <div class="btn-section-side">
                    <a href="login.php" class="outline-btn">user account</a>
                    <a href="admin-login.php" class="yellow-btn">admin account</a>
                </div>

                <!-- Admin Login Form -->
                <form action="backend/admin_login.php" method="post">
                    <div>
                        <input type="email" id="email" name="email" placeholder="email address" required>
                    </div>
                    <div>
                        <input type="password" id="password" name="password" placeholder="password" required>
                    </div>
                    <div class="btn-section-side">
                        <button type="submit" class="yellow-btn">login</button>
                    </div>
                </form>

                <!-- Error/Success Messages -->
                <?php
                if (isset($_GET['error'])) {
                    echo "<p style='color:red;'>" . htmlspecialchars($_GET['error']) . "</p>";
                }
                if (isset($_GET['success'])) {
                    echo "<p style='color:green;'>" . htmlspecialchars($_GET['success']) . "</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Right Section w/ Img -->
    <div class="right-section">
        <img src="assets/img/dogs (side)/flouffy-g2FtlFrc164-unsplash.jpg" alt="">
    </div>

</body>
</html>
