<?php
    $pageTitle = "Paw It Forward - Admin Dashboard";
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
            <a href="contact.php" class="nav-item">contact</a>
            <a href="login.php" class="nav-item" id="active"> account</a>
            <a href="#" class="nav-item">log out</a>
        </div>
    </header>

    <!-- Admin Dash Content -->
    <div class="left-section">

        <div class="side-section">
            <div class="content">
                <div class="content-header">welcome, <br> admin</div>
                <div class="btn-section-top">
                    <a href="#p" class="yellow-btn">projects</a>
                    <a href="#" class="outline-btn">donations</a>
                    <br><br><br>
                    <a href="admin-create.php" class="yellow-btn">new post</a>
                </div>
            </div>
        </div>
        <div class="proj-grid">
            <?php for ($i = 0; $i < 7; $i++): ?>
            <div class="proj-item">
                <div class="proj-title">dog</div>
                <img class="proj-img" src="/Paw-It-Forward_Frontend/assets/img/dogs (side)/cristofer-maximilian-3HjLaBmY2a4-unsplash.jpg" alt="">
                <div class="proj-funds">10,000/20,000</div>
                <div class="action-icons">
                    <button> <img src="/Paw-It-Forward_Frontend/assets/img/post-action-check.png"></button>                    
                    <button> <img src="/Paw-It-Forward_Frontend/assets/img/post-action-edit.png"></button>        
                    <button> <img src="assets/img/post-action-x.png"></button> 
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</body>
</html>
