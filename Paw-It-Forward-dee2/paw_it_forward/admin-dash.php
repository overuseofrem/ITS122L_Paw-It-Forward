<?php
session_start();
$pageTitle = "Admin Dashboard - Paw It Forward";
include 'backend/paw_database.php'; // Connect to the database

// Check if the admin is logged in
if (!isset($_SESSION['AdminID'])) {
    header("Location: admin-login.php");
    exit();
}

// Fetch posts from the database
$query = "SELECT Post.PostID, Dog.DogName, Dog.DogImage, Post.AmountNeeded, Post.AmountRaised, Post.PostStatus
        FROM Post
        INNER JOIN Dog ON Post.DogID = Dog.DogID";
$result = mysqli_query($conn, $query);

// Count the number of approved posts
$countQuery = "SELECT COUNT(*) AS approved_count FROM Post WHERE PostStatus = 'Approved'";
$countResult = mysqli_query($conn, $countQuery);
$row = mysqli_fetch_assoc($countResult);
$approvedCount = $row['approved_count']; // Store the approved count

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

    <!-- Admin Dash Content -->
    <div class="left-section">
        <div class="side-section">
            <div class="content">
                <div class="content-header">welcome, <br> admin</div>
                <div class="btn-section-top">
                    <a href="#p" class="yellow-btn">projects</a>
                    <a href="admin-donation.php" class="outline-btn">donations</a>
                    <br><br><br>
                    <a href="admin-create.php" class="yellow-btn">new post</a>
                </div>
                <br>
                <p style="color: red; font-weight: bold;">Approved Posts: <?php echo $approvedCount; ?> / 3</p>
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

                <div class="post-status" 
                    style="color: <?php echo ($row['PostStatus'] == 'Approved') ? '#32a885' : 'orange'; ?>; font-weight: bold;">
                    <?php echo htmlspecialchars($row['PostStatus']); ?>
                </div>

                <div class="action-icons">
                    <!-- Approve Form -->
                    <form action="backend/admin_dash.php" method="POST" class="inline-form" onsubmit="return checkApprovalLimit(<?php echo $approvedCount; ?>);">
                        <input type="hidden" name="post_id" value="<?php echo $row['PostID']; ?>">
                        <button type="submit" name="approve" class="approve-btn" <?php echo ($approvedCount >= 3) ? 'disabled' : ''; ?>>
                            <img src="assets/img/post-action-check.png" alt="Check">
                        </button>
                    </form>

                    <!-- Edit Link -->
                    <a href="admin-edit.php?post_id=<?php echo $row['PostID']; ?>" class="inline-form">
                        <button type="button" class="reject-btn">
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
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- JavaScript Alert for Approval Limit -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let approvedCount = <?php echo $approvedCount; ?>;
            let approveButtons = document.querySelectorAll(".approve-btn");

            approveButtons.forEach(button => {
                button.addEventListener("click", function (event) {
                    if (approvedCount >= 3) {
                        event.preventDefault(); // Stop form submission
                        alert("⚠️ You cannot approve more than 3 posts. Please unapprove an existing post first.");
                    }
                });

                // Only disable the "Approve" button, not "Edit" or "Delete"
                if (approvedCount >= 3) {
                    button.disabled = true;
                }
            });
        });
    </script>

</body>
</html>
