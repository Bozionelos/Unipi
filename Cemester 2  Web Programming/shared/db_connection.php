<?php

$db = mysqli_connect('localhost', 'root', 'mpsp13086','unipi');
    
    if (!$db) {
        die('Could not connect: ' . mysql_error());
        
    }

?>