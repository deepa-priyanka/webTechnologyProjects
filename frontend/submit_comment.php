<?php
// Start session
session_start();

// Include database connection
include('sample.php');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
  header('Location: login.html');
  exit();
}

// Retrieve form data
$user = $_SESSION['user'];
$text = $_POST['text'];
$image_id = $_POST['image_id'];
$commented_at = date('Y-m-d H:i:s');

// Insert into database
$query = "INSERT INTO image_comments (user, text, image_id, commented_at)
          VALUES ('$user', '$text', $image_id, '$commented_at')";
$result = mysqli_query($db, $query);

if ($result) {
  echo 'success';
} else {
  echo 'error';
}
?>
