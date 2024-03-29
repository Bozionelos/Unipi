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

    if($_POST['action'] == "get_user_username"){
        $collection = new Users_Collection;
        if($_POST['exclude'] == "new"){
            $temp = $collection->getUserByUsername($_POST['username'], "-1");
        }
        else{
            $temp = $collection->getUserByUsername($_POST['username'], $_POST['exclude']);
        }
        echo $temp;
        
    }

    if($_POST['action'] == "get_user_groups"){
        $collection = new Usergroups;
        
        $temp = $collection->getUserGroups();
        $out = array_values($temp);
        echo json_encode($out);
    }

    if($_POST['action'] == "save_user"){
         $collection = new Users_Collection;
         $temp = $collection->addUser($_POST);
         echo $temp;
    }
    
    if($_POST['action'] == "delete_users"){
        $collection = new Users_Collection;
        $ids = explode(",", $_POST['users_to_delete']);
        foreach($ids as $id_to_delete){
            $temp = $collection->deleteUser($id_to_delete);
            echo $temp;
        }
    }


?>
