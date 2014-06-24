        <?php
        require('C:\xampp\htdocs\unipi\components\login\models\login.php');
        session_start();
        $user = $_SESSION['user'];
        print_r($user);
        ?>