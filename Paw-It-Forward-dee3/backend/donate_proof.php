<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');


// Include database connection
include 'paw_database.php';

// Ensure user is logged in
if (!isset($_SESSION['UserID'])) {
    session_unset();
    session_destroy();
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit();
}

// Ensure request is POST and file is uploaded
if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_FILES["donation_proof"])) {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
    exit();
}

// Get user ID from session
$userID = $_SESSION['UserID'];

// Validate and sanitize `dog_id`
$dogID = filter_var($_POST['dog_id'] ?? null, FILTER_VALIDATE_INT);
if (!$dogID) {
    echo json_encode(["status" => "error", "message" => "Invalid dog ID."]);
    exit();
}

// Validate and sanitize `post_id` (Fetch if missing)
$postID = filter_var($_POST['post_id'] ?? null, FILTER_VALIDATE_INT);

if (!$postID) {
    $stmt = $conn->prepare("SELECT PostID FROM Post WHERE DogID = ? AND PostStatus = 'approved' LIMIT 1");
    $stmt->bind_param("i", $dogID);
    $stmt->execute();
    $stmt->bind_result($retrievedPostID);
    $stmt->fetch();
    $stmt->close();

    if ($retrievedPostID) {
        $postID = $retrievedPostID;
    } else {
        echo json_encode(["status" => "error", "message" => "No approved post found for this dog."]);
        exit();
    }
}

// Check if `post_id` belongs to the given `dog_id`
$stmt = $conn->prepare("SELECT COUNT(*) FROM Post WHERE PostID = ? AND DogID = ? AND PostStatus = 'approved'");
$stmt->bind_param("ii", $postID, $dogID);
$stmt->execute();
$stmt->bind_result($postExists);
$stmt->fetch();
$stmt->close();

if ($postExists == 0) {
    echo json_encode(["status" => "error", "message" => "Post does not match this dog."]);
    exit();
}

// Fetch the user's FirstName instead of username
$stmt = $conn->prepare("SELECT FirstName FROM users WHERE UserID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->bind_result($firstName);
$stmt->fetch();
$stmt->close();

if (!$firstName) {
    echo json_encode(["status" => "error", "message" => "User not found."]);
    exit();
}

// Sanitize FirstName for filenames
$firstName = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($firstName));

// Define upload directory
$targetDir = __DIR__ . "/../database/uploads/donation_proof/";

// Ensure the directory exists and is writable
if (!is_dir($targetDir) && !mkdir($targetDir, 0777, true) && !is_writable($targetDir)) {
    echo json_encode(["status" => "error", "message" => "Failed to create or write to upload directory."]);
    exit();
}

// Check file upload errors
$fileError = $_FILES["donation_proof"]["error"];
if ($fileError !== UPLOAD_ERR_OK) {
    $errorMessages = [
        UPLOAD_ERR_INI_SIZE => "File exceeds upload_max_filesize.",
        UPLOAD_ERR_FORM_SIZE => "File exceeds MAX_FILE_SIZE.",
        UPLOAD_ERR_PARTIAL => "File was only partially uploaded.",
        UPLOAD_ERR_NO_FILE => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR => "Missing temporary folder.",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION => "A PHP extension stopped the upload."
    ];
    echo json_encode(["status" => "error", "message" => $errorMessages[$fileError] ?? "Unknown error."]);
    exit();
}

// Validate file type
$fileType = strtolower(pathinfo($_FILES["donation_proof"]["name"], PATHINFO_EXTENSION));
$validTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF];
$imageType = exif_imagetype($_FILES["donation_proof"]["tmp_name"]);

if (!in_array($imageType, $validTypes)) {
    echo json_encode(["status" => "error", "message" => "Invalid file type. Allowed: JPG, JPEG, PNG, GIF."]);
    exit();
}

// Check file size (Max: 5MB)
$maxSize = 5 * 1024 * 1024;
if ($_FILES["donation_proof"]["size"] > $maxSize) {
    echo json_encode(["status" => "error", "message" => "File too large. Max size: 5MB."]);
    exit();
}

// Generate unique filename
$newFileName = uniqid("donation-{$firstName}-") . "." . $fileType;
$targetFilePath = $targetDir . $newFileName;

// Move uploaded file
if (move_uploaded_file($_FILES["donation_proof"]["tmp_name"], $targetFilePath)) {
    $relativePath = "database/uploads/donation_proof/" . $newFileName;
    
    // Set default verification status
    $verificationStatus = "Pending"; 

    // Set default AdminID
    $adminID = 1;

    // Insert into the `donation` table (fixed columns)
    $stmt = $conn->prepare("INSERT INTO donation (UserID, AdminID, PostID, DonationImageProof, VerificationStatus, DonationDate) 
                            VALUES (?, ?, ?, ?, ?, NOW())");

    $stmt->bind_param("iiiss", $userID, $adminID, $postID, $relativePath, $verificationStatus);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "File uploaded successfully!", "file" => $relativePath]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error]);
    }
    $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "File upload failed."]);
    }

// ✅ Close connection
$conn->close();
?>

