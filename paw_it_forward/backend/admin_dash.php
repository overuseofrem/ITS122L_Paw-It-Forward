<?php
include __DIR__ . '/paw_database.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['post_id']) || empty($_POST['post_id'])) {
        header("Location: admin-dash.php?message=" . urlencode("Invalid request: Missing post ID."));
        exit();
    }

    $postID = $_POST['post_id'];

    // Check if the post exists before proceeding
    $checkQuery = "SELECT * FROM Post WHERE PostID = ?";
    $stmtCheck = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($stmtCheck, "i", $postID);
    mysqli_stmt_execute($stmtCheck);
    $result = mysqli_stmt_get_result($stmtCheck);

    if (mysqli_num_rows($result) > 0) {
        mysqli_stmt_close($stmtCheck);

        if (isset($_POST['approve'])) {
            // Approve post
            $query = "UPDATE Post SET PostStatus = 'Approved' WHERE PostID = ?";
        } elseif (isset($_POST['reject'])) {
            // Delete post
            $query = "DELETE FROM Post WHERE PostID = ?";
        } else {
            header("Location: admin-dash.php?message=" . urlencode("Invalid action."));
            exit();
        }

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $postID);

        if (mysqli_stmt_execute($stmt)) {
            $message = isset($_POST['approve']) ? "Post approved successfully!" : "Post rejected and deleted!";
        } else {
            error_log("MySQL Error: " . mysqli_error($conn));
            $message = "Error processing request.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "Error: Post does not exist.";
    }

    header("Location: ../admin-dash.php");
    exit();
}

mysqli_close($conn);
?>
