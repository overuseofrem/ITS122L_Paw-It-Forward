<?php
include 'paw_database.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Check if fields are empty
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: ../create-account.php?error=All fields are required");
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../create-account.php?error=Invalid email format");
        exit();
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        header("Location: ../create-account.php?error=Passwords do not match");
        exit();
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT UserID FROM Users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: ../create-account.php?error=Email already registered");
        exit();
    }
    $stmt->close();

    // Insert user into database (without password hashing)
    $stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Email, Password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstname, $lastname, $email, $password);

    if ($stmt->execute()) {
        header("Location: ../login.php?success=Account created! Please log in.");
        exit();
    } else {
        header("Location: ../create-account.php?error=Something went wrong. Try again.");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../create-account.php");
    exit();
}
?>
