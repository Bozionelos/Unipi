<?php 

if(isset($_REQUEST['user_id'])){
    echo "we display the user information";
    
}
else{
    ?>

    <script>
        //var users_controller = "C:\xampp\htdocs\unipi\components\users\controller\controller.php";
        $.ajax({
            url: "../components/users/controller/users.controller.php",
            type: 'POST',
            dataType: "json",
            data: {
                action:"get_all_users",
            },
            complete: function(data){
                
                _users = new Array();
                _users = jQuery.parseJSON('[' + data.responseText + ']');
                users = _users[0];
                display_all_users(users);
             }
        });
        
        function display_all_users(users){
            document.getElementById("tools").innerHTML = users[0].fname;   
        }
    </script>

<?php
     
    }

?>