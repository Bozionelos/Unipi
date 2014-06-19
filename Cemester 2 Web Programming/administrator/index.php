<!-- #820628  -->
<!-- #002E52  -->
<html>
    <head>
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <meta content="utf-8" http-equiv="encoding">
    <style>
        body{ 

height:100%;
background-image: -ms-linear-gradient(top, #820628 0%, #002E52 100%);

/* Mozilla Firefox */ 
background-image: -moz-linear-gradient(top, #820628 0%, #002E52 100%);

/* Opera */ 
background-image: -o-linear-gradient(top, #820628 0%, #002E52 100%);

/* Webkit (Safari/Chrome 10) */ 
background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #820628), color-stop(1, #002E52));

/* Webkit (Chrome 11+) */ 
background-image: -webkit-linear-gradient(top, #820628 0%, #002E52 100%);

/* W3C Markup, IE10 Release Preview */ 
background-image: linear-gradient(to bottom, #820628 0%, #002E52 100%); 
        
background-repeat: no-repeat;
        }   
        .form_container{margin-top:300px; width:300px; height:200px; border-radius:4px; border:4px solid white; background:transparent; color:white;}
        .form_label{float:left; font-weight:bold; font-family:arial; width:100px; color:white; margin-bottom:10px;}
        .logo{float:left; width:300px; height:60px; margin-bottom:10px; margin-top:20px;}
        .logo img{margin-left:125px;}
        .form_row{padding-left:10px; width:100%; height:30px; float:left;}
        .label{width:100%; color:white; text-align:center; margin-top:20px;height: 30px; float: left;}
        .label:hover{text-decoration:underline; cursor:pointer;}
    </style>
    
    </head>
    <body>
    
        <div class="form_container" id="form_container">
        <div class="logo"><img border="0" src="http://newsletter.xrh.unipi.gr/logo.png" alt="Pulpit rock" width="50" height="60"></div>
        <form method="POST">
            <div class="form_row"><div class="form_label">Username: </div><input name="username" type="text" width="200" placeholder="Type Username" id="user" value=""></div>
            <div class="form_row"><div class="form_label">Password: </div><input name="password" type="password" width="200" placeholder="" id="pass" value=""></div>
            <div class="label">Forgot your Password?</div>
        </form>
        </div>
    
    </body>
    <script src="http://code.jquery.com/jquery-1.9.0.js" type="text/javascript"></script>
    <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>
    <script src="../shared/shared_controlls.js" type="text/javascript"></script>
    <script src="admin_login.js" type="text/javascript"></script>
   
    </html>