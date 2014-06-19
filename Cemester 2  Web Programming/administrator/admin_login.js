    var admin_controller = "admin_controller.php";
    document.getElementById("form_container").style.marginLeft = (($(window).width()/2)-200)+"px";
    $("#user").keypress(function(e) {
        if(e.which == 13) {
            submit();
        }
    });
    $("#pass").keypress(function(e) {
        if(e.which == 13) {
            submit();
        }
    });

    function submit(){
        var username = document.getElementById("user").value;
        var unhashed_pass = document.getElementById("pass").value;
        //console.log(CryptoJS.MD5(unhashed_pass));
        
        $.ajax({
            url: admin_controller,
            type: 'POST',
            dataType: "json",
            data: {
                action:"admin_login",
                username: username,
                password: unhashed_pass,
            },
            complete: function(data){
                if(data.responseText.indexOf("deny") == -1){
                    register_session(data.responseText);
                    //window.location = "control.php";   
                }
            }
        });

    }
