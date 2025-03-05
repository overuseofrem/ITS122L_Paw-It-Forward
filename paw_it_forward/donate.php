<?php
    $pageTitle = "Paw It Forward";
    include 'backend/paw_database.php'; // connect to database -- dee
?>

<?php
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    // Fetch post details from the database
    $query = "SELECT Post.PostID, Dog.DogName, Dog.DogImage, Post.AmountNeeded, Post.AmountRaised
                FROM Post
                INNER JOIN Dog ON Post.DogID = Dog.DogID
                WHERE Post.PostID = '$post_id'";
    $result = mysqli_query($conn, $query);
    $approved_post = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="assets/css/style-thin.css">
</head>

<body>

    <!-- Site name + Nav -->
    <header>
        <a href="index.php" class="site-title" id="title">paw it forward</a>
        <div class="nav">
            <a href="donate-sign.php" class="nav-item-donate" id="donate-sign">donate</a>
            <a href="about.php" class="nav-item">our goal</a>
            <a href="contact.php" class="nav-item">contact</a>
            <a href="login.php" class="nav-item">account</a>
        </div>
    </header>

    <!-- Left Section w/ Content -->
    <div class="left-section">
        <div class="content-wrapper">
            <div class="content" id="hero">
                <div class="content-header">thank you so much for choosing to support paw it forward!</div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                <a href="#donation-info" class="scroll-link">impact of your support</a>
            </div>
    
            <!-- Expanded Content Section Below -->
            <div class="content" id="donation-info">
                <div class="content-header">how your contribution makes a difference</div>
                <p>Every donation goes directly to funding critical care...</p>
                <a href="#projects" class="scroll-link">dogs in need</a>
            </div>

            <div class="content" id="projects">
                <div class="content-header"> our project</div>
            </div>

            <!-- Donation Sections -->
            <?php 
            $query = "SELECT Post.PostID, Dog.DogName, Dog.DogImage, Post.AmountNeeded, Post.AmountRaised, Dog.DogBioDescription, Dog.QR_Image
                      FROM Post
                      INNER JOIN Dog ON Post.DogID = Dog.DogID
                      LIMIT 3"; // Display only the first 3 records
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="donation-content">
                <div class="donation-head">
                    <div class="donation-title"><?php echo $row['DogName']; ?></div>
                    <div class="donation-raised">PHP <?php echo number_format($row['AmountRaised'], 2); ?>/PHP <?php echo number_format($row['AmountNeeded'], 2); ?> raised!</div>
                </div>
                <p><?php echo $row['DogBioDescription']; ?></p>
                <div class="donation-img">
                    <img src="<?php echo $row['DogImage']; ?>" alt="" class="dog-img">
                    <img src="<?php echo $row['QR_Image']; ?>" alt="" class="qr-code">
                </div>
            </div>
            <?php endwhile; ?>

            <div class="content" id="cert-submission">
                <div class="content-header">submit your donation proof below and receive a certificate!</div>
                <button class="yellow-btn" id="uploadButton">submit donation proof</button>
                <input type="file" id="fileInput" name="file" accept="image/*">
            </div>
        </div>
        <a href="#title" class="bottom-up">go back up</a>
    </div>

    <!-- Right Section w/ Img -->
    <div class="right-section">
        <img src="assets/img/dogs (side)/erda-estremera-JBrbzg5N7Go-unsplash.jpg" alt="">
    </div>

</body>
</html>