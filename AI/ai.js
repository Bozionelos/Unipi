var selected_tool = "";
var field_height = 0;
var field_width = 0;
var solved = false;
var allexpanded = false;
var not_fully_expanded_node;
Array.prototype.remove = function(from, to) {
    var rest = this.slice((to || from) + 1 || this.length);
    this.length = from < 0 ? this.length + from : from;
    return this.push.apply(this, rest);
};


function create_field(){
    var x = document.getElementById("height").value;
    field_height = x;
    var y = document.getElementById("width").value;
    field_width = y;
    innerhtml = '<table class="field_table">';
    for(var i=0;i<x;i++){
        innerhtml += '<tr>';
        for(var j=0;j<y;j++){
            innerhtml += '<td class="field_cell" x='+i+' y='+j+' id='+((i*field_width)+j)+' onclick="draw_cell(this)"></td>';
        }
        innerhtml += '</tr>'
    }
    innerhtml += '</table>';
    document.getElementById("field").innerHTML = innerhtml;
}
        
function select_tool(el){
    $(".selected").removeClass("selected");
    var id = el.id;
    $("#"+id).addClass("selected");
    selected_tool = el.id;
}

function draw_cell(data){
    switch(selected_tool){
        case "wall":
            var tempwall = new point(data.getAttribute("x"), data.getAttribute("y"));
            data.style.background = "#808080";
            add_wall(tempwall);
            break;
        case "start":
            if(start.x == -1){
                data.style.background = "green";
                current_start_element = data;
                start = new point(data.getAttribute("x"), data.getAttribute("y"));
            }
            else{
                current_start_element.style.background = "ghostwhite";
                start = new point(data.getAttribute("x"), data.getAttribute("y"));
                data.style.background = "green";
                current_start_element = data;
            }
            break;
        case "end":
            if(end.x == -1){
                data.style.background = "red";
                current_end_element = data;
                end = new point(data.getAttribute("x"), data.getAttribute("y"));
            }
            else{
                current_end_element.style.background = "ghostwhite";
                end = new point(data.getAttribute("x"), data.getAttribute("y"));
                data.style.background = "red";
                current_end_element = data;
            }
            break;
        case "reset":
            var tempwall = new point(data.getAttribute("x"), data.getAttribute("y"));
            data.style.background = "ghostwhite";
            remove_wall(tempwall);
            break;
        
    }
    console.log(start);
    console.log(end);
    console.log(walls);
}


// Wall Object Array
var walls = [];

//Add a wall
function add_wall(wall){
    for(var i=0;i<walls.length;i++){
        var current_wall = walls[i];
        if(current_wall.x == wall.x && current_wall.y == wall.y){
            return false;  
        }
    }
    walls.push(wall); 
}

//Remove a wall
function remove_wall(wall){
    for(var i=0;i<walls.length;i++){
        var current_wall = walls[i];
        if(current_wall.x == wall.x && current_wall.y == wall.y){
            walls.remove(i,i);   
        }
    }
}

function point(x, y){
    this.x=x;
    this.y=y;
}

var start = new point(-1,-1);
var current_start_element;

var end = new point(-1,-1);
var current_end_element;

function validate_number(el){
        var myvalue = document.getElementById(el.id).value;
        if (isNaN(myvalue)){
            alert("Must input numbers");
            return false;
        }
    }

var visited_list = [];
var to_explore = [];
var visit_counter = 0;

function visited(point){
    visited_list.push(point);
}

function is_same_point(point1, point2){
    if(point1.x == point2.x && point1.y == point2.y){
        return true;   
    }
    return false;
}

function can_move(_point, direction){
    switch(direction){
        case "top":
            if(parseInt(_point.x) - 1 >= 0 && !isWall(_point.x - 1,_point.y)){
                return (new point(_point.x - 1,_point.y));
            }
            else{
                return false;   
            }
        case "right":
            if(parseInt(_point.y+1) < field_height && !isWall(_point.x,_point.y+1))
                return (new point(_point.x,_point.y+1));
        case "left":
            if(parseInt(_point.y-1) >= 0 && !isWall(_point.x,_point.y - 1))
                return (new point(_point.x,_point.y - 1));
        case "bottom":
            if(parseInt(_point.y+1) < field_height && !isWall(_point.x,_point.y+1))
                return (new point(_point.x,_point.y+1));
    }
    return false;
}


function isWall(x,y){
    var temppoint = new point(x,y);
    for(var i=0;i<walls.length;i++){
        var tempwall = walls[i];
        if(is_same_point(temppoint,tempwall)){
            return true;
        }
    }
    return false;
}



function paint_point(point){
    var id = ((parseInt(point.x)*field_height)+parseInt(point.y));
    //var el = document.getElementById(id).style.background = "yellow";
     $( "#"+id ).animate({
         backgroundColor: "yellow",
     }, 1000, function() {
         DFS_expand_node(point);
     });
}


function DFS_expand_node(point){
    var result = can_move(point,"top");
    console.log(result.x+"  "+result.y);
    if(result){
        if(is_same_point(result,end)){
           alert("OK"); 
        }
        else{
        paint_point(result); 
        
        }
    }
}



function check_all_set(){
    if(start.x == -1 || start.y == -1 || end.x == -1 || end.y == -1){
        
        return false;   
    }
    return true;
}

function solve1(){
    if(check_all_set()){
        not_fully_expanded_node = start;
        DFS_expand_node(start);
       
            
        
        
    }
}