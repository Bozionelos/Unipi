<?php

    include('C:\xampp\htdocs\unipi\shared\db_connection.php');
    if($_POST['action'] == "set_session"){
        $user_id = $_POST['user_id'];
        
  
        $result = mysqli_query($db,"update or insert into unipi_sessions (user_id,time) VALUES(".$user_id.",NOW()) matching (user_id)");
    }
    else if ($_POST['action'] == "get_session"){
        
    }

?>