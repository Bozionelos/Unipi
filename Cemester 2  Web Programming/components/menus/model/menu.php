<?php

class Menu_Collection{
    public $menu_collection = array();
    public function addMenu($menu){
        
    }
    
    public function getMenus(){
        include('C:\xampp\htdocs\unipi\shared\db_connection.php');
        $result = mysqli_query($db,"select * from unipi_menu");  
        while($menu_item = $result->fetch_row()) {
            
            $menu = new menu;
            $menu->menu_id = $menu_item[0];
            $menu->type = $menu_item[1];
            $menu->title = $menu_item[2];
            $menu->alias = $menu_item[3];
            $menu->parent_id = $menu_item[4];
            $menu->visible = $menu_item[5];
            array_push($this->menu_collection,$menu);
        }
        return $this->menu_collection;
    }
}
class Menu{
    public $menu_id;
    public $type;
    public $visible;
    public $parent_id;
    public $title;
    public $alias;
    
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