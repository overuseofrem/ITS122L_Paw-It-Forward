<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "paw_it_forward";

// create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// added some error handling here for debugging -- dee
if (!$conn) {
    die("⚠ Database Connection Failed: " . mysqli_connect_error());
} else {
    // uncomment this if you want a success message (for debugging)
    // echo "✅ Connected successfully to the database!";
}
?>
