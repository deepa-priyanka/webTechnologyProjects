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

        < !-- video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        -->
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
    <!-- <video autoplay loop muted>
    <source src="bg.mp4" type="video/mp4">
  </video> -->
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

    // Loop through images and display them
    while ($row = $result->fetch_assoc()) {
        $image_url = 'uploads/' . $row['file_name'];
        $like_count = $row['likes'];
        $image_id = $row['id'];

        // Query users who have liked this image
        $likes_result = $db->query("SELECT user FROM likes WHERE image_id = $image_id");
        $user_list = '';
        if ($likes_result) {
            while ($like_row = $likes_result->fetch_assoc()) {
                $user_list .= $like_row['user'] . ', ';
            }
            $user_list = rtrim($user_list, ', ');
        }

        /**
         * Summary of retrieve_comments
         * @param mixed $image_id
         * @return array
         */
        // if (!function_exists('retrieve_comments')) {
        //     function retrieve_comments($image_id)
        //     {
        //         $db = new mysqli('localhost', 'deepa', 'deep@123', 'deepa');
        //         $query = "SELECT * FROM image_comments WHERE image_id = " . $image_id;
        //         $result = mysqli_query($db, $query);
        //         $comments = array();

        //         while ($row = mysqli_fetch_assoc($result)) {
        //             $comments[] = $row;
        //         }

        //         mysqli_close($db);

        //         return $comments;
        //     }
        // }

        echo '<div class="image">';
        echo '<img src="' . $image_url . '" alt="Image">';
        echo '<div class="likes" id="likes-' . $row['id'] . '">';
        echo '<span class="like-symbol" data-image-id="' . $row['id'] . '">&#10084;</span> ';
        echo '<span id="likes-' . " " . '" class="like-count" onmouseover="showUserList(' . $image_id . ')" onmouseout="hideUserList(' . $image_id . ')">' . $like_count . '</span>';
        echo '<div id="user-list-' . $image_id . '" class="user-list">' . $user_list . '</div>';
        echo '<span class="comment-symbol" data-image-id="' . $row['id'] . '">&#9998;</span> ';
        echo '</div>';
        echo '</div>';
        echo '<span class="comment-symbol" data-image-id="' . $row['id'] . '" onmouseover="showCommentsBox(' . $row['id'] . ')" onmouseout="hideCommentsBox(' . $row['id'] . ')">&#9998;</span> ';

        echo '<div class="comments-box" id="comments-box-' . $row['id'] . '">';
        echo '<div class="comments-list">';
        // Retrieve comments for this image from the database
        function retrieve_comments($image_id)
        {
            // Include database connection
            include('db_connection.php');

            // Retrieve comments for this image
            $query = "SELECT * FROM image_comments WHERE image_id = $image_id ORDER BY commented_at DESC";
            $result = mysqli_query($conn, $query);
            $comments = array();
            while ($row = mysqli_fetch_assoc($result)) {
                // Add each comment to the array
                $comments[] = array(
                    'user' => $row['user'],
                    'text' => $row['text'],
                    'commented_at' => $row['commented_at']
                );
            }

            // Close database connection
            mysqli_close($conn);

            // Return the array of comments
            return $comments;
        }

        echo '<div class="comments-section" id="comments-section-' . $row['id'] . '">';
        // Retrieve comments for this image from the database
        $comments = retrieve_comments($row['id']);
        foreach ($comments as $comment) {
            echo '<div class="comment">';
            echo '<span class="comment-user">' . $comment['user'] . '</span>';
            echo '<span class="comment-text">' . $comment['text'] . '</span>';
            echo '</div>';
        }
        echo '</div>';
        
        // Add a new comment to the database
        function add_comment($image_id, $user, $text)
        {
            // Include database connection
            include('db_connection.php');

            // Format the user input to prevent SQL injection attacks
            $user = mysqli_real_escape_string($conn, $user);
            $text = mysqli_real_escape_string($conn, $text);

            // Insert the new comment into the database
            $query = "INSERT INTO image_comments (user, text, image_id) VALUES ('$user', '$text', $image_id)";
            $result = mysqli_query($conn, $query);

            // Close database connection
            mysqli_close($conn);

            // Return the result of the query (true if successful, false if not)
            return $result;
        }


        echo '</div>';
        echo '<div class="comment-input">';
        echo '<textarea id="comment-text-' . $row['id'] . '" placeholder="Add a comment..."></textarea>';
        echo '<button id="comment-submit-' . $row['id'] . '" onclick="submitComment(' . $row['id'] . ')">Submit</button>';
        echo '</div>';
        echo '</div>';

        echo '<script>
function submitComment(image_id) {
  var text = document.getElementById("comment-text-" + image_id).value;
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      if (xhr.responseText == "success") {
        // Reload the comments section
        var commentsSection = document.getElementById("comments-section-" + image_id);
        commentsSection.innerHTML = "";
        loadComments(image_id);
      } else {
        alert("Error submitting comment.");
      }
    }
  };
  xhr.open("POST", "submit_comment.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("text=" + text + "&image_id=" + image_id);
}
</script>';
    }

    // Close database connection
    $db->close();
    ?>
</body>

</html>