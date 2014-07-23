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
    console.log(span.id);
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

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}