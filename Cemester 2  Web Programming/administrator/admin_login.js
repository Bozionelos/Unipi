    var window_w = $( window ).width();
    var window_h = $( window ).height();
    var animate = $( window ).width()/2;
    $("#door_left").width(window_w/2);
    $("#door_right").width(window_w/2);
    $("#door_left").height(window_h);
    $("#door_right").height(window_h);
    
    $("body").width(window_w-40);
    document.getElementById("form_container").style.marginLeft = ($( window ).width()-324)/2+"px";
    document.getElementById("form_container").style.marginTop = ($( window ).height()-200)/2+"px";
    
    var login_controller = "../components/login/controllers/login_controller.php";
    
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
       
        
        $.ajax({
            url: login_controller,
            type: 'POST',
            dataType: "json",
            data: {
                action:"admin_login",
                username: username,
                password: unhashed_pass,
            },
            complete: function(data){
                if(data.responseText.indexOf("deny") == -1){
                    $( "#form_container" ).hide( "slow", function() {
                         $( "#door_left" ).animate({
                             opacity: 0.25,
                             left: -animate,
                         }, 2000, function() {
                              // Animation complete.
                         });
                        
                         $( "#door_right" ).animate({
                             opacity: 0.25,
                             right: -animate,
                         }, 2000, function() {
                              window.location = "panel.php";   
                         });
                    
                        });
                }
            }
        });

    }
