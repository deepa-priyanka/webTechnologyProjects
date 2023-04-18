<!DOCTYPE html>
<html>

<head>
    <title>User Details </title>
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f8f8;
        margin: 0;
        padding: 0;
    }

    h3 {
        text-align: center;
        margin-top: 50px;
        color: #04551a;
        font-size: 2rem;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 30px;
    }

    .card {
        margin: 0px;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: #b8f1c7;
        width: 300px;
        height: 300px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
    }

    .card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .card h2 {
        text-align: center;
        margin: 20px 0;
        color: #e453c9;
        font-size: 1.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .card p {
        margin: 10px;
        text-align: center;
        font-size: 1.1rem;
        color: #333;
        line-height: 1.5;
    }

    .card strong {
        color: #04551a;
        font-weight: 600;
    }

    .card span {
        display: block;
        margin: 10px;
        text-align: center;
        font-size: 1rem;
        color: #04551a;
    }
    </style>
</head>

<body>
    <h3>My Profile</h3>
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

			// Fetch user details from MySQL table 'exp2'
			$sql = "SELECT username, email, contact, dob, city FROM exp2 WHERE username = '{$_SESSION['name']}'";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);
				echo "<div class='card' style='background-color: #e0f7e6;'>";
				echo "<p><strong>Username: </strong>" . $row["username"] . "</p>";
				echo "<p><strong>Email: </strong>" . $row["email"] . "</p>";
				echo "<p><strong>Contact: </strong>" . $row["contact"] . "</p>";
				echo "<p><strong>Date of Birth: </strong>" . $row["dob"] . "</p>";
				echo "<p><strong>City: </strong>" . $row["city"] . "</p>";
				echo "</div>";
			}
        ?>
    </div>
</body>

</html>