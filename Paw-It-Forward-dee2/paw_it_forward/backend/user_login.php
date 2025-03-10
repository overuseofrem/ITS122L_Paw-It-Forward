<?php
session_start();
include 'paw_database.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if fields are empty
    if (empty($email) || empty($password)) {
        header("Location: ../login.php?error=Please fill in all fields.");
        exit();
    }

    // Query to check if user exists
    $stmt = $conn->prepare("SELECT UserID, FirstName, LastName, Email, Password FROM Users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Direct password comparison (NO HASHING)
        if ($password === $row['Password']) { 
            // Store user data in session
            $_SESSION['user_logged_in'] = true; // added this session flag -- dee
            $_SESSION['UserID'] = $row['UserID'];
            $_SESSION['FirstName'] = $row['FirstName'];
            $_SESSION['LastName'] = $row['LastName'];
            $_SESSION['Email'] = $row['Email'];

            // Redirect user to previous page or dashboard
            $redirectPage = isset($_SESSION['redirect_to']) ? $_SESSION['redirect_to'] : '../user-dash.php';
            unset($_SESSION['redirect_to']); // Clear redirect session after use
            header("Location: $redirectPage?success=Login successful!");
            exit();
        } else {
            header("Location: ../login.php?error=Incorrect password.");
            exit();
        }
    } else {
        header("Location: ../login.php?error=User not found.");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../login.php");
    exit();
}
?>
