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
        // Compare plaintext passwords (⚠️ not secure for production)
        if ($password === $row['Password']) {
            // Store user data in session
            $_SESSION['UserID'] = $row['UserID'];
            $_SESSION['FirstName'] = $row['FirstName'];
            $_SESSION['LastName'] = $row['LastName'];
            $_SESSION['Email'] = $row['Email'];

            header("Location: ../user-dash.php?success=Login successful!");
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
