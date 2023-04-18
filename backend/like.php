<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['name'])) {
  echo 'You must be logged in to like images.';
  exit();
}

// Get image ID from POST data
if (!isset($_POST['image_id'])) {
  echo 'Invalid request.';
  exit();
}
$image_id = intval($_POST['image_id']);

// Connect to database
$db = new mysqli('localhost', 'deepa', 'deep@123', 'deepa');
if ($db->connect_errno) {
  echo 'Failed to connect to database: ' . $db->connect_error;
  exit();
}

// Check if user has already liked the image
$stmt = $db->prepare('SELECT COUNT(*) FROM likes WHERE user = ? AND image_id = ?');
$stmt->bind_param('si', $_SESSION['name'], $image_id);
$stmt->execute();
$stmt->bind_result($like_count);
$stmt->fetch();
$stmt->close();
if ($like_count > 0) {
  echo 'You have already liked this image.';
// echo '<script>alert("You have already liked this image.");</script>';
  exit();
}

// if ($like_count > 0) {
//     echo 'You have already liked this image.';
//   echo '<script>setTimeout(function() { document.getElementById("already-liked-message").style.display = "none"; }, 3000);</script>';
//   exit();
//   }

// Insert new like record
$stmt = $db->prepare('INSERT INTO likes (user, image_id) VALUES (?, ?)');
$stmt->bind_param('si', $_SESSION['name'], $image_id);
$stmt->execute();
$stmt->close();

// Increment like count in image table
$db->query('UPDATE image SET likes = likes + 1 WHERE id = ' . $image_id);

// Get updated like count
$result = $db->query('SELECT likes FROM image WHERE id = ' . $image_id);
if (!$result) {
  echo 'Failed to update like count: ' . $db->error;
  exit();
}
$row = $result->fetch_assoc();
$like_count = $row['likes'];
$result->close();

// Close database connection
$db->close();

// Return updated like count
echo $like_count;
?> 