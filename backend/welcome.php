<?php
    session_start();
    if(!isset($_SESSION['name'])){
        echo "error";
        exit();
    }
    echo "<h1 style='font-family: Arial, sans-serif; color: #333; font-size: 32px;'>Hey " . $_SESSION['name'] . " !! </h1>";
?>