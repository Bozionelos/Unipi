<script>
$("#tools").css("border","1px solid #820628");
</script>

<?php 

if(isset($_REQUEST['user'])){
    if($_REQUEST['user'] == "new"){
        ?>
        <script>
           $.ajax({
            url: "../components/users/controller/users.controller.php",
            type: 'POST',
            dataType: "json",
            data: {
                action:"get_xml",
            },
            complete: function(data){
                var result1 = data.responseText;
                //alert("Result 1 ="+result1);
                if (window.DOMParser){
                    parser=new DOMParser();
                    xmlDoc=parser.parseFromString(result1,"text/xml");
                }
                else{
                    xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
                    xmlDoc.async=false;
                    xmlDoc.loadXML(result1);
                }
                var fields = xmlDoc.getElementsByTagName("fields");
                var fieldset = fields[0].getElementsByTagName("field");
                var innerHTML = '<div id="user_sub_menu">';
                innerHTML += '<div id="add_user" onclick="new_user()">+</div>'+
                '<div id="delete_users" onclick="delete_selected()">x</div>'+
                '<div id="save" onclick="save_new()">Save</div>'+'</div><div id="form_container">';
                
                for(var i =0; i<fieldset.length;i++){
                    var field = fieldset[i];
                    innerHTML += '<div class="fieldlabel">'+field.getAttribute("name")+'</div><input class="input_fields" type='+field.getAttribute("type")+' id='+field.getAttribute("id")+''+'/><br>';
                }
                document.getElementById("tools").innerHTML = innerHTML+'</div>';
             }
        });
        </script>
        <?php
    }
    else{
        ?>
        <script>
            var _user_id = <?php echo '"'.$_REQUEST['user'].'"'; ?>;
             $.ajax({
                 url: "../components/users/controller/users.controller.php",
                 type: 'POST',
                 dataType: "json",
                 data: {
                     action:"get_user",
                     user_id: _user_id,
                 },
                 complete: function(data){
                     _users = new Array();
                     _users = jQuery.parseJSON('[' + data.responseText + ']');
                     user = _users[0];
                     var selected = user[0];
                     console.log(selected);
                     $.ajax({
                         url: "../components/users/controller/users.controller.php",
                         type: 'POST',
                         dataType: "json",
                         data: {
                             action:"get_xml",
                         },
                         complete: function(data){
                             var result1 = data.responseText;
                             //alert("Result 1 ="+result1);
                             if (window.DOMParser){
                                 parser=new DOMParser();
                                 xmlDoc=parser.parseFromString(result1,"text/xml");
                             }
                             else{
                                 xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
                                 xmlDoc.async=false;
                                 xmlDoc.loadXML(result1);
                             }
                             var fields = xmlDoc.getElementsByTagName("fields");
                             var fieldset = fields[0].getElementsByTagName("field");
                             var innerHTML = '<div id="user_sub_menu">';
                             innerHTML += '<div id="add_user" onclick="new_user()">+</div>'+
                                 '<div id="delete_users" onclick="delete_selected()">x</div>'+
                                 '<div id="save" onclick="save_new()">Save</div>'+'</div><div id="form_container">';
                             for(var i =0; i<fieldset.length;i++){
                                 var field = fieldset[i];
                                 innerHTML += '<div class="fieldlabel">'+field.getAttribute("name")+
                                     '</div><input class="input_fields" type="'+field.getAttribute("type")+
                                     '" id="'+field.getAttribute("id")+'" value="'+selected[field.getAttribute("id")]+'"/><br>';
                             }
                             document.getElementById("tools").innerHTML = innerHTML+'</div>';
                         }
                     });
                 }
             });
        </script>
        <?php
    }
    
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
            var innerHTML = '<div id="user_sub_menu">';
            innerHTML += '<div id="add_user" onclick="new_user()">+</div>'+
                '<div id="delete_users" onclick="delete_selected()">x</div></div>';
            innerHTML += '<table id="users"><tr><th>Select</th><th>User Id</th><th>Username</th><th>First Name</th><th>Last Name</th><th>E-Mail</th></tr>';
            for(var i=0;i<users.length;i++){
                var temp_user = users[i];
                innerHTML += '<tr><td style="text-align: center;"><input type="checkbox" onchange="select_user('+temp_user.user_id+')"></td>'+ 
                             '<td>'+temp_user.user_id+'</td>'+
                             '<td>'+temp_user.username+'</td>'+ 
                             '<td>'+temp_user.fname+'</td>'+ 
                             '<td>'+temp_user.lname+'</td>'+ 
                             '<td>'+temp_user.email+'</td>'+ 
                             '</tr>';   
            }
            innerHTML += '</table>';
            document.getElementById("tools").innerHTML = innerHTML;   
        }
        
        function select_user(id){
            alert(id);   
        }
        
        function new_user(){
            var base = window.location.href.split( '?' );
            window.location = base[0]+'?component=users&user=new';   
        }
    </script>

<?php
     
    }

?>

