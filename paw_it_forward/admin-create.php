<?php
    $pageTitle = "Paw It Forward - Create Post";
    include 'backend/paw_database.php'; // connect to database -- dee
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
            <a href="login.php" class="nav-item" id="active">account</a>
            <a href="#" class="nav-item">log out</a>
        </div>
    </header>

    <!-- Admin Dash Content -->
    <div class="left-section">

        <div class="side-section">
            <div class="content">
                <div class="content-header">create a new<br> post</div>
                <div class="btn-section-top">
                    <a href="#p" class="yellow-btn">post</a>
                    <a href="admin-dash.php">cancel</a>
                </div>
            </div>
        </div>
        <div class="form-container">
    
            <div class="file-input-container">
                <label class="file-box">
                    Select Dog Image
                    <input type="file" accept="image/*" hidden>
                </label>
                <label class="file-box">
                    Select QR Image
                    <input type="file" accept="image/*" hidden>
                </label>
            </div>
    
            <input type="text" placeholder="Dog Name">
    
            <div class="amount-container">
                <input type="number" placeholder="Amount Raised">
                <input type="number" placeholder="Amount Needed">
            </div>

            <textarea placeholder="Dog Bio Description"></textarea>
        </div>

</body>
</html>
