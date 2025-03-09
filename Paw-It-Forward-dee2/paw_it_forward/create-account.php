<?php
    session_start(); // session started
    $pageTitle = "Create Account - Paw It Forward";
    include 'backend/paw_database.php'; // Connect to database
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
                <a href="admin-dash.php" class="nav-item">dashboard</a>
                <a href="backend/admin_logout.php" class="nav-item">log out</a>

            <?php elseif (isset($_SESSION['UserID'])): ?>
                <a href="user-dash.php" class="nav-item">dashboard</a>
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
                <div class="content-header">create an account</div>

                <!-- Registration Form -->
                <form action="backend/user_register.php" method="post">
                    <div id="name-fields">
                        <input type="text" name="firstname" placeholder="First Name" required>
                        <input type="text" name="lastname" placeholder="Last Name" required>
                    </div>
                    <div>
                        <input type="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    </div>

                    <div class="btn-section-side">
                        <button type="submit" class="yellow-btn">create account</button>
                    </div>
                </form>

                <!-- Error/Success Messages -->
                <?php
                if (isset($_GET['error'])) {
                    echo "<p style='color:red;'>" . htmlspecialchars($_GET['error']) . "</p>";
                }
                if (isset($_GET['success'])) {
                    echo "<p style='color:green;'>" . htmlspecialchars($_GET['success']) . "</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Right Section w/ Img -->
    <div class="right-section">
        <img src="assets/img/dogs (side)/camylla-battani-_AOHaUgSNrg-unsplash.jpg" alt="">
    </div>

</body>
</html>
