<?php

    include 'C:\xampp\htdocs\unipi\components\login\models\login.php';
    session_start();
    if($_POST["action"] == "admin_login"){
        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            $user->update();
            $user->isadmin = 2;
        }
        else{
            $user = new user; 
            $result = $user->authenticate($_POST['username'],$_POST['password']);
            if($result['id']){
            $user->user_id = $result['id'];
            $user->login();
            $user->isadmin = 1;
            $_SESSION['user'] = $user;
            }
            else{
                echo "deny";   
            }
        }
    }

?>

    

    