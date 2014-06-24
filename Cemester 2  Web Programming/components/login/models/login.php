<?php

class User{
    private static $session;
    private static $isadmin;
    private static $user_id;
    private static $username;
    
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

    public function login($user_id){
        include('C:\xampp\htdocs\unipi\shared\db_connection.php');
        $result = mysqli_query($db,"insert into unipi_sessions (user_id,time) VALUES(".$user_id.",NOW())");  
    }

    public function update(){
        include('C:\xampp\htdocs\unipi\shared\db_connection.php');
        $result = mysqli_query($db,"update unipi_sessions set time = NOW() where user_id = '".$this->$user_id."'"); 
    }
    public function authenticate($username, $password){
        include('C:\xampp\htdocs\unipi\shared\db_connection.php');
        $result = mysqli_query($db,"select * from unipi_user where username='".$username."' AND password='".$password."' AND type=6");  
        print_r($result);
    }
}

?>