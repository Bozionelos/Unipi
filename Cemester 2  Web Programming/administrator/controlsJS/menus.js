
/*
 *Class Menu Item
 */

function load_menus(){
    $.ajax({
            url: menu_controller,
            type: 'POST',
            dataType: "json",
            data: {
                action:"get_menu",
            },
            complete: function(data){
                var obj = jQuery.parseJSON('[' + data.responseText + ']');
                var menus = obj[0];
             }
        });

}