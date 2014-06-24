<?php

    include 'C:\xampp\htdocs\unipi\components\login\models\login.php';
    session_start();
    if($_POST["action"] == "admin_login"){
        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            $user->update();
        }
        else{
            $user = new user(); 
            $user->authenticate($_POST['username'],$_POST['password']);
            $_SESSION['user'] = $user;
        }
    }

?>

    

    