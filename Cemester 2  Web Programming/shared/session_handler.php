<?php

    include('C:\xampp\htdocs\unipi\shared\db_connection.php');
    if($_POST['action'] == "set_session"){
        $user_id = $_POST['user_id'];
        $result = mysqli_query($db,"SELECT * FROM unipi_sessions where user_id=".$user_id);
        $query_result = mysqli_fetch_array($result);
        $result_count = mysqli_num_rows($result);
        
        
        if( $result_count>0) {
            //Updating
            $result = mysqli_query($db,"update unipi_sessions set time = NOW() where user_id = '".$query_result['user_id']."'"); 
        }
        else{
            //Inserting
            $result = mysqli_query($db,"insert into unipi_sessions (user_id,time) VALUES(".$user_id.",NOW())");  
        }
    }
    if($_POST["action"] == "check_session"){
        $result = mysqli_query($db,"SELECT * FROM unipi_user where username='".$_POST['session']."' AND password='".$_POST['password']."' AND type=6");
        if( count(mysqli_fetch_array($result))) {
            echo "allow";
        }
        else{
            echo "deny";   
        }
    }

?>