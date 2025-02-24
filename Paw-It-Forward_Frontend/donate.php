<?php
    $pageTitle = "Paw It Forward";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="assets/css/style-thin.css">
</head>

<body>

    <!-- Site name + Nav -->
    <header>
        <a href="index.php" class="site-title" id="title">paw it forward</a>
        <div class="nav">
            <a href="donate-sign.php" class="nav-item-donate" id="donate-sign">donate</a>
            <a href="about.php" class="nav-item">our goal</a>
            <a href="contact.php" class="nav-item">contact</a>
            <a href="login.php" class="nav-item">account</a>
        </div>
    </header>

    <!-- Left Section w/ Content -->
    <div class="left-section">
        <div class="content-wrapper">
            <div class="content" id="hero">
                <div class="content-header">thank you so much for choosing to support paw it forward!</div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                <a href="#donation-info" class="scroll-link">impact of your support</a>
            </div>
    
            <!-- Expanded Content Section Below -->
            <div class="content" id="donation-info">
                <div class="content-header">how your contribution makes a difference</div>
                <p>Every donation goes directly to funding critical care...</p>
                <a href="#projects" class="scroll-link">dogs in need</a>
            </div>

            <!-- Donation Sections -->
            <?php for ($i = 0; $i < 3; $i++): ?>
            <div class="donation-content">
                <div class="donation-head">
                    <div class="donation-title">dog</div>
                    <div class="donation-raised">PHP 15,000/PHP 20,000 raised!</div>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                <div class="donation-img">
                    <img src="/Paw-It-Forward_Frontend/assets/img/dogs (side)/undine-tackmann-8mxSINYFoSw-unsplash.jpg" alt="" class="dog-img">
                    <img src="/Paw-It-Forward_Frontend/assets/img/qr codes/qr.png" alt="" class="qr-code">
                </div>
            </div>
            <?php endfor; ?>

            <div class="content" id="cert-submission">
                <div class="content-header">submit your donation proof below and receive a certificate!</div>
                <button class="yellow-btn" id="uploadButton">submit donation proof</button>
                <input type="file" id="fileInput" name="file" accept="image/*">
            </div>
        </div>
        <a href="#title" class="bottom-up">go back up</a>
    </div>

    <!-- Right Section w/ Img -->
    <div class="right-section">
        <?php 
        $images = [
            "erda-estremera-JBrbzg5N7Go-unsplash.jpg"
        ];
        foreach ($images as $image): ?>
            <img src="/Paw-It-Foward_Frontend/assets/img/dogs (side)/<?php echo $image; ?>" alt="">
        <?php endforeach; ?>
    </div>

</body>
</html>
