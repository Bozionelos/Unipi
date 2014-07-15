<?php

class Users_Collection{
    public $users_collection = array();
    public function adduser($user){
        
    }
    
    public function getMenus(){
        include('C:\xampp\htdocs\unipi\shared\db_connection.php');
        $result = mysqli_query($db,"select * from unipi_user, unipi_personal_info where unipi_personal_info.user_id = unipi_user.id");  
        while($users = $result->fetch_row()) {
            
            $user = new user;
            $user->user_id = $users[0];
            $user->username = $users[1];
            $user->block = $users[3];
            $user->token = $users[4];
            $user->email = $users[5];
            $user->type = $users[6];
            $user->fname = $users[9];
            $user->lname = $users[10];
            $user->pname = $users[11];
            $user->telephone = $users[12];
            $user->address = $users[13];
            $user->cemester = $users[14];
            $user->mstatus = $users[15];
            array_push($this->users_collection,$user);
        }
        return $this->users_collection;
    }
}
class Menu{
    public $user_id;
    public $username;
    public $block;
    public $token;
    public $email;
    public $type;
    public $fname;
    public $lname;
    public $pname;
    public $token;
    public $telephone;
    public $address;
    public $cemester;
    public $mstatus;
    
    public function __construct(array $arguments = array()) {
        if (!empty($arguments)) {
            foreach ($arguments as $property => $argument) {
                $this->{$property} = $argument;
            }
        }
    } 
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    } 
}

?>