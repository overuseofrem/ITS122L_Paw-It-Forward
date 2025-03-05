<?php
    $pageTitle = "Paw It Forward - Admin Donations";
    include 'backend/paw_database.php'; // connect to database -- dee

    if (isset($_POST['rejectDonation'])) {
        $donationId = $_POST['donationId'];
        $updateQuery = "UPDATE Donation SET VerificationStatus = 'Rejected' WHERE DonationId = '$donationId'";
        mysqli_query($conn, $updateQuery);
        header('Location: admin-donation.php');
        exit;
    }

    // Retrieve donation data from database
    $donationQuery = "
        SELECT Donation.DonationId, Donation.DonationImageProof, Donation.DonationDate, Donation.VerificationStatus,
               Users.FirstName AS UserNameFirst, Users.LastName AS UserNameLast,
               Admin.FirstName AS AdminNameFirst, Admin.LastName AS AdminNameLast,
               Dog.DogName
        FROM Donation 
        JOIN Users ON Donation.UserId = Users.UserId
        JOIN Admin ON Donation.AdminId = Admin.AdminId
        JOIN Post ON Donation.PostId = Post.PostId
        JOIN Dog ON Post.DogId = Dog.DogId
        WHERE Donation.VerificationStatus != 'Rejected' AND Donation.VerificationStatus != 'Approved'
    ";
    $donationResult = mysqli_query($conn, $donationQuery);

    // Check if query was successful
    if ($donationResult) {
        // Fetch all donation data
        $donations = mysqli_fetch_all($donationResult, MYSQLI_ASSOC);
    } else {
        // Handle query was not successful
        echo "Error: " . mysqli_error($conn);
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
            <a href="donate-sign.php" class="nav-item-donate">donate</a>
            <a href="about.php" class="nav-item">our goal</a>
            <a href="contact.php" class="nav-item">contact</a>
            <a href="login.php" class="nav-item" id="active">account</a>
            <a href="#" class="nav-item">log down</a>
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
                    <img src="<?php echo $donation['DonationImageProof']; ?>" alt="Proof Image">
                </div>
                <div class="donation-info">
                    <p class="donation-text">Donation Details:</p>
                    <br/>
                    <p class="donation-text">Donor: <?php echo $donation['UserNameFirst'] . ' ' . $donation['UserNameLast']; ?></p>
                    <p class="donation-text">Received by: <?php echo $donation['AdminNameFirst'] . ' ' . $donation['AdminNameLast']; ?></p>
                    <p class="donation-text">Donation Date: <?php echo $donation['DonationDate']; ?></p>
                    <p class="donation-text">Donated For: <?php echo $donation['DogName']; ?></p>
                </div>
                <div class="action-icons-donate">
                    <a href="admin-certificate.php?donationId=<?php echo $donation['DonationId']; ?>">
                        <button class="approve-btn"> 
                            <img src="assets/img/post-action-check.png">
                        </button>
                    </a>   
                    <form action="" method="post">
                        <input type="hidden" name="donationId" value="<?php echo $donation['DonationId']; ?>">
                        <button class="reject-btn" name="rejectDonation"> 
                            <img src="assets/img/post-action-x.png">
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>

</body>
</html>