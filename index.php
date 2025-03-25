<?php 
    session_start();
    if (isset($_SESSION['userId'])){
        header("Location: ./public/pages/home.php");
    }else{
        header("Location: ./public/pages/login.php");
    }