<?php
    $pageTitle = "Paw It Forward - Admin Dashboard";
    include 'backend/paw_database.php'; // Connect to the database -- dee

    // Fetch posts from the database
    $query = "SELECT Post.PostID, Dog.DogName, Dog.DogImage, Post.AmountNeeded, Post.AmountRaised, Post.PostStatus
            FROM Post
            INNER JOIN Dog ON Post.DogID = Dog.DogID";
    $result = mysqli_query($conn, $query);
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
            <a href="admin-login.php" class="nav-item">log out</a>
        </div>
    </header>

    <!-- Admin Dash Content -->
    <div class="left-section">

        <!-- Side Section with Navigation for Admin -->
        <div class="side-section">
            <div class="content">
                <div class="content-header">welcome, <br> admin</div>
                <div class="btn-section-top">
                    <a href="#p" class="yellow-btn">projects</a>
                    <a href="admin-donation.php" class="outline-btn">donations</a>
                    <br><br><br>
                    <a href="admin-create.php" class="yellow-btn">new post</a>
                </div>
            </div>
        </div>

        <!-- Grid Display of Posts -->
        <div class="proj-grid">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="proj-item">
                <div class="proj-title"><?php echo htmlspecialchars($row['DogName']); ?></div>
                <img class="proj-img" src="<?php echo htmlspecialchars($row['DogImage']); ?>" alt="Dog Image">
                <div class="proj-funds">
                    <?php echo number_format($row['AmountRaised'], 2); ?>/<?php echo number_format($row['AmountNeeded'], 2); ?>
                </div>

                <!-- Dynamic Post Status with Colors -->
                <div class="post-status" 
                    style="color: <?php echo ($row['PostStatus'] == 'Approved') ? '#32a885' : 'orange'; ?>; font-weight: bold;">
                    <?php echo htmlspecialchars($row['PostStatus']); ?>
                </div>

                <div class="action-icons">
                    <!-- Approve Form -->
                    <form action="backend/admin_dash.php" method="POST" class="inline-form">
                        <input type="hidden" name="post_id" value="<?php echo $row['PostID']; ?>">
                        <button type="submit" name="approve" class="approve-btn">
                            <img src="assets/img/post-action-check.png" alt="Check">
                        </button>
                    </form>

                    <!-- Edit Link -->
                    <a href="admin-edit.php?post_id=<?php echo $row['PostID']; ?>" class="inline-form">
                        <button type="button" class="approve-btn">
                            <img src="assets/img/post-action-edit.png" alt="Edit">
                        </button>
                    </a>

                    <!-- Reject Form (Delete Post) -->
                    <form action="backend/admin_dash.php" method="POST" class="inline-form">
                        <input type="hidden" name="post_id" value="<?php echo $row['PostID']; ?>">
                        <button type="submit" name="reject" class="reject-btn">
                            <img src="assets/img/post-action-x.png" alt="Delete">
                        </button>
                    </form>
                </div>

                <?php
                if (isset($_GET['message'])) {
                    echo "<script>alert('" . htmlspecialchars($_GET['message']) . "');</script>";
                }
                ?>

            </div>
            <?php endwhile; ?>
        </div>
    </div>

</body>
</html>
