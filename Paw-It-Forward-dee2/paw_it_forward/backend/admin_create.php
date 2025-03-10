<?php
include(__DIR__ . "/paw_database.php"); // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input
    session_start();
    $dogName = isset($_POST['dogName']) ? trim($_POST['dogName']) : '';
    $adminID = $_SESSION['AdminID'];
    $dogBioDescription = isset($_POST['dogBioDescription']) ? trim($_POST['dogBioDescription']) : '';
    $amountRaised = isset($_POST['amountRaised']) ? floatval($_POST['amountRaised']) : 0;
    $amountNeeded = isset($_POST['amountNeeded']) ? floatval($_POST['amountNeeded']) : 0;

    // Validation
    if (empty($dogName) || empty($dogBioDescription) || $amountNeeded <= 0) {
        die("Error: Please fill out all required fields.");
    }

    // Ensure database connection exists
    if (!$conn) {
        die("Database connection error: " . mysqli_connect_error());
    }

    // log to the console
    error_log("Admin ID: " . $adminID);

    // Validate that AdminID exists in the admin table
    $adminQuery = "SELECT AdminID FROM admin WHERE AdminID = ?";
    $adminStmt = $conn->prepare($adminQuery);
    if (!$adminStmt) {
        die("Error preparing admin query: " . $conn->error);
    }
    
    $adminStmt->bind_param('i', $adminID);
    $adminStmt->execute();
    $adminResult = $adminStmt->get_result();
    
    if ($adminResult->num_rows == 0) {
        die("Error: Invalid Admin ID provided.");
    }
    $adminStmt->close();

    // Define upload directories
    $dogsDir = __DIR__ . "/../database/dogs/";
    $qrDir = __DIR__ . "/../database/static-qr_codes/";
    
    // Ensure directories exist
    if (!is_dir($dogsDir)) {
        mkdir($dogsDir, 0777, true);
    }
    if (!is_dir($qrDir)) {
        mkdir($qrDir, 0777, true);
    }
    
    // Define allowed file types and max size
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $maxFileSize = 2 * 1024 * 1024; // 2MB

    // Handle Dog Image Upload
    $dogImage = '';
    if (!empty($_FILES['dogImage']['name'])) {
        $dogFile = $_FILES['dogImage'];
        $dogExt = strtolower(pathinfo($dogFile['name'], PATHINFO_EXTENSION));

        if (in_array($dogExt, $allowedTypes) && $dogFile['size'] <= $maxFileSize) {
            $dogFilename = "dog" . (time() % 10000) . "-" . preg_replace('/[^a-z0-9]/', '', strtolower($dogName)) . "." . $dogExt;
            $dogPath = $dogsDir . $dogFilename;
            
            if (move_uploaded_file($dogFile['tmp_name'], $dogPath)) {
                $dogImage = 'database/dogs/' . $dogFilename;
            } else {
                die("Error: Failed to upload dog image.");
            }
        } else {
            die("Error: Dog image must be JPG, JPEG, PNG, or GIF under 2MB.");
        }
    } else {
        die("Error: Dog image is required.");
    }

    // Handle QR Image Upload
    $qrImage = '';
    if (!empty($_FILES['qrImage']['name'])) {
        $qrFile = $_FILES['qrImage'];
        $qrExt = strtolower(pathinfo($qrFile['name'], PATHINFO_EXTENSION));

        if (in_array($qrExt, $allowedTypes) && $qrFile['size'] <= $maxFileSize) {
            $qrFilename = "qr". (time() % 10000) . "-" . preg_replace('/[^a-z0-9]/', '', strtolower($dogName)) . "." . $qrExt;
            $qrPath = $qrDir . $qrFilename;
            
            if (move_uploaded_file($qrFile['tmp_name'], $qrPath)) {
                $qrImage = 'database/static-qr_codes/' . $qrFilename;
            } else {
                die("Error: Failed to upload QR image.");
            }
        } else {
            die("Error: QR image must be JPG, JPEG, PNG, or GIF under 2MB.");
        }
    } else {
        die("Error: QR image is required.");
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert new dog record
        $queryDog = "INSERT INTO dog (DogName, DogBioDescription, DogImage, QR_Image) VALUES (?, ?, ?, ?)";
        $stmtDog = $conn->prepare($queryDog);
        if (!$stmtDog) {
            throw new Exception("Error preparing dog query: " . $conn->error);
        }

        $stmtDog->bind_param('ssss', $dogName, $dogBioDescription, $dogImage, $qrImage);
        $stmtDog->execute();
        $dogID = $conn->insert_id; // Get the newly created dog ID
        $stmtDog->close();

        if (!$dogID) {
            throw new Exception("Error inserting dog record.");
        }

        // Insert new post record
        $queryPost = "INSERT INTO post (DogID, AdminID, AmountRaised, AmountNeeded, PostStatus) VALUES (?, ?, ?, ?, 'Pending')";
        $stmtPost = $conn->prepare($queryPost);
        if (!$stmtPost) {
            throw new Exception("Error preparing post query: " . $conn->error);
        }

        $stmtPost->bind_param('iidd', $dogID, $adminID, $amountRaised, $amountNeeded);
        $stmtPost->execute();
        $stmtPost->close();

        // If everything is successful, commit the transaction
        $conn->commit();

        // Redirect back to the admin dashboard
        header("Location: ../admin-dash.php");
        exit;
    } catch (Exception $e) {
        // If there was an error, roll back the transaction
        $conn->rollback();

        // Clean up any uploaded files
        if (!empty($dogImage) && file_exists(__DIR__ . '/../' . $dogImage)) {
            unlink(__DIR__ . '/../' . $dogImage);
        }
        
        if (!empty($qrImage) && file_exists(__DIR__ . '/../' . $qrImage)) {
            unlink(__DIR__ . '/../' . $qrImage);
        }

        die("Database error: " . $e->getMessage());
    }
}
?>