<!DOCTYPE html>
<html>
<head>
	<title> Images</title>
	<style>
		body {
			font-family: Arial, sans-serif;
		}
		h1 {
			text-align: center;
			margin-top: 50px;
			color:#e453c9;
		}
		.container {
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			margin-top: 50px;
		}
		.card {
			margin: 20px;
			border: 1px solid #ccc;
			box-shadow: 0 0 10px #e453c9;
			width: 300px;
			height: 400px;
			display: flex;
			flex-direction: column;
			justify-content: space-between;
		}
		.card img {
			width: 100%;
			height: 100%;
			object-fit: cover;
		}
		.card h2 {
			text-align: center;
			margin: 10px 0;
		}
		.card p {
			margin: 10px;
			text-align: center;
		}
		.card span {
			display: block;
			margin: 10px;
			text-align: center;
		}
	</style>
</head>
<body>

	<h1>My Gallery</h1>
	<div class="container">
		<?php
			// Connect to MySQL database 				
            session_start();
			$servername = "localhost";
			$username = "deepa";
			$password = "deep@123";
			$dbname = "deepa";

			$conn = mysqli_connect($servername, $username, $password, $dbname);

			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}

			// Fetch images uploaded by the user from MySQL table 'image' and directory 'uploads'
			$sql = "SELECT id, user, file_name, likes, created_at FROM image WHERE user = '{$_SESSION['name']}'";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<div class='card'>";
                  echo "<img src='uploads/" . $row["file_name"] . "' alt='" . $row["user"] . "' />";
                  echo "<div class='card-details'>";
                  echo "<span class='likes'>" . $row["likes"] . " Likes</span>";
                  echo "<span class='created-at'>" . $row["created_at"] . "</span>";
                  echo "</div>";
                  echo "</div>";
                }
              }
              else {
                echo "No images found.";
              }
        ?>
    </div>      
</body>    
</html>    
