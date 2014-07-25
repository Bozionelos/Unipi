<?php

class Users_Collection{
    public $users_collection = array();
    public $ucount;
    
    public function deleteUser($userID){
        include('C:\xampp\htdocs\unipi\shared\db_connection.php');
        $result = mysqli_query($db,"delete from unipi_personal_info where unipi_personal_info.user_id = ".$userID); 
        $result = mysqli_query($db,"delete from unipi_user where unipi_user.id = ".$userID); 
        $result = mysqli_query($db,"select * from unipi_user where unipi_user.id = ".$userID);  
        return $result->num_rows;
    }
    public function addUser($user){
        include('C:\xampp\htdocs\unipi\shared\db_connection.php');
        if($user['user_id'] == ""){
            $type = $user['type'];
            if(is_array($user['type'])){
                $type = $user['type'][0];  
            }
            $result = mysqli_query($db,"insert into unipi_user (username,password,block,token,email, type) values ('".$user['username']."','".$user['password']."',".$user['block'].",'".$user['token']."','".$user['email']."',".$type.") "); 
            
            
            $result2 = mysqli_query($db,"select * from unipi_user where unipi_user.username = '".$user['username']."'");
            while($id = $result2->fetch_row()) {
                $newId = $id[0];   
            }
            $result = mysqli_query($db,"insert into unipi_personal_info (user_id,first_name,last_name,parent_name,telephone,address, cemester) values (".$newId.",'".$user['fname']."','".$user['lname']."','".$user['pname']."','".$user['telephone']."','".$user['address']."','".$user['cemester']."') "); 
        }
        else{
            $type = $user['type'];
            if(is_array($user['type'])){
                $type = $user['type'][0];  
            }
            $result = mysqli_query($db,"update unipi_user set username = '".$user['username']."' ,password  = '".$user['password']."',block = ".$user['block']." ,token = '".$user['token']."' ,email = '".$user['email']."' , type  = ".$type."  where id= ".$user['user_id']);  
                                   
            $result = mysqli_query($db,"update unipi_personal_info set first_name = '".$user['fname']."' ,last_name  = '".$user['lname']."',parent_name = '".$user['pname']."' ,telephone = '".$user['telephone']."' ,address = '".$user['address']."' , cemester  = '".$user['cemester']."'  where user_id= ".$user['user_id']);   
        }
    }
    public function getUserByUsername($username, $id_to_exclude){
        include('C:\xampp\htdocs\unipi\shared\db_connection.php');
        $result = mysqli_query($db,"select * from unipi_user where unipi_user.username = '".$username."' AND unipi_user.id != ".$id_to_exclude);  
        $this->ucount = $result->num_rows;
        return $this->ucount;
    }
    public function getAllUsers(){
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
            array_push($this->users_collection,$user);
        }
        return $this->users_collection;
    }
    public function getSpecificUser($id){
        include('C:\xampp\htdocs\unipi\shared\db_connection.php');
        $result = mysqli_query($db,"select * from unipi_user, unipi_personal_info where unipi_personal_info.user_id = unipi_user.id AND unipi_user.id = ".$id);  
        while($users = $result->fetch_row()) {
            
            $user = new user;
            $user->user_id = $users[0];
            $user->username = $users[1];
            $user->password = $users[2];
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
            array_push($this->users_collection,$user);
        }
        return $this->users_collection;
    }
}
class user{
    public $user_id;
    public $username;
    public $password;
    public $block;
    public $token;
    public $email;
    public $type;
    public $fname;
    public $lname;
    public $pname;
    public $telephone;
    public $address;
    public $cemester;

    
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

class Usergroups{
    public $groups_collection = array(); 
    public function getUserGroups(){
        include('C:\xampp\htdocs\unipi\shared\db_connection.php');
        $result = mysqli_query($db,"select * from unipi_user_type");  
        while($groups = $result->fetch_row()) {
            array_push($this->groups_collection,($groups[0]." --> ".$groups[1]));
        }
        return $this->groups_collection;
    }
}

?>