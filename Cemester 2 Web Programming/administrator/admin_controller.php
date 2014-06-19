<?php

    include('C:\xampp\htdocs\unipi\shared\db_connection.php');
    
    
    if($_POST["action"] == "admin_login"){
        $result = mysqli_query($db,"SELECT * FROM unipi_user where username='".$_POST['username']."' AND password='".$_POST['password']."' AND type=6");
        if( count(mysqli_fetch_array($result))) {
            echo "10";
        }
        else{
            echo "deny";   
        }
    }