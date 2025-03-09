<?php
    include 'paw_database.php'; // Database connection

    // Ensure connection exists
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Handle rejection of a donation
    if (isset($_POST['rejectDonation']) && isset($_POST['donationId'])) {
        $donationId = $_POST['donationId'];

        // Validate donation ID
        if (!is_numeric($donationId)) {
            die("Invalid donation ID.");
        }

        // Update status to "Rejected"
        $updateQuery = "UPDATE Donation SET VerificationStatus = 'Rejected' WHERE DonationId = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $donationId);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                header('Location: ../admin-donation.php');
                exit; // Prevent further execution
            } else {
                echo "Error: Unable to reject donation.";
            }

            mysqli_stmt_close($stmt);
        } else {
            die("Error preparing statement: " . mysqli_error($conn));
        }

        exit;
    }

    // Handle approval of a donation
    if (isset($_POST['approveDonation']) && isset($_POST['donationId'])) {
        $donationId = $_POST['donationId'];

        // Validate donation ID
        if (!is_numeric($donationId)) {
            die("Invalid donation ID.");
        }

        // Update status to "Approved" and assign an admin
        $adminId = 1; // Since there's only one admin
        $updateQuery = "UPDATE Donation SET VerificationStatus = 'Approved', AdminId = ? WHERE DonationId = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ii", $adminId, $donationId);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                header('Location: ../admin-certificate.php?donationId=' . urlencode($donationId));
                exit; // Prevent further execution
                
            } else {
                echo "Error: Unable to approve donation.";
            }

            mysqli_stmt_close($stmt);
        } else {
            die("Error preparing statement: " . mysqli_error($conn));
        }

        exit;
    }

    // Fetch all "Pending" donations for approval
    $donationQuery = "
        SELECT Donation.DonationId, Donation.DonationImageProof, Donation.DonationDate, Donation.VerificationStatus,
            Users.FirstName AS UserNameFirst, Users.LastName AS UserNameLast,
            COALESCE(Admin.FirstName, 'N/A') AS AdminNameFirst, COALESCE(Admin.LastName, 'N/A') AS AdminNameLast,
            Dog.DogName
        FROM Donation 
        JOIN Users ON Donation.UserId = Users.UserId
        LEFT JOIN Admin ON Donation.AdminId = Admin.AdminId
        JOIN Post ON Donation.PostId = Post.PostId
        JOIN Dog ON Post.DogId = Dog.DogId
        WHERE Donation.VerificationStatus = 'Pending'
    ";

    $donationResult = mysqli_query($conn, $donationQuery);
    if (!$donationResult) {
        die("Error fetching pending donations: " . mysqli_error($conn));
    }
    $donations = mysqli_fetch_all($donationResult, MYSQLI_ASSOC);

    // Fetch all "Approved" donations for issuing certificates
    $approvedQuery = "SELECT * FROM Donation WHERE VerificationStatus = 'Approved'";
    $approvedResult = mysqli_query($conn, $approvedQuery);
    
    if (!$approvedResult) {
        die("Error fetching approved donations: " . mysqli_error($conn));
    }
    
    $approvedDonations = mysqli_fetch_all($approvedResult, MYSQLI_ASSOC);

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Close database connection
    mysqli_close($conn);
?>
