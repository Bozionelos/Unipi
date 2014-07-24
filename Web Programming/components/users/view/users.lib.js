
    var allfields;
 $.ajax({
     url: "../components/users/controller/users.controller.php",
    type: 'POST',
    dataType: "json",
    data: {
        action:"get_xml",
    },
    complete: function(data){
    var result1 = data.responseText;
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
        allfields = fieldset;
    }
 });

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
    for(i=0;i<allfields.length;i++){
        var field = allfields[i];
        if(field.getAttribute("id") == span.id){
            if(field.hasAttribute("span")){
                document.getElementById("span"+span.id).innerHTML = field.getAttribute("span"); 
                return 0;
            }
        }
    }
}

function validate(span){

    if(span.id){
        document.getElementById("span"+span.id).innerHTML = "";
    }
    else{
        document.getElementById("spantype").innerHTML = "";  
    }
    if(span.id == "username" && document.getElementById("username").value != memory_username && document.getElementById("username").value != ""){
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
    for(i=0;i<allfields.length;i++){
        var field = allfields[i];
        if(field.getAttribute("id") == span.id){
            if(field.getAttribute("empty") == "false"){
                if(document.getElementById(span.id).value == ""){
                    document.getElementById("span"+span.id).innerHTML = "Cannot Leave this field black";    
                }
            }
        }
    }
    
}

function save_user(){
        
    var user_id = document.getElementById("user_id").value;
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var block = document.getElementById("block").value;
    var email = document.getElementById("email").value;
    var token = document.getElementById("token").value;
    if(document.getElementById("type").selectedIndex){
        var type = document.getElementById("type").options[document.getElementById("type").selectedIndex].value.split(" --> ");
    }else{
        var type = "1";   
    }
    
    var fname = document.getElementById("fname").value;
    var lname = document.getElementById("lname").value;
    var pname = document.getElementById("pname").value;
    var telephone = document.getElementById("telephone").value;
    var address = document.getElementById("address").value;
    var cemester = document.getElementById("cemester").value;
    
    if(!username || !password || !block || !email || !fname || !lname){
        var inputs = document.getElementsByTagName("input");
        for(var i=0;i<inputs.length;i++){
            validate(inputs[i]);   
        }
    }
    else{
        if(block != "0" && block != "1"){
            document.getElementById("spanblock").innerHTML = "Wrong input";   
        }
        else if(!validateEmail(email)){
            document.getElementById("spanemail").innerHTML = "Wrong format";   
        }
        else{
            $.ajax({
                url: "../components/users/controller/users.controller.php",
                type: 'POST',
                dataType: "json",
                data: {
                    action:"save_user",
                    user_id : user_id,
                    username : username,
                    password: password,
                    block: block,
                    email: email,
                    token: token,
                    type: type,
                    fname: fname,
                    lname: lname,
                    pname: pname,
                    telephone: telephone,
                    address: address,
                    cemester : cemester,
                },
                complete: function(data){
                    var result1 = data.responseText; 
                    
                }
            });
        }
    }
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

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}