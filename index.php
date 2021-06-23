<?php
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Datum der Vergangenheit
header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT"); // immer geändert
header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header ("Pragma: no-cache");

session_start();
require_once("config.php");
require_once("grab.php");


//createProject('Debug Testprojekt','Open','Die ist eine Beschreibung. Sie dient dem Nutzer als Information.','');
head(); //Head stuff like html and so on
echo '  <body>' . "\n";
menu();
echo '  <div class="box">'. "\n";
//==========CONTENT============

if (isset($_REQUEST['projecttitle']) && isset($_REQUEST['projectdescription'])){
    createProject(tagConv($_REQUEST['projecttitle']),'Open',tagConv($_REQUEST['projectdescription']),'');
} elseif (isset($_REQUEST['addproject']) && trim($_REQUEST['addproject']) == '+') {
    newProject();
} elseif (isset($_REQUEST['project'])) {
    if (isset($_REQUEST['tickettitle']) && isset($_REQUEST['tickettext'])) {
        if (strlen(trim($_REQUEST['tickettitle'])) > 0 && strlen(trim($_REQUEST['tickettext'])) > 0 && strlen(trim($_REQUEST['tickettext'])) < 8193) {
            createTicket((tagConv($_REQUEST['tickettitle'])), (tagConv($_REQUEST['tickettext'])), '0', trim($_REQUEST['project']));   
            
            getProject(trim($_REQUEST['project']));
            ticketForm();
            echo '<h3 class="freeheader">Tickets</h3>';
            getTickets(trim($_REQUEST['project']));
            //die('<meta http-equiv="refresh" content = "0;url=./?project='.$_REQUEST['project'].'">');
        } else {
            error("Ticket was not created! <br> - Maximum amount of characters are 8192. <br> - Ticket cannot be empty");
        }
    } else {
        if (is_numeric(trim($_REQUEST['project']))) {
            getProject(trim($_REQUEST['project']));
            ticketForm();
            echo '<h3 class="freeheader">Tickets</h3>';
            getTickets(trim($_REQUEST['project']));
        }
    }
    
} elseif (isset($_REQUEST['edticketid']) && is_numeric($_REQUEST['edticketid'])) {
    $_COOKIE['ticketid'] = $_REQUEST['edticketid'];
    updateTicket(trim($_COOKIE['ticketid']),tagConv($_REQUEST['tickettext']),$_REQUEST['status']);
    die('<meta http-equiv="refresh" content="0; url=./?project='.getTicketAssignedTo($_COOKIE['ticketid']).'" />');  
    
} elseif (isset($_REQUEST['edprojectid']) && is_numeric($_REQUEST['edprojectid'])) {
    $_COOKIE['projectid'] = $_REQUEST['edprojectid'];
    updateProject(trim($_COOKIE['projectid']),tagConv($_REQUEST['projecttext']),$_REQUEST['status']);
    die('<meta http-equiv="refresh" content="0; url=./?project='.($_COOKIE['projectid']).'" />');
    
} elseif (isset($_REQUEST['editticket']) && is_numeric($_REQUEST['editticket'])) {
    $_COOKIE['ticketid'] = $_REQUEST['editticket'];
    getProject(getTicketAssignedTo($_COOKIE['ticketid']));
    editTicket(trim($_COOKIE['ticketid']));
       
} elseif (isset($_REQUEST['editproject']) && is_numeric($_REQUEST['editproject'])) {
    $_COOKIE['projectid'] = $_REQUEST['editproject'];
    editProject(trim($_COOKIE['projectid']));
    
} elseif (isset($_REQUEST['help'])) {
    help();
} else {
    $_COOKIE['ticketid'] = '';
    listProjects();
}



//echo tagConv("[time]");
//echo button("test","index.php?project=9");
//echo container();
//createTicket('Test Ticket','Das ist ein Testticket.',0,0);
//getTickets();
//==========CONTENT============
echo "\n" . '  </div></body>' . "\n";
echo '</html>' . "\n";

