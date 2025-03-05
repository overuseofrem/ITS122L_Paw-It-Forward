<?php
    $pageTitle = "Paw It Forward - Admin Edit";
    // Include the database connection
    include 'backend/paw_database.php'; // Assuming your database connection is in this file

    // Check if the post_id is set
    if (isset($_GET['post_id'])) {
        $postID = $_GET['post_id'];
    } else {
        // Redirect if post_id is not found
        header("Location: admin-dash.php");
        exit;
    }

    // Prepare the SQL query to fetch the post details
    $query = "SELECT Dog.DogName, Dog.DogBioDescription, Dog.QR_Image, Dog.DogImage, 
                    Post.AmountRaised, Post.AmountNeeded
            FROM Post
            INNER JOIN Dog ON Post.DogID = Dog.DogID
            WHERE Post.PostID = ?";

    // Make sure to use the correct variable here ($conn, not $mysqli)
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $postID);
        $stmt->execute();
        $stmt->bind_result($dogName, $dogBioDescription, $qrImage, $dogImage, $amountRaised, $amountNeeded);
    
        if (!$stmt->fetch()) {
            echo "Error: No data found for post ID " . htmlspecialchars($postID);
        }
        $stmt->close();
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
            <a href="admin-login.php" class="nav-item">log out</a>
        </div>
    </header>

    <!-- Form for Editing the Dog's Post -->
    <form action="backend/admin_edit.php" method="POST" enctype="multipart/form-data">
        <!-- Hidden fields to pass DogID and PostID -->
        <input type="hidden" name="dogID" value="<?php echo htmlspecialchars($dogID); ?>">
        <input type="hidden" name="postID" value="<?php echo htmlspecialchars($postID); ?>">
        <input type="hidden" name="existingDogImage" value="<?php echo htmlspecialchars($dogImage); ?>">
        <input type="hidden" name="existingQrImage" value="<?php echo htmlspecialchars($qrImage); ?>">

        <div class="left-section">
            <div class="side-section">
                <div class="content">
                    <!-- Page Header -->
                    <div class="content-header">
                        Edit <?php echo htmlspecialchars($dogName); ?>'s<br>post
                    </div>

                    <!-- Buttons for Editing or Cancelling -->
                    <div class="btn-section-top">
                        <button type="submit" class="yellow-btn">edit</button>
                        <a href="admin-dash.php">cancel</a>
                    </div>
                </div>
            </div>

            <div class="form-container">
                <!-- Section for File Uploads -->
                <div class="file-input-container">
                    <!-- Dog Image Upload -->
                    <label class="file-box">
                        <input type="file" name="dogImage" accept="image/*">
                        <!-- Display Current Image -->
                        <img src="<?php echo !empty($dogImage) ? htmlspecialchars($dogImage) : 'database/dogs/default-dog.jpg'; ?>" alt="Dog Image">
                    </label>

                    <!-- QR Code Image Upload -->
                    <label class="file-box">
                        <input type="file" name="qrImage" accept="image/*">
                        <!-- Display Current QR Image -->
                        <img src="<?php echo !empty($qrImage) ? htmlspecialchars($qrImage) : 'database/static-qr_codes/default-qr.png'; ?>" alt="QR Code">
                    </label>
                </div>

                <!-- Dog Name Input Field -->
                <input type="text" name="dogName" placeholder="Dog Name" value="<?php echo htmlspecialchars($dogName); ?>">

                <!-- Amount Raised & Needed Input Fields -->
                <div class="amount-container">
                    <input type="number" name="amountRaised" placeholder="Amount Raised" value="<?php echo htmlspecialchars($amountRaised); ?>">
                    <input type="number" name="amountNeeded" placeholder="Amount Needed" value="<?php echo htmlspecialchars($amountNeeded); ?>">
                </div>

                <!-- Dog Bio Description Textarea -->
                <textarea name="dogBioDescription" placeholder="Dog Bio Description"><?php echo htmlspecialchars($dogBioDescription); ?></textarea>
            
            </div>
        </div>
    </form>

</body>
</html>
