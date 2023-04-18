<?php
// Retrieve form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$contact=$_POST['contact'];
$dob=$_POST['dob'];
$city=$_POST['city'];

// Connect to database
$conn = mysqli_connect("localhost","deepa","deep@123","deepa");

if(!$conn){
    die("connection failed: ".mysqli_connect_error());
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $sql="insert into exp2 values('$username','$password','$email','$contact','$dob','$city')";
    if(mysqli_query($conn,$sql)){
        header("location:login.html");
    }
    else{
        echo "<script>alert('signin unsuccessful! Please check the details.');</script>";
        header("location:signin.html");
    }
    mysqli_close($conn);
}
?>
