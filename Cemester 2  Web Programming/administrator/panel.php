        <?php
        require('C:\xampp\htdocs\unipi\components\login\models\login.php');
        session_start();
        $user = $_SESSION['user'];
        if(!isset($_SESSION['user'])){
            header( 'Location: C:\xampp\htdocs\unipi\error\permission_denied.php' );
        }else{
        ?>
<html>

</html>
        
<?php        
}
        
        ?>