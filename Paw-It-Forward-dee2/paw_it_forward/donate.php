<?php
    session_start(); // Start session to track user authentication
    $pageTitle = "Donate - Paw It Forward";
    include 'backend/paw_database.php'; // Connect to database

    // Check if user and admin is logged in, otherwise redirect to login page
    if (!isset($_SESSION['UserID']) && !isset($_SESSION['AdminID'])) {
        header("Location: login.php");
        exit();
    }

    $approved_post = null; // Initialize variable to store approved post details

    // Check if dog_id is passed in URL
    if (isset($_GET['dog_id'])) {
        $dog_id = $_GET['dog_id'];

        // Fetch PostID based on DogID
        $stmt = $conn->prepare("SELECT Post.PostID, Dog.DogName, Dog.DogImage, Post.AmountNeeded, Post.AmountRaised
                                FROM Post
                                INNER JOIN Dog ON Post.DogID = Dog.DogID
                                WHERE Dog.DogID = ? AND Post.PostStatus = 'approved'");
        $stmt->bind_param("i", $dog_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $approved_post = $result->fetch_assoc();
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="assets/css/style-thin.css"> <!-- Link to external CSS -->
</head>

<body>
    <!-- Header Section -->
    <header>
        <a href="index.php" class="site-title" id="title">paw it forward</a>
        <div class="nav">
            <a href="<?php echo (isset($_SESSION['UserID']) || isset($_SESSION['AdminID'])) ? 'donate.php' : 'donate-sign.php'; ?>" class="nav-item-donate">donate</a>
            <a href="about.php" class="nav-item">our goal</a>
            <a href="contact.php" class="nav-item">contact</a>

            <?php if (isset($_SESSION['AdminID'])): ?>
                <a href="admin-dash.php" class="nav-item">account</a>
                <a href="backend/admin_logout.php" class="nav-item">log out</a>

            <?php elseif (isset($_SESSION['UserID'])): ?>
                <a href="user-dash.php" class="nav-item">account</a>
                <a href="backend/user_logout.php" class="nav-item">log out</a>

            <?php else: ?>
                <a href="login.php" class="nav-item" id="active">account</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="left-section">
        <div class="content-wrapper">
            <!-- Welcome Message -->
            <div class="content" id="hero">
                <div class="content-header">Thank you so much for choosing to support Paw It Forward!</div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                <a href="#donation-info" class="scroll-link">impact of your support</a>
            </div>

            <!-- How Donations Help -->
            <div class="content" id="donation-info">
                <div class="content-header">How your contribution makes a difference</div>
                <p>Every donation goes directly to funding critical care...</p>
                <a href="#projects" class="scroll-link">dogs in need</a>
            </div>

            <!-- Fetch and Display Approved Posts -->
            <?php 
            $query = "SELECT Post.PostID, Dog.DogName, Dog.DogImage, Post.AmountNeeded, Post.AmountRaised, Dog.DogBioDescription, Dog.QR_Image
                      FROM Post
                      INNER JOIN Dog ON Post.DogID = Dog.DogID
                      WHERE Post.PostStatus = 'approved' 
                      LIMIT 3"; // Limit of posts in the frontend to avoid cluttering
            $result = $conn->query($query);
            
            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()): ?>
                    <div class="donation-content">
                        <div class="donation-head">
                            <div class="donation-title"><?php echo htmlspecialchars($row['DogName']); ?></div>
                            <div class="donation-raised">PHP <?php echo number_format($row['AmountRaised'], 2); ?>/PHP <?php echo number_format($row['AmountNeeded'], 2); ?> raised!</div>
                        </div>
                        <p><?php echo htmlspecialchars($row['DogBioDescription']); ?></p>
                        <div class="donation-img">
                            <img src="<?php echo htmlspecialchars($row['DogImage']); ?>" alt="Dog Image" class="dog-img">
                            <img src="<?php echo htmlspecialchars($row['QR_Image']); ?>" alt="QR Code" class="qr-code">
                        </div>
                    </div>
                <?php endwhile; 
            endif;
            ?>

            <!-- Donation Proof Submission Form -->
            <div class="content" id="cert-submission">
                <div class="content-header">Submit your donation proof below and receive a certificate!</div>
                <div class="submit-proof-form-container">
                    <form id="uploadForm" action="backend/donate_proof.php" method="post" enctype="multipart/form-data">
                        <!-- Dog Selection Dropdown (Only Approved, Max 3) -->
                        <div class="cert-form-group" style="margin-bottom: 25px">
                            <label for="dog-selection" class="cert-label">Select the dog for your donation:</label>
                            <select id="dog-selection" name="dog_id" class="cert-dropdown" style="background-color: #8888" required>
                                <option value="">-- Select a Dog --</option>
                                <?php
                                include 'backend/paw_database.php';
                                $query = "SELECT Dog.DogID, Dog.DogName FROM Post 
                                        INNER JOIN Dog ON Post.DogID = Dog.DogID 
                                        WHERE Post.PostStatus = 'approved' LIMIT 3";
                                $result = $conn->query($query);

                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['DogID'] . "' data-postid='" . $row['PostID'] . "'>" . htmlspecialchars($row['DogName']) . "</option>";
                                }
                                ?>
                            </select>
                            <input type="hidden" id="post_id" name="post_id"> <!-- Hidden field for post_id -->
                        </div>

                        <!-- File upload button -->
                        <div class="file-input-wrapper">
                            <label for="file-upload" class="yellow-btn">Choose File</label>
                            <input type="file" id="file-upload" name="donation_proof" accept="image/*" required>
                            <span id="file-name">No file chosen</span> <!-- Display selected file name -->
                        </div>

                        <!-- Submit Button -->
                        <div class="file-input-wrapper">
                            <button type="submit" class="yellow-btn submit-btn">Submit Donation Proof</button>
                        </div>
                    </form>
                    <div id="message"></div>
                </div>
            </div>
        </div>
        <a href="#title" class="bottom-up">Go Back Up</a>
    </div>

    <!-- JavaScript to Display Selected File Name and Successful Uploads -->
    <script>
        document.getElementById("file-upload").addEventListener("change", function() {
            var fileName = this.files.length > 0 ? this.files[0].name : "No file chosen";
            document.getElementById("file-name").textContent = fileName;
        });

        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("uploadForm");
            const messageContainer = document.getElementById("message");

            form.addEventListener("submit", function (event) {
                event.preventDefault();
                messageContainer.innerHTML = "";
                
                let formData = new FormData(form);
                fetch("backend/donate_proof.php", {
                    method: "POST",
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    messageContainer.innerHTML = `<p style="color:${data.status === "success" ? "green" : "red"}; font-weight:bold;">${data.message}</p>`;
                    if (data.status === "success") {
                        form.reset();
                        document.getElementById("file-name").textContent = "No file chosen";
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    messageContainer.innerHTML = `<p style="color:red; font-weight:bold;">An error occurred: ${error.message}</p>`;
                });
            });
        });
    </script>

    <!-- Right Section with Side Image -->
    <div class="right-section">
        <img src="assets/img/dogs (side)/erda-estremera-JBrbzg5N7Go-unsplash.jpg" alt="">
    </div>

</body>
</html>
