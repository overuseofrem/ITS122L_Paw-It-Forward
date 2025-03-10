<?php
    session_start();
    $pageTitle = "Create Post - Paw It Forward";
    include 'backend/paw_database.php'; // connect to database -- dee

    // Check if the admin is logged in
    if (!isset($_SESSION['AdminID'])) {
        header("Location: admin-login.php");
        exit();
    }

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
            <a href="<?php echo (isset($_SESSION['UserID']) || isset($_SESSION['AdminID'])) ? 'donate.php' : 'donate-sign.php'; ?>" class="nav-item-donate">donate</a>
            <a href="about.php" class="nav-item">our goal</a>
            <a href="contact.php" class="nav-item">contact</a>

            <?php if (isset($_SESSION['AdminID'])): ?>
                <a href="admin-dash.php" class="nav-item"  id="active">account</a>
                <a href="backend/admin_logout.php" class="nav-item">log out</a>

            <?php elseif (isset($_SESSION['UserID'])): ?>
                <a href="user-dash.php" class="nav-item">account</a>
                <a href="backend/user_logout.php" class="nav-item">log out</a>

            <?php else: ?>
                <a href="login.php" class="nav-item" id="active">account</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Admin Dash Content -->
    <form action="backend/admin_create.php" method="POST" enctype="multipart/form-data">
        <div class="left-section">
            <div class="side-section">
                <div class="content">
                    <div class="content-header">create a new<br> post</div>
                    <div class="btn-section-top">
                        <button type="submit" class="yellow-btn">post</button>
                        <a href="admin-dash.php">cancel</a>
                    </div>
                </div>
            </div>
            <div class="form-container">
                <div class="file-input-container">
                    <label class="file-box">
                        Select Dog Image
                        <input type="file" name="dogImage" accept="image/*" required
                            style="opacity: 0; position: absolute; z-index: -1;"
                            onchange="previewImage(this, 'dogImagePreview')">
                        <img id="dogImagePreview" class="image-preview" alt="">
                    </label>
                    <label class="file-box">
                        Select QR Image
                        <input type="file" name="qrImage" accept="image/*" required
                            style="opacity: 0; position: absolute; z-index: -1;"
                            onchange="previewImage(this, 'qrImagePreview')">
                        <img id="qrImagePreview" class="image-preview" alt="">
                    </label>
                </div>

                <input type="text" name="dogName" placeholder="Dog Name" required>

                <div class="amount-container">
                    <input type="number" name="amountRaised" placeholder="Amount Raised" required>
                    <input type="number" name="amountNeeded" placeholder="Amount Needed" required>
                </div>

                <textarea name="dogBioDescription" placeholder="Dog Bio Description" required></textarea>
            </div>
        </div>
    </form>

    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
