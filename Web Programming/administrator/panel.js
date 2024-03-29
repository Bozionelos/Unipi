

$(document).ready(function(){
    $('#panel_users').hover(function() {
        $("#panel_users").addClass('transition');
        $("#panel_selection").html("User Management");
    }, function() {
        $("#panel_users").removeClass('transition');
        $("#panel_selection").html("");
    });
    
    $('#panel_menus').hover(function() {
        $("#panel_menus").addClass('transition');
        $("#panel_selection").html("Menu & Appearance");
    }, function() {
        $("#panel_menus").removeClass('transition');
        $("#panel_selection").html("");
    });
    
    $('#panel_articles').hover(function() {
        $("#panel_articles").addClass('transition');
        $("#panel_selection").html("Articles");
    }, function() {
        $("#panel_articles").removeClass('transition');
        $("#panel_selection").html("");
    });
    
    $('#panel_settings').hover(function() {
        $("#panel_settings").addClass('transition');
        $("#panel_selection").html("Settings");
    }, function() {
        $("#panel_settings").removeClass('transition');
        $("#panel_selection").html("");
    });
});


function load_controls(item){
    
    switch(item){
        case 1:
            var base = document.URL.split("?");
            window.location = base[0]+"?component=users";
            break;
        case 2:
            var base = document.URL.split("?");
            window.location = base[0]+"?component=menus";
            break;
        case 3:
            load_articles();
            break;
        case 4:
            load_settings();
            break;
    }
}


function load_users(){
    
}


