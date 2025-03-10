<?php
    session_start();
    $pageTitle = "Verify Donation - Paw It Forward";
    include 'backend/paw_database.php';

    if (!isset($_SESSION['AdminID'])) {
        header("Location: admin-login.php");
        exit();
    }

    if (!isset($_GET['donationId']) || !is_numeric($_GET['donationId'])) {
        header("Location: admin-donation.php");
        exit();
    }

    $donationId = intval($_GET['donationId']);

    $query = "SELECT d.DonationID, d.DonationImageProof, u.UserID, u.FirstName, u.LastName, u.Email, 
                     p.PostID, dog.DogName 
              FROM donation d
              JOIN users u ON d.UserID = u.UserID
              JOIN post p ON d.PostID = p.PostID
              JOIN dog ON p.DogID = dog.DogID
              WHERE d.DonationID = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $donationId);
        $stmt->execute();
        $stmt->bind_result($donationId, $donationProof, $userId, $firstName, $lastName, $email, $postId, $dogName);
        
        if (!$stmt->fetch()) {
            header('Location: admin-donation.php');
            exit();
        }
        $stmt->close();
    } else {
        die("Error fetching donation: " . $conn->error);
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
    <header>
        <a href="index.php" class="site-title" id="title">paw it forward</a>
        <div class="nav">
            <a href="donate.php" class="nav-item-donate">donate</a>
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

    <div class="left-section">
        <div class="side-section">
            <div class="content">
                <div class="content-header">verify <?php echo htmlspecialchars($firstName); ?>'s<br> donation</div>
            </div>
        </div>

        <form action="backend/admin_certificate.php" method="POST" enctype="multipart/form-data" class="form-container-cert">
            <input type="hidden" name="donationId" value="<?php echo htmlspecialchars($donationId); ?>">
            <input type="hidden" name="userId" value="<?php echo htmlspecialchars($userId); ?>">
            <input type="hidden" name="postId" value="<?php echo htmlspecialchars($postId); ?>">
            
            <div class="file-input-container">
                <label class="file-box-cert">
                    <span id="uploadText">Upload Certificate</span>
                    <input type="file" name="certificateImage" accept="image/*" required>
                </label>
            </div>

            <div class="amount-container">
                <input type="text" name="firstName" placeholder="First name" value="<?php echo htmlspecialchars($firstName); ?>" required>
                <input type="text" name="lastName" placeholder="Last name" value="<?php echo htmlspecialchars($lastName); ?>" required>
            </div>
            
            <div class="email-amount-container">
                <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <div class="btn-actions" style="margin-top: 20px;">
                <button type="submit" class="yellow-btn">Verify</button>
                <a href="admin-donation.php" class="cancel-btn" style="margin-left: 10px;">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
