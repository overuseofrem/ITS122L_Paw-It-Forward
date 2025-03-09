<?php
    session_start(); // session started
    $pageTitle = "Contact Us - Paw It Forward";
    include 'backend/paw_database.php'; // connect to database -- dee
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
            <a href="<?php echo (isset($_SESSION['UserID']) || isset($_SESSION['AdminID'])) ? 'donate.php' : 'donate-sign.php'; ?>" class="nav-item-donate">donate</a>
            <a href="about.php" class="nav-item">our goal</a>
            <a href="contact.php" class="nav-item">contact</a>

            <?php if (isset($_SESSION['AdminID'])): ?>
                <a href="admin-dash.php" class="nav-item">dashboard</a>
                <a href="backend/admin_logout.php" class="nav-item">log out</a>

            <?php elseif (isset($_SESSION['UserID'])): ?>
                <a href="user-dash.php" class="nav-item">dashboard</a>
                <a href="backend/user_logout.php" class="nav-item">log out</a>

            <?php else: ?>
                <a href="login.php" class="nav-item" id="active">account</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Left Section w/ Content -->
    <div class="left-section">

        <div class="content-wrapper">
            <!-- Expanded Content Section Below -->
            <div class="content">
                <div class="content-header">get in touch</div>
                <div class="socials">
                    <a href="https://www.facebook.com/ph.PawItForward/" class="social-link">facebook</a>
                </div>
                <div class="address">
                    <div class="bolder-mini">visit us at our address</div>
                    <p>4100 Cavite, Philippines</p>
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15452.096605021208!2d120.8988645!3d14.4833027!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397cd3382348f07%3A0x8ba0f19ca88f4f54!2sCaridad%2C%20Cavite%20City%2C%204100%20Cavite!5e0!3m2!1sen!2sph!4v1739417814929!5m2!1sen!2sph"
                            width="100%" height="310" style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>

        <a href="#title" class="bottom-up">go back up</a>

    </div>

    <!-- Right Section w/ Img -->
    <div class="right-section">
        <img src="assets/img/dogs (side)/mitchell-orr-PUY5xUszd3Y-unsplash.jpg" alt="">
    </div>

</body>
</html>
