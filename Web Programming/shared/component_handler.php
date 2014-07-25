<?php 

$base_ = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$site = "site";
if (strpos($base_, 'administrator') !== FALSE){
    $site = "admin";
}

if($site == "admin"){
    
    if(isset($_REQUEST['component'])){
        if($_REQUEST['component']=="users"){
            include 'C:\xampp\htdocs\unipi\components\users\view\users.view.php';   
        }
        else if($_REQUEST['component']=="menus"){
            include 'C:\xampp\htdocs\unipi\components\menus\view\menus.view.php';
        }
        else{
            include 'C:\xampp\htdocs\unipi\shared\empty.php'; 
        }
           
    }
}
else{
    include "other";
}
?>