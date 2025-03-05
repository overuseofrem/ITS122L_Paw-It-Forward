<?php
    $pageTitle = "Our Goal - Paw It Forward";
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
            <a href="about.php" class="nav-item" id="active">our goal</a>
            <a href="contact.php" class="nav-item">contact</a>
            <a href="login.php" class="nav-item">account</a>
        </div>
    </header>

    <!-- Left Section w/ Content -->
    <div class="left-section">
        <div class="content-wrapper">
            <!-- Expanded Content Section Below -->
            <div class="content" id="what-we-have-done">
                <div class="content-header">every dog deserves a chance to have a better life</div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas aliquam enim varius, gravida ante commodo, blandit ex. Duis at magna pulvinar, imperdiet sapien vitae, feugiat lectus. Nullam tempor blandit efficitur. Nam quis odio nec sapien hendrerit imperdiet.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas aliquam enim varius, gravida ante commodo, blandit ex. Duis at magna pulvinar, imperdiet sapien vitae, feugiat lectus. Nullam tempor blandit efficitur. Nam quis odio nec sapien hendrerit imperdiet.</p>
            </div>
            <div class="content">
                <div class="content-header">we envisage a world where all animals are treated with respect</div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas aliquam enim varius, gravida ante commodo, blandit ex. Duis at magna pulvinar, imperdiet sapien vitae, feugiat lectus. Nullam tempor blandit efficitur. Nam quis odio nec sapien hendrerit imperdiet.</p>
            </div>
            <!-- New Button Section Below Content -->
            <div class="btn-section-side">
                <a href="donate-sign.php" class="yellow-btn">Donate</a>
                <a href="contact.php" class="yellow-btn">Contact Us</a>
            </div>
        </div>
        <a href="#title" class="bottom-up">go back up</a>
    </div>

    <!-- Right Section w/ Img -->
    <div class="right-section">
        <img src="assets/img/dogs (side)/jay-wennington-CdK2eYhWfQ0-unsplash.jpg" alt="">
    </div>

</body>
</html>
