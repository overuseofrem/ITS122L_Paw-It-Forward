<?php
session_start();
include 'paw_database.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if fields are empty
    if (empty($email) || empty($password)) {
        header("Location: ../admin-login.php?error=Please fill in all fields.");
        exit();
    }

    // Query to check if admin exists
    $stmt = $conn->prepare("SELECT AdminID, FirstName, LastName, Email, Password FROM Admin WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Compare plaintext passwords (⚠️ Not secure for production)
        if ($password === $row['Password']) {
            // Store admin data in session
            $_SESSION['AdminID'] = $row['AdminID'];
            $_SESSION['FirstName'] = $row['FirstName'];
            $_SESSION['LastName'] = $row['LastName'];
            $_SESSION['Email'] = $row['Email'];

            header("Location: ../admin-dash.php?success=Login successful!");
            exit();
        } else {
            header("Location: ../admin-login.php?error=Incorrect password.");
            exit();
        }
    } else {
        header("Location: ../admin-login.php?error=Admin not found.");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../admin-login.php");
    exit();
}
?>
