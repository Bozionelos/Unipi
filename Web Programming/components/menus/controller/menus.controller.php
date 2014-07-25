<?php

    include 'C:\xampp\htdocs\unipi\components\menus\model\menus.model.php';
    session_start();
    if($_POST["action"] == "get_menu"){
        $collection = new Menu_Collection;
        
        $temp = $collection->getMenus();
        $out = array_values($temp);
        echo json_encode($out);
    }

?>
