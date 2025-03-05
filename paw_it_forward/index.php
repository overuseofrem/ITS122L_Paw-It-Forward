<?php
    $pageTitle = "Paw It Forward";
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
            <a href="donate-sign.php" class="nav-item-donate">donate</a>
            <a href="about.php" class="nav-item">our goal</a>
            <a href="contact.php" class="nav-item">contact</a>
            <a href="login.php" class="nav-item">account</a>
        </div>
    </header>

    <!-- Left Section w/ Content -->
    <div class="left-section">

        <div class="content-wrapper">
            <div class="content" id="hero">
                <div class="content-header">be the change you want to see in the world</div>
                <a href="donate-sign.php" class="yellow-btn">donate</a>
                <a href="#what-we-have-done" class="scroll-link">what we've done</a>
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
        <img src="assets/img/dogs (side)/ryan-walton-AbNO2iejoXA-unsplash.jpg" alt="">
    </div>

</body>
</html>
