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
    <link rel="stylesheet" href="assets/css/style-thin.css">
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
    
            <div class="content">
                <div class="content-header">welcome, user!</div>
                <div class="bolder-mini">check out your certificates. <br> thank you so much for supporting paw it forward!</div>
            </div>

            <div class="content-certs">
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <div class="cert"></div>
                <?php endfor; ?>
            </div>

        </div>

        <a href="#title" class="bottom-up">go back up</a>

    </div>

    <!-- Right Section w/ Img -->
    <div class="right-section">
        <img src="assets/img/dogs (side)/marek-szturc-CM1oVEUzsNM-unsplash.jpg" alt="">
    </div>

</body>
</html>
