<?php
    $pageTitle = "Paw It Forward - Verify Donation";
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

    <!-- Admin Certificate Verification -->
    <div class="left-section">

        <div class="side-section">
            <div class="content">
                <div class="content-header">verify @user’s<br> donation</div>
                <div class="btn-section-top">
                    <a href="#verify" class="yellow-btn">verify</a>
                    <a href="admin-donation.php" class="bottom-up">cancel</a>
                </div>
            </div>
        </div>

        <div class="form-container-cert">
            <div class="file-input-container">
                <label class="file-box-cert">
                    certificate upload
                    <input type="file" accept="image/*,application/pdf" hidden>
                </label>
            </div>

            <div class="amount-container">
                <input type="text" placeholder="user first name">
                <input type="text" placeholder="user last name">
            </div>

            <input type="text" placeholder="user email">
        </div>

    </div>

</body>
</html>
