<?php



?>

<html>

<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">  
    <link rel="stylesheet" type="text/css" href="ai.css">
</head>
<body>
    <div class="ai_header">Artificial Intelligence University of Piraeus - 2014</div>
    <div class="ai_setup">
        <div class="label">dimensions:</div>
        Height:<input type=text id="height" onblur="validate_number(this)" class="textbox"/>
        Width:<input type=text id="width" onblur="validate_number(this)" class="textbox"/>
        <div class="button" onclick="create_field()">Create</div>
    </div>
    <div class="field" id="field"></div>
    <div class="field_tools" id="field_tools">
    <table>
        <tr><td colspan="4"><div class="tool_cell_description head_tool">Tools</div></td></tr>  
        
        <tr><td><div id="wall" class="tool_cell" onclick="select_tool(this)"></div></td> 
        <td><div id="start" class="tool_cell" onclick="select_tool(this)"></div></td>  
        <td><div id="end" class="tool_cell" onclick="select_tool(this)"></div></td>   
        <td><div id="reset" class="tool_cell" onclick="select_tool(this)"></div></td></tr>  
        
        <tr><td><div class="tool_cell_description">Wall</div></td>  
        <td><div class="tool_cell_description">Start</div></td>
        <td><div class="tool_cell_description">Stop</div></td>
        <td><div class="tool_cell_description">Erase</div></td></tr> 
    </table>
    </div>
    <div class="solutions">
    <div id="DFS" class="algo" onclick="solve1()">Depth First Search</div>
    <div id="BFS" class="algo" onclick="solve2()">Breadth First Search</div>
    <div id="A" class="algo" onclick="solve3()">A*</div>
    </div>
    
</body>
    <script src="http://code.jquery.com/jquery-1.9.0.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="ai.js" type="text/javascript"></script>
</html>