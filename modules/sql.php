<?php
/*

    CREATE DATABASE `$db`;
    CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
    GRANT ALL ON `$db`.* TO '$user'@'localhost';
    FLUSH PRIVILEGES;
    CREATE TABLE `NutDB_Projects` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `projectname` VARCHAR(64) NOT NULL,
    `status` VARCHAR(32) DEFAULT NULL,
    `comments` TEXT NOT NULL DEFAULT '',
    `collaborates` TEXT(4096) DEFAULT '',
    `assignedtickets` TEXT(4096) DEFAULT '',
    PRIMARY KEY (`id`)
    );
    ===========================================================
    CREATE TABLE `NutDB_User` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(32) NOT NULL,
    `password` TEXT NOT NULL,
    `email` VARCHAR NOT NULL,
    `allow_being_emailed` BOOLEAN NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`)
    );
    ===========================================================
    CREATE TABLE `NutDB_Tickets` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `text` TEXT NOT NULL,
    `comments` TEXT NOT NULL,
    `status` VARCHAR,
    PRIMARY KEY (`id`)
    );
*/



function createTicket ($title, $text, $createdby, $assignedto){
    
    if (strtolower(getProjectStatus($assignedto)) == 'closed') {
        error('This Project is closed. You cannot change or update any comments and/or tickets.');
        die('<meta http-equiv="refresh" content="0; url=./" />');
    }elseif (strtolower(getProjectStatus($assignedto)) == 'hidden') {
        error('404');
    }
    
    
    $conn = new mysqli('localhost', $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    // Check connection
    if ($conn->connect_error) {
      error("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO NutDB_Tickets (title, text, comments, status, createdby, assignedto) VALUES ('".$title."','".$text."', '', 'Open','".$createdby."','".$assignedto."')";

    if ($conn->query($sql) === TRUE) {
    } else {
      error("Error: " . $sql . "<br>" . $conn->error);
    }

    $conn->close();
}

function updateTicket($id,$text,$status) {
    
    if (strtolower(getProjectStatus(getTicketAssignedTo($id))) == 'closed') {
        error('This Project is closed. You cannot change or update any comments and/or tickets.');
        die('<meta http-equiv="refresh" content="0; url=./" />');
    }elseif (strtolower(getProjectStatus(getTicketAssignedTo($id))) == 'hidden') {
        die('<meta http-equiv="refresh" content="0; url=./" />');
    }
    $conn = new mysqli('localhost', $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if ($conn->connect_error) {
      error("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE NutDB_Tickets SET text='".$text."',status='".$status."' WHERE id=".$id;

    if ($conn->query($sql) === TRUE) {
    } else {
      error("Error updating record: " . $conn->error);
    }

    $conn->close();
    
}
function updateProject($id,$text,$status) {
    
        
    $conn = new mysqli('localhost', $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if ($conn->connect_error) {
      error("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE NutDB_Projects SET description='".$text."',status='".$status."' WHERE id=".$id;

    if ($conn->query($sql) === TRUE) {
    } else {
      error("Error updating record: " . $conn->error);
    }

    $conn->close();
    
}

function getTickets($id) {
    $conn = new mysqli('localhost', $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    // Check connection
    if ($conn->connect_error) {
        error("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, comments, title, status, text FROM NutDB_Tickets WHERE assignedto=".$id;
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if (strtolower($row['status']) == 'hidden') {
            } elseif (strtolower($row['status']) == 'closed') {
                echo closedticket('<span class="idtitle">✔️<a href="?editticket='.$row['id'].'">✏️</a>#'.$row['id'].'</span> <strike>'.$row['title']. '</strike> [' . $row['status'].']', $row['text']);
            } else {
                echo ticket('<span class="idtitle"><a href="?editticket='.$row['id'].'">✏️</a>#'.$row['id'].'</span> '.$row['title']. '  [' . $row['status'] . ']', $row['text']);
            }
                
        }
    } else {
        echo '<div class="freeheader">No Tickets</div>';
    } 
    $conn->close();
}

function getTicketTitle($id) {
    $conn = new mysqli('localhost', $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    // Check connection
    if ($conn->connect_error) {
        error("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT title FROM NutDB_Tickets WHERE id=".$id;
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row['title'];
        }
    } else {
        return 'NO TICKET!';
    } 
    $conn->close();
}

function getTicketText($id) {
    $conn = new mysqli('localhost', $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    // Check connection
    if ($conn->connect_error) {
        error("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT text FROM NutDB_Tickets WHERE id=".$id;
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row['text'];
        }
    } else {
        return 'NO TICKET!';
    } 
    $conn->close();
}
function getTicketStatus($id) {
    $conn = new mysqli('localhost', $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    // Check connection
    if ($conn->connect_error) {
        error("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT status FROM NutDB_Tickets WHERE id=".$id;
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row['status'];
        }
    } else {
        return 'NO TICKET!';
    } 
    $conn->close();
}
function getTicketComments($id) {
    $conn = new mysqli('localhost', $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    // Check connection
    if ($conn->connect_error) {
        error("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT comments FROM NutDB_Tickets WHERE id=".$id;
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row['comments'];
        }
    } else {
        return 'NO TICKET!';
    } 
    $conn->close();
}
function getTicketAssignedTo($id) {
    $conn = new mysqli('localhost', $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    // Check connection
    if ($conn->connect_error) {
        error("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT assignedto FROM NutDB_Tickets WHERE id=".$id;
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row['assignedto'];
        }
    } else {
        return '0';
    } 
    $conn->close();
}


function getProjectTitle($id) {
    $conn = new mysqli('localhost', $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    // Check connection
    if ($conn->connect_error) {
        error("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT projectname FROM NutDB_Projects WHERE id=".$id;
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row['projectname'];
        }
    } else {
        return '0';
    } 
    $conn->close();
}


function getProjectText($id) {
    $conn = new mysqli('localhost', $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    // Check connection
    if ($conn->connect_error) {
        error("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT description FROM NutDB_Projects WHERE id=".$id;
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row['description'];
        }
    } else {
        return '0';
    } 
    $conn->close();
}
function getProjectStatus($id) {
    $conn = new mysqli('localhost', $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    // Check connection
    if ($conn->connect_error) {
        error("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT status FROM NutDB_Projects WHERE id=".$id;
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row['status'];
        }
    } else {
        return '0';
    } 
    $conn->close();
}




/*
                $sql = "CREATE TABLE `NutDB_Projects` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `projectname` VARCHAR(64) NOT NULL,
                        `status` VARCHAR(32) DEFAULT NULL,
                        `comments` TEXT NOT NULL DEFAULT '',
                        `collaborates` TEXT(4096) DEFAULT '',
                        `description` TEXT(4096) DEFAULT '',
                        PRIMARY KEY (`id`)
                        );";

*/
function createProject ($projectname, $status, $description, $assignedto){
    $conn = new mysqli('localhost', $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    // Check connection
    if ($conn->connect_error) {
      error("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO NutDB_Projects (projectname, status, comments, collaborates, description) VALUES ('".$projectname."','".$status."', '', '','".$description."')";

    if ($conn->query($sql) === TRUE) {
    } else {
      error("Error: " . $sql . "<br>" . $conn->error);
    }

    $conn->close();
}

function getProject($id) {
    $conn = new mysqli('localhost', $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    // Check connection
    if ($conn->connect_error) {
        error("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, projectname, status, comments, collaborates, description FROM NutDB_Projects WHERE id=".$id;
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if (strtolower($row['status']) == 'hidden') {
                die('<meta http-equiv="refresh" content="0; url=./" />');
            } elseif (strtolower($row['status']) == 'closed') {
                echo project('<span class="idtitle"><a href="?editproject='.$row['id'].'">✏️</a>#'.$row['id'].'</span> '.$row['projectname']. ' [' . $row['status'] . ']', $row['description']);
            }else {
                echo project('<span class="idtitle"><a href="?editproject='.$row['id'].'">✏️</a>#'.$row['id'].'</span> '.$row['projectname']. ' [' . $row['status'] . ']', $row['description']);
            }
            //getTickets($id);
        }
    } else {
        error('404');
    } 
    $conn->close();
}


function listProjects() {
    $conn = new mysqli('localhost', $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    // Check connection
    if ($conn->connect_error) {
        error("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, projectname, status, comments, collaborates, description FROM NutDB_Projects";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if (strtolower($row['status']) == 'hidden') {
            } elseif (strtolower($row['status']) == 'closed') {
                echo '      <div class="project"><a href="?project='.$row['id'].'"><div class="project_title closed"><strike><span class="idtitle">#'.$row['id'].'</span>  '.substr($row['projectname'],0,150). '</strike> [' . $row['status'] . ']</div></a><br>', substr($row['description'], 0, 30) . '...</div>';
            } else {
                echo '      <div class="project"><a href="?project='.$row['id'].'"><div class="project_title"><span class="idtitle">#'.$row['id'].'</span>  '.substr($row['projectname'],0,150). ' [' . $row['status'] . ']</div></a><br>', substr($row['description'], 0, 30) . '...</div>';
            }
        }
    } else {
    } 
    $conn->close();
}