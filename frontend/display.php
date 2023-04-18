<!DOCTYPE html>
<html>

<head>
  <title>Images</title>
  <style>
    .comment-symbol {
      margin-left: 40px;
      cursor: pointer;
    }

    .image {
      display: inline-block;
      margin: 10px;
      text-align: center;
    }

    .image img {
      max-width: 300px;
      max-height: 300px;
    }

    .image .likes {
      margin-top: 10px;
      position: relative;
    }

    .like-count {
      margin-left: 35px;
    }


    .like-symbol:hover {
      cursor: pointer;
    }

    .image .likes:hover .user-list {
      display: block;
    }

    .user-list {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      width: 100%;
      background-color: white;
      border: 1px solid black;
      padding: 5px;
      text-align: left;
    }

  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.like-symbol').click(function() {
        var image_id = $(this).data('image-id');
        $.ajax({
          url: 'like.php',
          type: 'POST',
          data: {
            image_id: image_id
          },
          success: function(like_count) {
            $('#likes-' + image_id).text(like_count);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error: ' + textStatus + ' - ' + errorThrown);
          }
        });
      });
    });

    function showUserList(image_id) {
      $('#user-list-' + image_id).show();
    }

    function hideUserList(image_id) {
      $('#user-list-' + image_id).hide();
    }
  </script>
</head>

<body>
  <?php
  // Connect to database
  $db = new mysqli('localhost', 'deepa', 'deep@123', 'deepa');
  if ($db->connect_errno) {
    echo 'Failed to connect to database: ' . $db->connect_error;
    exit();
  }

  // Query images from database, ordered by likes descending
  $result = $db->query('SELECT * FROM image ORDER BY likes DESC');
  if (!$result) {
    echo 'Failed to query images: ' . $db->error;
    exit();
  }
//  $un=$result['user'];
  // Loop through images and display them
  while ($row = $result->fetch_assoc()) {
    $image_url = 'uploads/' . $row['file_name'];
    $like_count = $row['likes'];
    $image_id = $row['id'];
    $un=$row['user'];

    // Query users who have liked this image
    $likes_result = $db->query("SELECT user FROM likes WHERE image_id = $image_id");
    $user_list = '';
    if ($likes_result) {
      while ($like_row = $likes_result->fetch_assoc()) {
        $user_list .= $like_row['user'] . ', ';
      }
      $user_list = rtrim($user_list, ', ');
    }

    echo '<div class="image">';
    echo '<p><b>'.$un.'</b></p>';
    echo '<img src="' . $image_url . '" alt="Image">';
    echo '<div class="likes" id="likes-' . $row['id'] . '">';
    echo '<span class="like-symbol" data-image-id="' . $row['id'] . '">&#10084;</span> ';
    echo '<span id="likes-' . " " . '" class="like-count" onmouseover="showUserList(' . $image_id . ')" onmouseout="hideUserList(' . $image_id . ')"><b>' . $like_count . '</b></span>';
    echo '<div id="user-list-' . $image_id . '" class="user-list">' . $user_list . '</div>';
    echo '<span class="comment-symbol" data-image-id="' . $row['id'] . '">&#9998;</span> ';
    echo '</div>';
    echo '</div>';
  }

  // Close database connection
  $db->close();
  ?>
</body>

</html>