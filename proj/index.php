<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paw It Forward</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Left Section with Black Background and Content -->
    <div class="left-section">
        <h1>be the <br> change they <br> need today</h1>
        <a href="donate.php" class="btn">donate now</a>
        <a href="#what-we-done" class="scroll-link">how donations help ↓</a>

        <!-- Expanded Content Section Below -->
        <div class="content-section">
            <h2>your donations <br> create real impact</h2>
            <p>Thousands of dogs face hardship every day due to abandonment, neglect, and lack of resources. Paw It Forward is not a shelter, but a platform that connects generous donors with trusted organizations and individuals working to improve the lives of these animals. Your support helps provide food, medical treatment, and essential supplies to those in need.</p>
        </div>

        <div class="content-section">
            <h2>how your contribution makes a difference</h2>
            <p>Every donation goes directly to funding critical care such as vaccinations, emergency medical treatment, and community initiatives that promote responsible pet ownership. By working with local rescues, veterinarians, and foster programs, we ensure that your generosity reaches those who need it most.</p>
        </div>

    </div>

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

</body>
</html>
