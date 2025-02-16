<<<<<<< Updated upstream
<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $is_logged_in = false;
} else {
    $is_logged_in = true;
}
?>

=======
>>>>>>> Stashed changes
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< Updated upstream
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
=======
    <title>Paw It Forward</title>
    <link rel="stylesheet" href="assets/css/style-thin.css">
</head>

<body>

    <!-- Site name + Nav -->
    <header>
        <a href="index.html" class="site-title" id="title">paw it forward</a>
        <div class="nav">
            <a href="donate-sign.html" class="nav-item-donate" id="donate-sign">donate</a>
            <a href="about.html" class="nav-item">our goal</a>
            <a href="contact.html" class="nav-item">contact</a>
            <a href="login.html" class="nav-item">account</a>
        </div>
    </header>

    <!-- Left Section w/ Content -->
    <div class="left-section">

        <div class="content-wrapper">
            <div class="content" id="hero">
                <div class="content-header">thank you so much for choosing to support paw it forward!</div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas  aliquam enim varius, gravida ante commodo, blandit ex. Duis at magna  pulvinar, imperdiet sapien vitae, feugiat lectus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas  aliquam enim varius, gravida ante commodo, blandit ex. Duis at magna  pulvinar, imperdiet sapien vitae, feugiat lectus.</p>
                <a href="#what-we-have-done" class="scroll-link">impact of your support</a>
            </div>
    
            <!-- Expanded Content Section Below -->
            <div class="content" id="what-we-have-done">
                <div class="content-header">your donations create real impact</div>
                <p>Thousands of dogs face hardship every day due to abandonment, neglect, and lack of resources. Paw It Forward is not a shelter, but a platform that connects generous donors with trusted organizations and individuals working to improve the lives of these animals. Your support helps provide food, medical treatment, and essential supplies to those in need.</p>
            </div>
            <div class="content">
                <div class="content-header">how your contribution makes a difference</div>
                <p>Every donation goes directly to funding critical care such as vaccinations, emergency medical treatment, and community initiatives that promote responsible pet ownership. By working with local rescues, veterinarians, and foster programs, we ensure that your generosity reaches those who need it most.</p>
            </div>
        </div>

        <a href="#title" class="bottom-up">go back up</a>

    </div>

    <!-- Right Section w/ Img -->
    <div class="right-section">
        <img src="/Paw-It-Forward_Frontend/assets/img/dogs (side)/erda-estremera-JBrbzg5N7Go-unsplash.jpg" alt="">
        <img src="/Paw-It-Forward_Frontend/assets/img/dogs (side)/tadeusz-lakota-OFPpEg7fm-I-unsplash.jpg" alt="">
        <img src="/Paw-It-Forward_Frontend/assets/img/dogs (side)/lucrezia-carnelos-8dZRksE0lEg-unsplash.jpg" alt="">
        <img src="/Paw-It-Forward_Frontend/assets/img/dogs (side)/flouffy--dMO9Dm-gkU-unsplash.jpg" alt="">
        <img src="/Paw-It-Forward_Frontend/assets/img/dogs (side)/karsten-winegeart-Z-rSM6yKgxo-unsplash.jpg" alt="">
    </div>
>>>>>>> Stashed changes

</body>
</html>
