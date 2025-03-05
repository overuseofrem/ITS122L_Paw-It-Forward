<?php
include(__DIR__ . "/paw_database.php"); // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input
    $dogID = isset($_POST['dogID']) ? intval($_POST['dogID']) : null;
    $postID = isset($_POST['postID']) ? intval($_POST['postID']) : null;
    $dogName = isset($_POST['dogName']) ? trim($_POST['dogName']) : '';
    $dogBioDescription = isset($_POST['dogBioDescription']) ? trim($_POST['dogBioDescription']) : '';
    $amountRaised = isset($_POST['amountRaised']) ? floatval($_POST['amountRaised']) : 0;
    $amountNeeded = isset($_POST['amountNeeded']) ? floatval($_POST['amountNeeded']) : 0;
    $existingDogImage = isset($_POST['existingDogImage']) ? $_POST['existingDogImage'] : '';
    $existingQrImage = isset($_POST['existingQrImage']) ? $_POST['existingQrImage'] : '';

    // Define upload settings
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $maxFileSize = 2 * 1024 * 1024; // 2MB
    $uploadDir = __DIR__ . '/../uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Handle Dog Image Upload
    $dogImage = $existingDogImage;
    if (!empty($_FILES['dogImage']['name'])) {
        $dogFile = $_FILES['dogImage'];
        $dogExt = strtolower(pathinfo($dogFile['name'], PATHINFO_EXTENSION));

        if (in_array($dogExt, $allowedTypes) && $dogFile['size'] <= $maxFileSize) {
            $newDogImage = $uploadDir . 'dog_' . time() . '.' . $dogExt;
            if (move_uploaded_file($dogFile['tmp_name'], $newDogImage)) {
                if (!empty($existingDogImage) && file_exists($existingDogImage)) {
                    unlink($existingDogImage);
                }
                $dogImage = basename($newDogImage);
            }
        }
    }

    // Handle QR Image Upload
    $qrImage = $existingQrImage;
    if (!empty($_FILES['qrImage']['name'])) {
        $qrFile = $_FILES['qrImage'];
        $qrExt = strtolower(pathinfo($qrFile['name'], PATHINFO_EXTENSION));

        if (in_array($qrExt, $allowedTypes) && $qrFile['size'] <= $maxFileSize) {
            $newQrImage = $uploadDir . 'qr_' . time() . '.' . $qrExt;
            if (move_uploaded_file($qrFile['tmp_name'], $newQrImage)) {
                if (!empty($existingQrImage) && file_exists($existingQrImage)) {
                    unlink($existingQrImage);
                }
                $qrImage = basename($newQrImage);
            }
        }
    }

    // Ensure valid IDs
    if ($postID === null || $dogID === null) {
        die("Error: Missing PostID or DogID.");
    }

    // Ensure database connection exists
    if (!$conn) {
        die("Database connection error: " . mysqli_connect_error());
    }

    // Update Post details
    $query = "UPDATE Post SET AmountRaised = ?, AmountNeeded = ?, PostStatus = 'Pending' WHERE PostID = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('ddi', $amountRaised, $amountNeeded, $postID);
        $stmt->execute();
        $stmt->close();
    } else {
        die("Error updating Post: " . $conn->error);
    }

    // Debugging: Check if the Dog table update will work
    if ($dogName === '' || $dogBioDescription === '') {
        die("Error: Dog name or bio description is empty.");
    }

    // Update Dog details - even if only one field is changed
    $query = "UPDATE Dog SET DogName = ?, DogBioDescription = ?, DogImage = ?, QR_Image = ? WHERE DogID = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('ssssi', $dogName, $dogBioDescription, $dogImage, $qrImage, $dogID);
        $stmt->execute();

        // Allow updates even if MySQL detects no row changes
        if ($stmt->affected_rows === 0) {
            echo "<script>alert('No changes detected, but the update was processed.');</script>";
        } else {
            echo "<script>alert('Dog details updated successfully.');</script>";
        }

        $stmt->close();
    } else {
        die("Error updating Dog: " . $conn->error);
    }

    // Redirect back to the admin dashboard
    header("Location: ../admin-dash.php");
    exit;
}
?>
