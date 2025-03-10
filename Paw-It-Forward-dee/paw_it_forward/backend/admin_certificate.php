<?php
include(__DIR__ . "/paw_database.php"); // Database connection

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debugging: Print received POST data
echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input
    $donationId = isset($_POST['donationId']) ? intval($_POST['donationId']) : 0;
    $userId = isset($_POST['userId']) ? intval($_POST['userId']) : 0;
    $postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;
    $firstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
    $lastName = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    // Validation
    if ($donationId <= 0 || $userId <= 0 || empty($firstName) || empty($lastName) || empty($email)) {
        die("Error: Missing required information.");
    }

    // Define upload settings
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB
    $uploadDir = __DIR__ . '/../database/uploads/certificates/';

    // Ensure the upload directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Ensure the directory is writable by the server
    if (!is_writable($uploadDir)) {
        // Set the folder permissions to 777 (writable by everyone) or adjust as needed
        chmod($uploadDir, 0777); 
    }

    // Ensure the upload directory is writable
    if (!is_writable($uploadDir)) {
        die("Error: Upload directory is not writable.");
    }

    // Handle Certificate Image Upload
    $certificateImage = '';
    if (!empty($_FILES['certificateImage']['name'])) {
        $certFile = $_FILES['certificateImage'];
        $certExt = strtolower(pathinfo($certFile['name'], PATHINFO_EXTENSION));

        if (in_array($certExt, $allowedTypes) && $certFile['size'] <= $maxFileSize) {
            // Sanitize first name for filename use (remove special characters, convert to lowercase)
            $sanitizedFirstName = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($firstName));

            // Create new filename with the first name included
            $certificateFilename = 'certificate-' . $sanitizedFirstName . '-' . time() . '.' . $certExt;
            $newCertPath = $uploadDir . $certificateFilename;
            
            if (move_uploaded_file($certFile['tmp_name'], $newCertPath)) {
                $certificateImage = 'database/uploads/certificates/' . $certificateFilename; // Corrected Path
            } else {
                die("Error: Failed to upload certificate image.");
            }
        } else {
            die("Error: Certificate image must be JPG, JPEG, PNG, or GIF under 5MB.");
        }
    } else {
        die("Error: Certificate image is required.");
    }

    // Ensure database connection exists
    if (!$conn) {
        die("Database connection error: " . mysqli_connect_error());
    }

    // Get admin ID - assuming admin is logged in and ID is stored in session
    // For now, we'll default to admin ID 1
    $adminId = 1; // Replace with actual admin session ID when available

    // Start transaction
    $conn->begin_transaction();

    try {
        // Check if the donation is already verified
        $queryCheckStatus = "SELECT VerificationStatus FROM donation WHERE DonationID = ?";
        $stmtCheckStatus = $conn->prepare($queryCheckStatus);
        if (!$stmtCheckStatus) {
            throw new Exception("Error preparing donation status check query: " . $conn->error);
        }

        $stmtCheckStatus->bind_param('i', $donationId);
        $stmtCheckStatus->execute();
        $stmtCheckStatus->store_result();
        $stmtCheckStatus->bind_result($verificationStatus);
        $stmtCheckStatus->fetch();
        $stmtCheckStatus->close();

        // If the donation is not verified (NULL or empty), update it
        if (empty($verificationStatus)) {
            $queryDonation = "UPDATE donation SET VerificationStatus = 'Verified' WHERE DonationID = ?";
            $stmtDonation = $conn->prepare($queryDonation);
            if (!$stmtDonation) {
                throw new Exception("Error preparing donation update query: " . $conn->error);
            }

            $stmtDonation->bind_param('i', $donationId);
            $stmtDonation->execute();
            $stmtDonation->close();
        }

        // Create certificate record
        $queryCert = "INSERT INTO certificate (UserID, AdminID, DonationID, CertificateImage, IssuedDate) 
                     VALUES (?, ?, ?, ?, NOW())";
        $stmtCert = $conn->prepare($queryCert);
        if (!$stmtCert) {
            throw new Exception("Error preparing certificate insert query: " . $conn->error);
        }

        $stmtCert->bind_param('iiis', $userId, $adminId, $donationId, $certificateImage);
        $stmtCert->execute();
        $stmtCert->close();

        // If everything is successful, commit the transaction
        $conn->commit();

        // Debugging: Success message
        echo "Success: Form submitted successfully!";

        // Redirect back to the admin certificate page with success message
        header("Location: ../admin-certificate.php?success=1");
        exit;
    } catch (Exception $e) {
        // If there was an error, roll back the transaction
        $conn->rollback();

        // Clean up any uploaded files
        if (!empty($certificateImage) && file_exists($uploadDir . basename($certificateImage))) {
            unlink($uploadDir . basename($certificateImage));
        }

        // Debugging: Print error message
        die("Database error: " . $e->getMessage());
    }
}
?>
