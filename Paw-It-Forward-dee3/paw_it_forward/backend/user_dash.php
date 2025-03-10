<?php
    include 'paw_database.php'; // connect to database -- dee
    
    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if session variables are set and sanitize
    $userId = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : null;
    
    // Get user's first name from the users table
    $userName = 'user'; // default value in case the user is not found

    if ($userId) {
        $query = "SELECT FirstName FROM users WHERE UserID = ?";
        
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                $userName = htmlspecialchars($row['FirstName']);
            }
            
            $stmt->close();
        } else {
            // Log error instead of echoing directly in production
            error_log("Database query error: " . $conn->error);
            echo "Error fetching user name.";
        }
    }

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
        // Log error instead of echoing directly in production
        error_log("Database query error: " . $conn->error);
        echo "Error fetching certificates.";
    }

    $conn->close();
?>
