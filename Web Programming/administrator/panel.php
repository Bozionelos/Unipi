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
    <style>
        body{ height:99%; background:#fff; font-family:arial;}  
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
        .tools{width:98%; float:left; border:0px solid #820628; border-radius:4px; margin-left:1%; background:#fff; margin-top:20px; padding-bottom:20px;}
        
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
        
        #users   {width:100%; }
        #users th{background:#820628; color:white; height:30px;}
        #users td{background:lightgrey; height:20px; padding-left: 5px;}
        
        #user_sub_menu{float:left; height:60px; margin-top:20px; margin-bottom:20px; border:0px solid #820628; width:100%;}
        #add_user, #delete_users{width:30px; height:30px; float:left; border-radius:100%; background:#820628; border:1px solid #820628; color:white; text-align: center; line-height: 30px; font-size: 20px; margin-left:20px; font-family:arial;}
        #delete_users {line-height:30px !important;}
        #add_user:hover, #delete_users:hover{background:white; cursor:pointer; color:#820628;}
        
        
        #footer{width:100%; height:40px; background:#820628; text-align:center; line-height:40px; margin-top:30px; color:white; float:left; border-radius:4px;}
        
        #form_container {float:left; width:400px; margin-left:30px;}
        .fieldlabel {width:120px; text-align:center; color:white; height:30px; line-height:30px; float:left; background:#820628;}
        .input_fields {width: 250px; height:30px; float:left; margin-left: 20px; margin-bottom: 10px; border:0px solid red; border-bottom:1px solid #820628; font-size: 16px;}
        #save , #close{ width:70px; float:left; text-align:center; height:30px; line-height:30px; border:1px solid #820628; background:#820628; border-radius:4px; margin-left:20px; color:white;}
        #save:hover ,#close:hover{background:white; color:#820628; cursor:pointer;}
        
        .span_label{width: 500px;
float: left;
margin-top: -30px;
margin-left: 400px;}
    </style>
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
    <script src="controlsJS/menus.js" type="text/javascript"></script>
    
</html>
        
<?php        
}
        
        ?>