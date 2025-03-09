<?php
    $pageTitle = "Paw It Forward";
    include 'backend/paw_database.php'; // connect to database -- dee
    
    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Check if user is logged in
    if (!isset($_SESSION['UserID'])) {
        header("Location: login.php");
        exit;
    }
    
    $userId = $_SESSION['UserID'];
    $userName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'user';
    
    // Get user's certificates
    $certificates = [];
    $query = "SELECT c.CertificateID, c.CertificateImage, c.IssuedDate, d.DogName 
              FROM certificate c
              JOIN donation don ON c.DonationID = don.DonationID
              JOIN post p ON don.PostID = p.PostID
              JOIN dog d ON p.DogID = d.DogID
              WHERE c.UserID = ?
              ORDER BY c.IssuedDate DESC";
              
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $certificates[] = $row;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="assets/css/style-thin.css">
    <style>
        .content-certs {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        
        .cert {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            background-color: #fff;
            padding-bottom: 10px;
        }
        
        .cert:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        
        .cert img {
            width: 100%;
            height: 285px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }
        
        .cert-info {
            padding: 10px;
            text-align: center;
        }
        
        .cert-info h3 {
            color: #333;
            margin: 0 0 5px;
            font-size: 1.1rem;
        }
        
        .cert-info p {
            margin: 0;
            font-size: 0.9rem;
            color: #666;
        }
        
        .no-certificates {
            grid-column: 1 / -1;
            text-align: center;
            padding: 30px;
            background-color: #f8f8f8;
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <!-- Site name + Nav -->
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

    <!-- Left Section w/ Content -->
    <div class="left-section">

        <div class="content-wrapper">
    
            <div class="content">
                <div class="content-header">welcome, <?php echo htmlspecialchars($userName); ?>!</div>
                <div class="bolder-mini">check out your certificates. <br> thank you so much for supporting paw it forward!</div>
            </div>

            <div class="content-certs">
                <?php if (empty($certificates)): ?>
                    <div class="no-certificates">
                        <p>You don't have any certificates yet. Make a donation to help a dog in need!</p>
                        <a href="donate.php" class="yellow-btn" style="display: inline-block; margin-top: 15px; padding: 8px 20px;">Donate Now</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($certificates as $cert): ?>
                        <div class="cert">
                            <img src="<?php echo htmlspecialchars($cert['CertificateImage']); ?>" alt="Certificate">
                            <div class="cert-info">
                                <h3>Certificate for donating to <?php echo htmlspecialchars($cert['DogName']); ?></h3>
                                <p>Issued: <?php echo date('F j, Y', strtotime($cert['IssuedDate'])); ?></p>
                                <a href="<?php echo htmlspecialchars($cert['CertificateImage']); ?>" target="_blank" class="yellow-btn" style="display: inline-block; margin-top: 10px; padding: 5px 15px; font-size: 0.9rem;">View Full Certificate</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>

        <a href="#title" class="bottom-up">go back up</a>

    </div>

    <!-- Right Section w/ Img -->
    <div class="right-section">
        <img src="assets/img/dogs (side)/marek-szturc-CM1oVEUzsNM-unsplash.jpg" alt="">
    </div>

</body>
</html>