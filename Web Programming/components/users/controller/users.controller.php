<?php

    include 'C:\xampp\htdocs\unipi\components\users\model\users.model.php';
    session_start();
    if($_POST["action"] == "get_all_users"){
        $collection = new Users_Collection;
        
        $temp = $collection->getAllUsers();
        $out = array_values($temp);
        echo json_encode($out);
    }

    if($_POST['action'] == "get_xml"){
        include 'users.xml.php';
        
    }
    
    if($_POST['action'] == "get_user"){
        $collection = new Users_Collection;
        
        $temp = $collection->getSpecificUser($_POST['user_id']);
        $out = array_values($temp);
        echo json_encode($out);
        
    }

?>
