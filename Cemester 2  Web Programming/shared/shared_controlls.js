
    var session_handler = "../shared/session_handler.php";
    function register_session(user_id){
    $.ajax({
        url: session_handler,
            type: 'POST',
            dataType: "json",
            data: {
                action:"set_session",
                user_id: user_id,
            },
            complete: function(data){
                console.log(data.responseText);
            }
    });
}