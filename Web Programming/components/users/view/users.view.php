<script src="http://83.212.102.33/unipi/components/users/view/users.lib.js"></script>
<script>
    
    $("#tools").css("border","1px solid #820628");

</script>

<?php 
/*
 * In MVC (Model View Controller) Architecture the view is the User Interface. We have divided this component
 * in three operations View All/ View Specific/ Add New
 *----------------------------------------------------------------------------------------------------------*
 * Add new:
 * GET Parameters ?component=user&user=new
 * Reads the user.xml and forms an empty form
 */
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
                innerHTML += '<div id="add_user" onclick="new_user()">New</div>'+
                        '<div id="delete_users" onclick="delete_selected()">Delete</div>'+
                        '<div id="save" onclick="save_user()">Save</div>'+
                        '<div id="close" onclick="user_close()">Close</div></div><div id="form_container">';
                        for(var i =0; i<fieldset.length;i++){
                            var field = fieldset[i];
                            innerHTML += '<div class="fieldlabel">'+field.getAttribute("name")+
                            '</div><input class="input_fields" type="'+field.getAttribute("type")+
                            '" id="'+field.getAttribute("id")+'" value="'+
                            '" onclick="display_span('+field.getAttribute("id")+')"'+
                            'onblur="validate('+field.getAttribute("id")+')"/>'+
                            '<div id="span'+field.getAttribute("id")+'" class="span_label"></div>'+
                            '<br>';
                        }
                        document.getElementById("tools").innerHTML = innerHTML+'</div>';
                        complete_form();
             }
        });
        </script>
        <?php
    }
    else{
        /*
         * Add new:
         * GET Parameters ?component=user&user=#USER_ID
         * Reads the user.xml and fills the form with the user data from the database
         */
        
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
                             innerHTML += '<div id="add_user" onclick="new_user()">New</div>'+
                                 '<div id="delete_users" onclick="delete_selected()">Delete</div>'+
                                 '<div id="save" onclick="save_user()">Save</div>'+
                                 '<div id="close" onclick="user_close()">Close</div></div><div id="form_container">';
                             for(var i =0; i<fieldset.length;i++){
                                 var field = fieldset[i];
                                 innerHTML += '<div class="fieldlabel">'+field.getAttribute("name")+
                                     '</div><input class="input_fields" type="'+field.getAttribute("type")+
                                     '" id="'+field.getAttribute("id")+'" value="'+selected[field.getAttribute("id")]+
                                     '" onclick="display_span('+field.getAttribute("id")+')"'+
                                     'onblur="validate('+field.getAttribute("id")+')"/>'+
                                     '<div id="span'+field.getAttribute("id")+'" class="span_label"></div>'+
                                 '<br>';
                             }
                             document.getElementById("tools").innerHTML = innerHTML+'</div>';
                             complete_form();
                         }
                     });
                 }
             });
            
            
        
            
        </script>
        <?php
    }
    
}
else{
    /*
     * Get All Users:
     * GET Parameters ?component=user
     * Gets all the users from the DB and fills a table. Clicking on a user redirects to view specific user
     */
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
            innerHTML += '<div id="add_user" onclick="new_user()">New</div>'+
                '<div id="delete_users" onclick="delete_selected()">Delete</div></div>';
            innerHTML += '<table id="users"><tr><th>Select</th><th>User Id</th><th>Username</th><th>First Name</th><th>Last Name</th><th>E-Mail</th></tr>';
            for(var i=0;i<users.length;i++){
                var temp_user = users[i];
                innerHTML += '<tr><td style="text-align: center;"><input type="checkbox" onchange="select_user('+temp_user.user_id+')"></td>'+ 
                             '<td class="selector" onclick="edit_user('+(temp_user.user_id)+')">'+temp_user.user_id+'</td>'+
                             '<td>'+temp_user.username+'</td>'+ 
                             '<td>'+temp_user.fname+'</td>'+ 
                             '<td>'+temp_user.lname+'</td>'+ 
                             '<td>'+temp_user.email+'</td>'+ 
                             '</tr>';   
            }
            innerHTML += '</table>';
            document.getElementById("tools").innerHTML = innerHTML;   
        }
    </script>

<?php
     
    }

?>


