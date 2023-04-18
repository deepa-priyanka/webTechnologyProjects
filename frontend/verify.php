<?php
    session_start();
    // include_once("signup.php");
$servername = "localhost";
$u = "deepa";
$p = "deep@123";
$db = "deepa";

$conn = mysqli_connect($servername,$u,$p,$db);
if(!$conn){
    die("connection failed: ".mysqli_connect_error());
}
    $username=$_POST["username"];
    $password=$_POST["password"];
    $sql="select * from exp2 where username='$username' and password='$password'";
    $res=mysqli_query($conn,$sql);
    if(mysqli_num_rows($res)>0){
        $_SESSION['name']=$username;
       header("location:welcome.html");
    }
    else{
        echo "login unsuccessful  !!";
        header("location:login.html");
    }
    mysqli_close($conn);
?>