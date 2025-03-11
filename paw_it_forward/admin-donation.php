<?php
    session_start();
    $pageTitle = "Admin Donation - Paw It Forward";
    include 'backend/admin_donation.php'; // connect to backend -- dee

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
                <a href="admin-dash.php" class="nav-item" id="active">account</a>
                <a href="backend/admin_logout.php" class="nav-item">log out</a>
            <?php elseif (isset($_SESSION['UserID'])): ?>
                <a href="user-dash.php" class="nav-item" id="active">account</a>
                <a href="backend/user_logout.php" class="nav-item">log out</a>
            <?php else: ?>
                <a href="login.php" class="nav-item" id="active">account</a>
            <?php endif; ?>
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
            <?php foreach ($donations as $donation): ?>
            <div class="donation-item">
                <div class="proof-img">
                    <img src="<?php echo !empty($donation['DonationImageProof']) ? 
                        htmlspecialchars($donation['DonationImageProof']) : 
                        'assets/img/no-image.png'; ?>" 
                        alt="Proof Image"
                        class="preview-img"
                        data-image="<?php echo htmlspecialchars($donation['DonationImageProof']); ?>"
                        onerror="this.onerror=null;this.src='assets/img/no-image.png';">
                </div>
                <div class="donation-info">
                    <p class="donation-text">Donation Details:</p>
                    <br/>
                    <p class="donation-text">Donor: <?php echo htmlspecialchars($donation['UserNameFirst'] . ' ' . $donation['UserNameLast']); ?></p>
                    <p class="donation-text">Received by: <?php echo htmlspecialchars($donation['AdminNameFirst'] . ' ' . $donation['AdminNameLast']); ?></p>
                    <p class="donation-text">Donation Date: <?php echo htmlspecialchars($donation['DonationDate']); ?></p>
                    <p class="donation-text">Donated For: <?php echo htmlspecialchars($donation['DogName']); ?></p>
                </div>
                <div class="action-icons-donate">
                    <form action="backend/admin_donation.php" method="post">
                        <input type="hidden" name="donationId" value="<?php echo htmlspecialchars($donation['DonationId']); ?>">
                        <button class="approve-btn" name="approveDonation">
                            <img src="assets/img/post-action-check.png">
                        </button>
                    </form>
   
                    <form action="backend/admin_donation.php" method="post">
                        <input type="hidden" name="donationId" value="<?php echo htmlspecialchars($donation['DonationId']); ?>">
                        <button class="reject-btn" name="rejectDonation"> 
                            <img src="assets/img/post-action-x.png">
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div id="imageModal" class="modal">
        <div class="modal-content">
            <img id="modalImage" src="" alt="Proof Preview">
            <button class="close-btn" onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        // Open modal on image click
        document.querySelectorAll('.preview-img').forEach(img => {
            img.addEventListener('click', function() {
                let imageUrl = this.getAttribute('data-image');
                if (imageUrl) {
                    document.getElementById('modalImage').src = imageUrl;
                    document.getElementById('imageModal').style.display = 'block';
                }
            });
        });

        // Close modal function
        function closeModal() {
            document.getElementById('imageModal').style.display = 'none';
        }

        // Close modal when clicking outside of the image
        window.onclick = function(event) {
            let modal = document.getElementById('imageModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>

</body>
</html>
