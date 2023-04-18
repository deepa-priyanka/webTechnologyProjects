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
            margin-left: 200px;
            margin-right: 100px;
            color: black;
            background-color:#F0E68C;
            border-radius: 30%;
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
            width: 295px;
            height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-radius: 5%;
            background-color:#F0E68C;
        }

        .card img {
            width: 100%;
            height: 70%;
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

    <h1>Popular Uploads !!</h1>
    <div class="container">
        <?php
        // Connect to MySQL database 				
        $servername = "localhost";
        $username = "deepa";
        $password = "deep@123";
        $dbname = "deepa";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch images uploaded by the user from MySQL table 'image' and directory 'uploads'
        $sql = "SELECT * FROM image ORDER BY likes DESC LIMIT 5";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<div class='card'>";
              echo '<p><b>'.$row['user'].'</b></p>';
              echo "<img src='uploads/" . $row["file_name"] . "' alt='" . $row["user"] . "' />";
              echo "<div class='card-details'>";
              echo "<span class='likes'><b>" . $row["likes"] . " Likes </b></span>";
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