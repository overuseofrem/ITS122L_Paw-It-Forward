<?php
    $pageTitle = "Paw It Forward";
    include 'backend/user_dash.php'; // connect to backend

    // Check if user is logged in
    if (!isset($_SESSION['UserID'])) {
        header("Location: login.php");
        exit;
    }
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
            <a href="donate.php" class="nav-item-donate">donate</a>
            <a href="about.php" class="nav-item">our goal</a>
            <a href="contact.php" class="nav-item">contact</a>
            <?php if (isset($_SESSION['AdminID'])): ?>
                <a href="admin-dash.php" class="nav-item">account</a>
                <a href="backend/admin_logout.php" class="nav-item">log out</a>
            <?php elseif (isset($_SESSION['UserID'])): ?>
                <a href="user-dash.php" class="nav-item" id="active">account</a>
                <a href="backend/user_logout.php" class="nav-item">log out</a>
            <?php else: ?>
                <a href="login.php" class="nav-item" id="active">account</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Left Section w/ Content -->
    <div class="left-section">

        <div class="content-wrapper">
    
            <div class="content">
                <div class="content-header">welcome, <?php echo htmlspecialchars($userName); ?>!</div>
                <div class="bolder-mini">check out your certificates. <br> thank you so much for supporting paw it forward!</div>
            </div>

            <div class="content-certs">
                <?php if (empty($certificates)): ?>
                    <div class="no-certificates">
                        <p>You don't have any certificates yet. Make a donation to help a dog in need!</p>
                        <a href="donate.php" class="yellow-btn" style="display: inline-block; margin-top: 15px; padding: 8px 20px;">Donate Now</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($certificates as $cert): ?>
                        <div class="cert">
                            <img src="<?php echo htmlspecialchars($cert['CertificateImage']); ?>" alt="Certificate">
                            <div class="cert-info">
                                <h3>Certificate for donating to <?php echo htmlspecialchars($cert['DogName']); ?></h3>
                                <p>Issued: <?php echo date('F j, Y', strtotime($cert['IssuedDate'])); ?></p>
                                <a href="<?php echo htmlspecialchars($cert['CertificateImage']); ?>" target="_blank" class="yellow-btn" style="display: inline-block; margin-top: 10px; padding: 5px 15px; font-size: 0.9rem;">View Full Certificate</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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