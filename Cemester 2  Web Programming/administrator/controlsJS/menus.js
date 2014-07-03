
/*
 *Class Menu Item
 *
 * Available Menu Positions
 *--------------------------*
 * 1 - topmenu
 * 2 - rightmenu
 * 3 - footermenu
 * 4 - leftmenu
 */

var menus = "";
function load_menus(){
    $.ajax({
            url: menu_controller,
            type: 'POST',
            dataType: "json",
            data: {
                action:"get_menu",
            },
            complete: function(data){
                
                menu = new Array();
                menu = jQuery.parseJSON('[' + data.responseText + ']');
                menus = menu[0];
                console.log(menus);
                display_menu_tool();
             }
        });

}
function get_menu_by_type(type){
    
    var response = [];
    for(var i=0;i<menus.length;i++){
        if(menus[i]['type'] == type){
            response.push(menus[i]);   
        }
    }
    return response;
}
function display_menu_tool(){
    var innerHTML = "";
    innerHTML = '<div id="menu_tree">';
    for(var i=1;i<5;i++){
        var current = get_menu_by_type(i);
        console.log(current);
        innerHTML += '<div class="menu_ul" style="line-height: 30px; text-align: center;" draggable="true" ondragstart="drag(event)">'+get_menu_title(i)+'</div>';
        innerHTML += '<ul class="menu_list" id="'+i+'">';
        for(var j=0;j<current.length;j++){
            innerHTML += '<li id="'+current[j]['menu_id']+'">'+current[j]['title']+'</li>'; 
        }
        innerHTML += '</ul>';
    }
    document.getElementById("tools").innerHTML = innerHTML;
    
    var innerHTML2 = '<div id="site_layout"><div id="site_layout_top"></div><div id="site_layout_right"></div><div id="site_layout_footer"></div><div id="site_layout_left"></div></div>';
    document.getElementById("tools").innerHTML = innerHTML;
    reload_sortable();
    
}

function get_menu_title(i){
    switch(i){
        case 1:
            return "Top Menu";
        case 2:
            return "Right Menu";
        case 3:
            return "Footer Menu";
        case 4:
            return "Left Menu";
    }
}

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("Text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("Text");
    ev.target.appendChild(document.getElementById(data));
}

function reload_sortable(){
    $(function(){
        // Could also be ['.sort-me', '#also-sort-me']
        $('.menu_list').sortable({connectWith: '.menu_list'});
        $( ".menu_list" ).sortable({placeholder: "ui-state-highlight"});
              
    });
}