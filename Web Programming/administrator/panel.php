<!-- #820628  -->
<!-- #002E52  -->
<?php
        require('C:\xampp\htdocs\unipi\components\login\models\login.php');
        session_start();
        
        if(!isset($_SESSION['user'])){
            include 'C:\xampp\htdocs\unipi\error\permission_denied.php';
        }else{
            $user = $_SESSION['user'];
            
        ?>
<html>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <link rel="stylesheet" type="text/css" href="http://83.212.102.33/unipi/shared/template.css"/>
    <script src="http://code.jquery.com/jquery-1.9.0.js" type="text/javascript"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js" type="text/javascript"></script>
<body>


    <div id="panel_greeting"> Control Panel V1.0 | Hello <?php echo $user->username; ?></div>
    <div id="panel_selection"> </div>
    <div id="panel_controls">
        <div id="panel_users" class="control" onclick="load_controls(1)"></div>
        <div id="panel_menus" class="control" onclick="load_controls(2)"></div>
        <div id="panel_articles" class="control" onclick="load_controls(3)"></div>
        <div id="panel_settings" class="control" onclick="load_controls(4)"></div>
    </div>
    <div id="tools" class="tools">
    <!-- edw 8a ginetai include to XX.view.php pou pairnoume -->
        
        <?php 
            include 'C:\xampp\htdocs\unipi\shared\component_handler.php'; ?>
    </div>
    <div id="footer">John Paraskakis & Stefanos Bozionelos - University of Piraeus 2014</div>
</body>

    <script src="panel.js" type="text/javascript"></script>
    
</html>
        
<?php        
}
        
        ?>