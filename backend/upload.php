<?php
// Start session
session_start();

// Database connection details
$db_host = 'localhost';
$db_user = 'deepa';
$db_pass = 'deep@123';
$db_name = 'deepa';

// Connect to database
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if file uploaded successfully
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == UPLOAD_ERR_OK) {
        // Get file details
        $file_name = $_FILES['picture']['name'];
        $file_size = $_FILES['picture']['size'];
        $file_tmp = $_FILES['picture']['tmp_name'];
        $file_type = $_FILES['picture']['type'];

        // Generate unique file name
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $file_name = uniqid() . '.' . $file_ext;

        // Upload file to folder
        $upload_dir = 'uploads/';
        $target_file = $upload_dir . $file_name;
        move_uploaded_file($file_tmp, $target_file);

        // Save file details to database
        $user = $_SESSION['name'];
        $query = "INSERT INTO image (user, file_name, likes, created_at) VALUES ('$user', '$file_name', 0, NOW())";
        mysqli_query($conn, $query);

        // Redirect to success page
        // header('Location: upload.html');
        echo "<h2 style='color:#1abc9c; margin-top:120px; margin-left:320px;'> Image Uploaded Successfully !!</h2>";
        exit;
    } else {
        // File upload failed
        $error = 'File upload failed.';
    }
}

?>
