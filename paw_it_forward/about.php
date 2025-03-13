<?php
    session_start();
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
            <a href="<?php echo (isset($_SESSION['UserID']) || isset($_SESSION['AdminID'])) ? 'donate.php' : 'donate-sign.php'; ?>" class="nav-item-donate">donate</a>
            <a href="about.php" class="nav-item" id="active">our goal</a>
            <a href="contact.php" class="nav-item">contact</a>

            <?php if (isset($_SESSION['AdminID'])): ?>
                <a href="admin-dash.php" class="nav-item">account</a>
                <a href="backend/admin_logout.php" class="nav-item">log out</a>

            <?php elseif (isset($_SESSION['UserID'])): ?>
                <a href="user-dash.php" class="nav-item">account</a>
                <a href="backend/user_logout.php" class="nav-item">log out</a>

            <?php else: ?>
                <a href="login.php" class="nav-item">account</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Left Section w/ Content -->
    <div class="left-section">
        <div class="content-wrapper">
            <!-- Expanded Content Section Below -->
            <div class="content" id="what-we-have-done">
                <div class="content-header">Vision</div>
                <p>A compassionate and sustainable community where every stray dog and cat finds a loving home and the care they deserve.</p>

                <p>Rescue & Rehabilitation – Provide aid and resources to shelters for the rescue, medical care, and rehabilitation of stray animals.</p>

                <p>Adoption & Foster Support – Promote responsible pet adoption and foster programs to give strays a second chance at a loving home.</p>

                <p>Welfare & Advocacy – Raise awareness about responsible pet ownership, animal rights, and humane treatment of stray animals.</p>

                <p>Sustainable Shelter Support – Partner with shelters to provide funding, food, and medical supplies to improve shelter conditions.</p>

                <p>Community Engagement – Educate and involve the public through outreach programs, volunteer opportunities, and fundraising initiatives.</p>
            </div>
            <div class="content">
                <div class="content-header">Goal</div>
                <p>Increase the number of rescued strays that receive proper medical care and rehabilitation.</p>

                <p>Promote and facilitate successful adoptions through community-driven efforts.</p>

                <p>Strengthen partnerships with shelters, veterinarians, and advocacy groups to expand resources.</p>

                <p>Implement educational campaigns to reduce stray populations through responsible pet ownership and spay/neuter programs.</p>

                <p>Foster a culture of compassion where individuals and businesses actively support animal welfare initiatives.</p>

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
