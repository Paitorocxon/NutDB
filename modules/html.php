<?php

function head(){
$css = 'original.css';
    echo '<!DOCTYPE html>' . "\n";
    echo '<html>' . "\n";
    echo '  <head>' . "\n";
    echo '      <link rel="stylesheet" href="style/'.$css.'">' . "\n";
    echo '      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>' . "\n";
    echo '      <script src="js/dr.js"></script>' . "\n";
    echo '      <title>🥜 NutDB - Small Project Documentation Tool</title>' . "\n";
    echo '      ' . "\n";
    echo '      ' . "\n";
    echo '      ' . "\n";
    echo '      ' . "\n";
    echo '      ' . "\n";
    echo '      ' . "\n";
    echo '      ' . "\n";
    echo '  </head>' . "\n"; 
}
function error($string) {
    die('      <div class="error">'.$string.'</div>'."\n" . '  </body>' . "\n" . '</html>' . "\n");
    
}

function menu() {
    echo '<div class="menu"><img src="style/ico.png" height=64px><div class="menu_text"><a href="./">🏘️ Home</a>  <form method="POST" style="display: inline;"><button value="+" name="addproject">➕ Create a Project</button></form> <a href="?help">❔ Help</a></div></div>' . "\n";
}

function button($text,$link) {
    return '<button value="'.$text.'" onclick="loader(\''.$link.'\')">'.$text.'</button>';
}

function container() {
    echo '<div class="container" id="container"></div>';
}

function contentByID($id) {
    
}

function ticket($title,$content) {
    $content = (($content));
    return '<div class="ticket"><div class="ticket_title">'.$title.'</div><div class="text">'.$content.'</div></div>';
    //return '<div class="ticket"><div class="ticket_title">'.$title.'</div><div class="text">'.tagDeconv($content).'</div></div>';
}
function closedticket($title,$content) {
    $content = (($content));
    return '<div class="closed_ticket"><div class="closed_ticket_title">'.$title.'</div><div class="closed_text">'.$content.'</div></div>';
    //return '<div class="ticket"><div class="ticket_title">'.$title.'</div><div class="text">'.tagDeconv($content).'</div></div>';
}
function project($title,$content) {
    $content = (($content));
    return '<div class="project"><div class="project_title">'.$title.'</div><div class="text">'.$content.'</div></div>';
}

function newProject() {
    echo '<div class="ticket_form">' . "\n";
    echo '<div class="ticket_form_title">Create Project</div>' . "\n";
    echo '<form method="POST">' . "\n";
    echo '<table>' . "\n";
    echo '<tr>' . "\n";
    echo '<td>Title:</td> <td><input id="input" name="projecttitle" type="text" placeholder="Title" /></td>' . "\n";
    echo '</tr>' . "\n";
    echo '<tr>' . "\n";
    echo '<td>Description:</td> <td><textarea id="input" class="tickettext" name="projectdescription" placeholder="Description."></textarea></td>' . "\n";
    echo '</tr>' . "\n";
    echo '<tr><td>' . "\n";
    echo '<input type="submit" class="button" value="Send"/>' . "\n";
    echo '</td></tr>' . "\n";
    echo '</table>' . "\n";
    echo '</form>' . "\n";
    echo '</div>' . "\n";
}

function ticketForm() {
    echo '<div class="ticket_form">' . "\n";
    echo '<div class="ticket_form_title">Create Ticket</div>' . "\n";
    echo '<form method="POST">' . "\n";
    echo '<table>' . "\n";
    echo '<tr>' . "\n";
    echo '<td>Title:</td> <td><input id="input" name="tickettitle" type="text" placeholder="Title" /></td>' . "\n";
    echo '</tr>' . "\n";
    echo '<tr>' . "\n";
    echo '<td>Issue Description:</td> <td><textarea id="input" name="tickettext" placeholder="Please descripe your issue."></textarea></td>' . "\n";
    echo '</tr>' . "\n";
    echo '<tr><td>' . "\n";
    echo '<input type="submit" class="button" value="Send"/>' . "\n";
    echo '</td></tr>' . "\n";
    echo '</table>' . "\n";
    echo '</form>' . "\n";
    echo '</div>' . "\n";
}


function editTicket($id) {
    echo '<div class="ticket_form">' . "\n";
    echo '<div class="ticket_form_title">Edit Ticket</div>' . "\n";
    echo '<form method="POST">' . "\n";
    echo '<table>' . "\n";
    echo '<input type="hidden" name="edticketid" value="'.$id.'">' . "\n";
    echo '<tr>' . "\n";
    echo '<td>Title:</td> <td> <sub>#'.htmlspecialchars($id).'</sub> "'.getTicketTitle($id).'"</td>' . "\n";
    echo '</tr>' . "\n";
    echo '<tr>' . "\n";
    echo '<td>Status:</td> <td><select name="status" id="statusselect"><option name="Open">Open</option><option name="Solved">Closed</option><option name="Edited">Edited</option><option name="Hidden">Hidden</option></select></td>' . "\n";
    echo '</tr>' . "\n";
    echo '<tr>' . "\n";
    echo '<td>Issue Description:</td> <td><textarea id="input" name="tickettext" style="height: 200px;" placeholder="Please descripe your issue.">'.tagDeconv(getTicketText($id)).'</textarea></td>' . "\n";
    echo '</tr>' . "\n";
    echo '<tr>' . "\n";
    echo '<td>' . "\n";
    echo '<input type="submit" class="button" value="Update"/>' . "\n";
    echo '</td>' . "\n";
    echo '</tr>' . "\n";
    echo '</table>' . "\n";
    echo '</form>' . "\n";
    echo '</div>' . "\n";
    
}

function editProject($id) {
    echo '<div class="ticket_form">' . "\n";
    echo '<div class="ticket_form_title">Edit Project</div>' . "\n";
    echo '<form method="POST">' . "\n";
    echo '<table>' . "\n";
    echo '<input type="hidden" name="edprojectid" value="'.$id.'">' . "\n";
    echo '<tr>' . "\n";
    echo '<td>Title:</td> <td> <sub>#'.htmlspecialchars($id).'</sub> "'.getProjectTitle($id).'"</td>' . "\n";
    echo '</tr>' . "\n";
    echo '<tr>' . "\n";
    echo '<td>Status:</td> <td><select name="status" id="statusselect"><option name="Open">Open</option><option name="Solved">Closed</option><option name="Edited">Edited</option><option name="Hidden">Hidden</option></select></td>' . "\n";
    echo '</tr>' . "\n";
    echo '<tr>' . "\n";
    echo '<td>Text:</td> <td><textarea id="input" name="projecttext" style="height: 200px;" placeholder="Please descripe your issue.">'.tagDeconv(getProjectText($id)).'</textarea></td>' . "\n";
    echo '</tr>' . "\n";
    echo '<tr>' . "\n";
    echo '<td>' . "\n";
    echo '<input type="submit" class="button" value="Update"/>' . "\n";
    echo '</td>' . "\n";
    echo '</tr>' . "\n";
    echo '</table>' . "\n";
    echo '</form>' . "\n";
    echo '</div>' . "\n";
    
}



function help() {
    echo '<div class="ticket_form">' . "\n";
    echo '<div class="ticket_form_title">Help</div>' . "\n";
    echo '' . "\n";
    echo '' . "\n";
    echo '' . "\n";
    echo '' . "\n";
    echo '' . "\n";
    echo '</div>' . "\n";
}