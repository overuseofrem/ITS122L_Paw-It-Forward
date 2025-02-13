<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Goal - Paw It Forward</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Left Section with Black Background and Content -->
    <div class="left-section">
        <h1>our goal: <br> bridging kindness <br> for a better world</h1>
 
        <!-- Content Sections -->
        <div class="content-section">
            <h2>our vision</h2>
            <p>We envision a world where acts of kindness make a lasting impact. Our mission is to create a compassionate network that connects generous donors with individuals and communities in need, ensuring support reaches those who require it most.</p>
        </div>

        <div class="content-section">
            <h2>how we help</h2>
            <p>Paw It Forward serves as a bridge between donors and recipients, facilitating the provision of essential resources such as food, medical assistance, and shelter. We work with volunteers and partners to ensure that every contribution directly improves lives.</p>
        </div>

        <div class="content-section">
            <h2>educating & advocating</h2>
            <p>Beyond providing aid, we promote awareness and advocate for sustainable support systems. Through education, outreach, and community-driven initiatives, we empower individuals to participate in meaningful change and make a difference in the lives of those in need.</p>
        </div>

        <!-- New Button Section Below Content -->
        <div class="button-container">
            <a href="donate.php" class="btn">Donate</a>
            <a href="contact.php" class="btn">Contact Us</a>
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
