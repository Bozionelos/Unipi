Element.prototype.remove = function() {
    this.parentElement.removeChild(this);
}
NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
    for(var i = 0, len = this.length; i < len; i++) {
        if(this[i] && this[i].parentElement) {
            this[i].parentElement.removeChild(this[i]);
        }
    }
}

function user_close(){
    var base = window.location.href.split( '?' );
    window.location = base[0];
}

function edit_user(id){
    var base = window.location.href.split( '?' );
    window.location = base[0]+"?component=users&user="+id;
}
var memory_username;
function display_span(span){
    switch(span.id){
        case "user_id":
            document.getElementById("spanuser_id").innerHTML = "You cannot define or change the User ID this is done automatically";
            document.getElementById("user_id").readOnly = true;
            break;
        case "username":
            document.getElementById("spanusername").innerHTML = "You can change the Username";
            memory_username = document.getElementById("username").value;
            break;
        case "password":
            document.getElementById("spanpassword").innerHTML = "You can change the password";
            break;
        case "email":
            document.getElementById("spanemail").innerHTML = "Format NAME@DOMAIN.CC where CC = Country Code";
            break;
        case "fname":
            document.getElementById("spanfname").innerHTML = "";
            break;
        case "lname":
            document.getElementById("spanlname").innerHTML = "";
            break;
        case "telephone":
            document.getElementById("spantelephone").innerHTML = "10 Digits";
            break;
        case "address":
            document.getElementById("spanaddress").innerHTML = "";
            break;
        case "token":
            document.getElementById("spantoken").innerHTML = "Tokens Used by UNIPI Android Application";
            break;
        case "block":
            document.getElementById("spanblock").innerHTML = "0 = Not Blocked | 1 = Blocked";
            break;
        default:
            document.getElementById("spantype").innerHTML = "Usergroups 1-6";
            break;
    }
}

function validate(span){
    if(span.id){
        document.getElementById("span"+span.id).innerHTML = "";
    }
    else{
        document.getElementById("spantype").innerHTML = "";  
    }
    if(span.id == "username" && document.getElementById("username").value != memory_username){
        $.ajax({
            url: "../components/users/controller/users.controller.php",
            type: 'POST',
            dataType: "json",
            data: {
                action:"get_user_username",
                username: document.getElementById("username").value,
                exclude: getUrlVars()["user"],
            },
            complete: function(data){
                var result1 = data.responseText; 
                if(result1 != 0){
                    document.getElementById("spanusername").innerHTML = "This username already exists";    
                }
            }
        });
    }
    
}

function save_user(){
    var user_id = document.getElementById("user_id").value;
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var block = document.getElementById("block").value;
    var email = document.getElementById("email").value;
    var token = document.getElementById("token").value;
    var type = document.getElementById("type").options[document.getElementById("type").selectedIndex].value.split(" --> ");
    
    var fname = document.getElementById("fname").value;
    var lname = document.getElementById("lname").value;
    var pname = document.getElementById("pname").value;
    var telephone = document.getElementById("telephone").value;
    var address = document.getElementById("address").value;
    var cemester = document.getElementById("cemester").value;
    
    
}

function complete_form(){
    $.ajax({
            url: "../components/users/controller/users.controller.php",
            type: 'POST',
            dataType: "json",
            data: {
                action:"get_user_groups",
            },
            complete: function(data){
                var result1 = data.responseText; 
                groups = new Array();
                groups = jQuery.parseJSON(data.responseText);
                
                var current_group = "none";
                if(document.getElementById("type").value){
                    current_group = document.getElementById("type").value;
                }
                
                document.getElementById("spantype").remove();
                document.getElementById("type").remove();
                console.log(groups);
                var innerHTML = '<select id="type" class="select">';
                for(var i=0;i<groups.length;i++){
                    var temp = groups[i];
                    if(temp.contains(current_group)){
                        innerHTML += '<option id="usergroup'+i+'" selected="true">'+temp+'</option>';
                    }
                    else{
                        innerHTML += '<option id="usergroup'+i+'">'+temp+'</option>';
                    }
                }
                innerHTML += '</select>';
                document.getElementById("form_container").innerHTML += innerHTML; 
            }
        });
}



function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}