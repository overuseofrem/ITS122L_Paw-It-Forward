<?php
    $pageTitle = "Paw It Forward - Admin Donations";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="assets/css/css-admin.css">
</head>

<body>

    <!-- Site name + Nav -->
    <header>
        <a href="index.php" class="site-title" id="title">paw it forward</a>
        <div class="nav">
            <a href="donate-sign.php" class="nav-item-donate">donate</a>
            <a href="about.php" class="nav-item">our goal</a>
            <a href="contact.php" class="nav-item">contacts</a>
            <a href="login.php" class="nav-item" id="active">account</a>
            <a href="#" class="nav-item">log out</a>
        </div>
    </header>

    <!-- Admin Donations Content -->
    <div class="left-section">

        <div class="side-section">
            <div class="content">
                <div class="content-header">welcome, <br> admin</div>
                <div class="btn-section-top">
                    <a href="admin-dash.php" class="outline-btn">projects</a>
                    <a href="#" class="yellow-btn">donations</a>
                </div>
            </div>
        </div>

        <!-- Donation Proof List -->
        <div class="donation-list">
            <?php for ($i = 0; $i < 3; $i++): ?>
            <div class="donation-item">
                <div class="proof-img">
                    proof img
                </div>
                <div class="donation-info">
                    user donated proof
                </div>
                <div class="action-icons">
                    <button> <img src="/Paw-It-Forward_Frontend/assets/img/post-action-check.png"></button>   
                    <button> <img src="assets/img/post-action-x.png"></button> 
                </div>
            </div>
            <?php endfor; ?>
        </div>

    </div>

</body>
</html>
