<!-- #820628  -->
<!-- #002E52  -->
<?php
        require('C:\xampp\htdocs\unipi\components\login\models\login.php');
        session_start();
        $user = $_SESSION['user'];
        if(!isset($_SESSION['user'])){
            header( 'Location: C:\xampp\htdocs\unipi\error\permission_denied.php' );
        }else{
        ?>
<html>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <style>
        body{ height:99%; background:#fff;}  
        #panel_greeting{ width:80%; float:left; height:40px; text-align:left; line-height:40px; font-family:Arial; font-weight:15px;}
        #panel_selection{ width:20%; float:left; height:40px; text-align:right; line-height:40px; font-family:Arial; font-weight:15px; }
        #panel_controls{ width:98%; float:left; border:1px solid black; border-radius:4px; margin-left:1%; background:#820628;} 
        .control{width:150px; height:150px; float:left; border:1px solid black; border-radius:4px; margin-right:30px; margin-top:30px; margin-bottom:30px; 
            margin-left:30px; background: white;
            -webkit-transition: all .4s ease-in-out;
            -moz-transition: all .4s ease-in-out;
            -o-transition: all .4s ease-in-out;
            -ms-transition: all .4s ease-in-out;
        }
        .control:hover{cursor:pointer;}
        .transition {
            -webkit-transform: scale(1.2); 
            -moz-transform: scale(1.2);
            -o-transform: scale(1.2);
            transform: scale(1.2);
        }
        .tools{width:98%; float:left; border:0px solid #820628; border-radius:4px; margin-left:1%; background:#fff; margin-top:20px;}
        
        #panel_users{background-image: url("../images/users.png"); background-size: 150px 150px; background-repeat: no-repeat;}
        #panel_menus{background-image: url("../images/design.png"); background-size: 150px 150px; background-repeat: no-repeat;}
        #panel_articles{background-image: url("../images/articles.png"); background-size: 150px 150px; background-repeat: no-repeat;}
        #panel_settings{background-image: url("../images/settings.png"); background-size: 150px 150px; background-repeat: no-repeat;}
        
        #menu_tree {float: left; width:200px; border-right:1px solid #820628;}
        .menu_ul {line-height:30px; width:100%; background:#820628; color:white; font:15px arial; height:30px;  }
        .menu_ul:hover{cursor:move;}
        .menu_list {font:12px arial; margin-bottom: 30px;list-style: none; padding-top: 5px;}
        .menu_list li {height:20px; line-height:20px;}
        .menu_list li:hover {cursor:move;}
        .ui-state-highlight { height:28px; line-height:30px;  border:1px dashed #002E52;}
        div#menu_functions{float: left;width: 75%; height: 400px; margin: 30px 0 0 30px;}
        div#site_layout_top { float: left; width: 80%; height: 10%; border: 1px solid #002E52; margin-right: 9%; margin-left: 9%; margin-top: 10px; }
        div#site_layout_right { width: 10%; height: 70%; border: 1px solid #002E52; margin-top: 1%;margin-left: 9%; float: left;}
        div#site_layout_left { width: 10%; height: 70%; border: 1px solid #002E52; float: left; margin-top: 1%; margin-left: 1%; }
        div#site_layout_content { width: 57.2%; float: left; height: 70%; border: 1px solid #002E52; margin-top: 1%; text-align: center;margin-left: 1%; font: 17px Arial; line-height: 200px; }
        div#site_layout_footer {height: 10%;width: 80%;float: left;border: 1px solid #002E52;margin-top: 1%;margin-left: 9%;}
    </style>
<body>

    <div id="panel_greeting"> Control Panel V1.0 | Hello <?php echo $user->username; ?></div>
    <div id="panel_selection"> </div>
    <div id="panel_controls">
        <div id="panel_users" class="control" onclick="load_controls(1)"></div>
        <div id="panel_menus" class="control" onclick="load_controls(2)"></div>
        <div id="panel_articles" class="control" onclick="load_controls(3)"></div>
        <div id="panel_settings" class="control" onclick="load_controls(4)"></div>
    </div>
    <div id="tools" class="tools"></div>
</body>
    <script src="http://code.jquery.com/jquery-1.9.0.js" type="text/javascript"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js" type="text/javascript"></script>
    <script src="panel.js" type="text/javascript"></script>
    <script src="controlsJS/menus.js" type="text/javascript"></script>
    
</html>
        
<?php        
}
        
        ?>