<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Paw It Forward</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <div class="logo">
        <a href="index.php">🐾 Paw It Forward</a>
    </div>
    <nav>
        <a href="donate.php" class="nav-btn <?= basename($_SERVER['PHP_SELF']) == 'donate.php' ? 'active' : ''; ?>">Donate</a>
        <a href="about.php" class="<?= basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">Our Goal</a>
        <a href="contact.php" class="<?= basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">Contact Us</a>
        <a href="account.php" class="<?= basename($_SERVER['PHP_SELF']) == 'account.php' ? 'active' : ''; ?>">Account</a>
    </nav>
</header>

<!-- Contact Section (Maintaining Black Background on Left) -->
<div class="left-section">
    <h1>get in touch <br> with us today</h1>

    <div class="content-section">
        <h2>reach us online</h2>
        <div class="social-links">
            <a href="https://www.facebook.com/ph.PawItForward/" target="_blank" class="social-btn fb">Facebook</a>
 
        </div>
    </div>

    <div class="content-section">
        <h2>visit us</h2>
        <p>Cavite, Philippines, 4100</p>
    </div>

    <div class="content-section">
        <h2>our location</h2>
        <div class="map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15452.096605021208!2d120.8988645!3d14.4833027!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397cd3382348f07%3A0x8ba0f19ca88f4f54!2sCaridad%2C%20Cavite%20City%2C%204100%20Cavite!5e0!3m2!1sen!2sph!4v1739417814929!5m2!1sen!2sph"
                width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
        </div>
    </div>

</div>


</body>
</html>
