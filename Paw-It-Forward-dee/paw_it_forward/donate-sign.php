<?php
    session_start();
    $pageTitle = "Donate Sign - Paw It Forward";
    include 'backend/paw_database.php'; // connect to database -- dee

    // If user is logged in, redirect them to the donation page
    if (isset($_SESSION['UserID'])) {
        header("Location: donate.php");
        exit();
    }
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
                <a href="admin-dash.php" class="nav-item">account</a>
                <a href="backend/admin_logout.php" class="nav-item">log out</a>

            <?php elseif (isset($_SESSION['UserID'])): ?>
                <a href="user-dash.php" class="nav-item">account</a>
                <a href="backend/user_logout.php" class="nav-item">log out</a>

            <?php else: ?>
                <a href="login.php" class="nav-item" id="active">account</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Left Section w/ Content -->
    <div class="left-section">

        <div class="content-wrapper">
            <div class="content" id="sign-in">
                <div class="content-header">want to support paw it forward? start by creating an account!</div>
                <div class="btn-section-top">
                    <a href="create-account.php" class="yellow-btn">create an account</a>
                    <a href="login.php" class="outline-btn">login</a>
                </div>
            </div>
        </div>

    </div>

    <!-- Right Section w/ Img -->
    <div class="right-section">
        <img src="assets/img/dogs (side)/flouffy-g2FtlFrc164-unsplash.jpg" alt="">
    </div>

</body>
</html>
