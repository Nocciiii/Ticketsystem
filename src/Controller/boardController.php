<?php
    include_once("classes.php");
    include "connectorController.php";    
    
    //addProject("420", ["Ready", "In Progress", "Review", "Done", "YOLOMASTERHASACCEPTED"]);
    //addStatus(["UwU", "UmUd"]);
    deleteProject("420");
    //getProjects();  
    
    function addProject($projectname, array $statusArray)
    {
        if($projectname !== null)
        {
            connectPDO();
            $pdo = $_SESSION['conn'];
            $addProject = $pdo->prepare("INSERT INTO Board (ProjectName, Privilege) VALUES (?, 1)");
            $success = $addProject->execute([$projectname]);
            if($success === true)
            {    
                $columnOrder = 0;
                foreach($statusArray as $status)
                {
                    $getStatusId = $pdo->prepare("SELECT StatusId FROM Status WHERE Status = ?");
                    $getStatusId->execute([$status]);
                    if(!$statusId = $getStatusId->fetch(PDO::FETCH_ASSOC))
                    {
                        $addStatus = $pdo->prepare("INSERT INTO Status (Status) VALUES (?)");
                        $addStatus->execute([$status]);

                        $getStatusId = $pdo->query("SELECT MAX(StatusId) AS StatusId FROM Status");
                        $statusId = $getStatusId->fetch(PDO::FETCH_ASSOC);
                    }

                    if($statusId["StatusId"] > 0)
                    {
                        $getColumnOrder = $pdo->prepare("SELECT * FROM board_status WHERE board = (SELECT MAX(BoardId) FROM Board) AND status = ?");
                        $getColumnOrder->execute([$statusId["StatusId"]]);
                        if(!$getColumnOrder->fetch())
                        {
                            $addProjectColumn = $pdo->prepare("INSERT INTO board_status (Board, Status, OrderNumber) VALUES ((SELECT MAX(BoardId) FROM Board), ?, ?)");
                            $addProjectColumn->execute([$statusId["StatusId"], $columnOrder]);
                        }
                    }

                    $columnOrder++;
                }
            } 
            else 
            {
                $_SESSION['error'] = "Insert Failed";
            }
        }
        closePDO();
    }

    function addStatus(array $statusArray)
    {
        connectPDO();
        $pdo = $_SESSION['conn'];
        //$project = $_SESSION["currentProject"];

        foreach($statusArray as $status)
        {
            $getStatusId = $pdo->prepare("SELECT StatusId FROM Status WHERE Status = ?");
            $getStatusId->execute([$status]);
            if(!$statusId = $getStatusId->fetch(PDO::FETCH_ASSOC))
            {
                $addStatus = $pdo->prepare("INSERT INTO Status (Status) VALUES (?)");
                $addStatus->execute([$status]);

                $getStatusId = $pdo->query("SELECT MAX(StatusId) AS StatusId FROM Status");
                $statusId = $getStatusId->fetch(PDO::FETCH_ASSOC);
            }

            if($statusId["StatusId"] > 0)
            {
                $getColumnOrder = $pdo->prepare("SELECT MAX(OrderNumber) AS OrderNumber FROM board_status WHERE board = 1");
                $getColumnOrder->execute([/*$project->getBoardId(), */]);
                if($columnOrderArray = $getColumnOrder->fetch(PDO::FETCH_ASSOC))
                {
                    var_dump((int)$columnOrderArray["OrderNumber"] + 1);
                    $addProjectColumn = $pdo->prepare("INSERT INTO board_status (Board, Status, OrderNumber) VALUES ((SELECT MAX(BoardId) FROM Board), ?, ?)");
                    $addProjectColumn->execute([$statusId["StatusId"], (int)$columnOrderArray["OrderNumber"] + 1]);
                }
            }
        }
        closePDO();
    }
    
    function deleteProject()
    {
        if($_SESSION['usedBoard'] !== null)
        {
            connectPDO();
            $pdo = $_SESSION['conn'];
            $deleteBoard = $pdo->prepare("DELETE FROM Board WHERE ProjectName = ?");
            $deleteTicket = $pdo->prepare("DELETE FROM Ticket WHERE board = (SELECT boardId FROM Board WHERE ProjectName = ?)");
            $deleteBoardStatus = $pdo->prepare("DELETE FROM Board_Status WHERE board = (SELECT boardId FROM Board WHERE ProjectName = ?)");
            
            $deleteBoardStatus->execute([$projectname]);
            $deleteTicket->execute([$projectname]);
            $deleteBoard->execute([$projectname]);
            
            if($deleteTicket === false OR $deleteBoard === false OR $deleteBoardStatus === false)
            {
                $_SESSION['error'] = "Project could not be deleted";
            }
        }
        closePDO();
    }
    
    function getProjects()
    {
        connectPDO();
        $pdo = $_SESSION['conn'];
        $getAllProjects = $pdo->query("SELECT * FROM Board");

        $getAllProjectColumns = $pdo->query("SELECT * FROM Board_Status");
        $allBoardColumns = $getAllProjectColumns->fetchAll();


        if(!$allBoards = $getAllProjects->fetchAll(PDO::FETCH_ASSOC))
        {
            echo "hallo";
            $_SESSION['error'] = "Project could not be found";
        } else {
            $projects = array();
            foreach($allBoards as $board)
            {
                $getPrivilege = $pdo->prepare("SELECT Privilege FROM Privilege WHERE PrivilegeId = ?");
                $getPrivilege->execute([$board["Privilege"]]);
                $privilege = $getPrivilege->fetch(PDO::FETCH_ASSOC);
                foreach($allBoardColumns as $boardColumn)
                {
                    if($boardColumn["Board"] === $board["BoardId"])
                    {
                        $getStatus = $pdo->prepare("SELECT Status FROM Status WHERE StatusId = ?");
                        $getStatus->execute([$boardColumn["Status"]]);
                        $statusArray[$boardColumn["OrderNumber"]] = $getStatus->fetch(PDO::FETCH_ASSOC);
                    }   
                }

                $newProject = new Board();
                $newProject->setBoardId($board["BoardId"]);
                $newProject->setBoardName($board["ProjectName"]);
                $newProject->setPrivilege($privilege["Privilege"]);
                foreach($statusArray as $status)
                {
                    var_dump($status);
                    $newProject->setStatus($status["Status"]);
                }

                echo "\n";
                var_dump($newProject);
                echo "\n";
                    
                array_push($projects, $newProject);
            }
            $_SESSION['project'] = $projects;
        };
        closePDO();
    }
    function getBoard($boardname)
    {
        connectPDO();
        $pdo = $_SESSION['conn'];
        $boardSql = $pdo->prepare('SELECT BoardId FROM Board WHERE BoardName = ?');
        $boardSql->execute([$boardname]);
        $boardId = $boardSql->fetchAll();
        
        $statement = $pdo->prepare('SELECT * FROM Ticket WHERE BoardId = ?');
        
        $tickets = array();
        $statement->execute();
        $rows = $statement->fetchAll();
        foreach($rows as $row)
        {
            $newTicket = new Ticket();
            $newTicket->setTicketId($row[0]);
            $newTicket->setTicketSummary($row[2]);
            $ticketDetailQuery = $pdo->prepare('SELECT Username FROM User WHERE UserId = ?');
            $ticketDetailQuery->execute($row[3]);
            $newTicket->setTicketAuthor($ticketDetailQuery->fetch());
            $newTicket->setTicketDescription($row[4]);
            $ticketDetailQuery = $pdo->prepare('SELECT Username FROM User WHERE UserId = ?');
            $ticketDetailQuery->execute($row[5]);
            $newTicket->setTicketAssignee($ticketDetailQuery->fetch());
            $newTicket->setTicketStatus($row[6]);
            $newTicket->setTicketLogs($row[7]);
            array_push($tickets, $newTicket);
        }
        $stati = array();
        //ToDo: Change the select so that only stati will be selected that are used on the board
        $statiSql = $pdo->query('SELECT * FROM Status');
        $stati = $statiSql->fetchAll();

        FOREACH($stati as $status)
        {
            $board = $board.'<div id="status_"'.$ticket[0].' onclick="on(this)" class="board">';
            $board = $board.'<h1>'.$status[1].'</h1><hr>';
            $statusassigneedTickets[] ='';
            FOREACH($tickets as $ticket)
            {
                if($ticket->getStatus() === $status[0])
                {
                    array_push($statusassigneedTickets, $ticket);
                    $tickets = array_diff($tickets, $ticket);
                }
            }
            FOREACH($statusassigneedTickets as $statusassigneedTicket)
            {
                $board = $board.'<div id="ticket"class="ticket">';
                $board = $board.
                $ticket->getTicketSummary().'<hr>'.
                'Author: '.$ticket->getTicketAuthor().'<hr>'.
                $ticket->getTicketDescription().'<hr>'.
                'Zugewiesen: '.$ticket->getTicketAssignee();
                $board = $board.'</div>';
            }
            $board = $board.'</div>';
        }
        //List of all Tickets, needed for detailview
        $_SESSION['Tickets'] = $tickets;
        //finished board
        $_SESSION['Board'] = $board;
        closePDO();
        die('Ticket could not be found');
    }
    
    function getAllBoards()
    {
        connectPDO();
        $pdo = $_SESSION['conn'];
        $boardSql = $pdo->prepare('SELECT BoardId, Boardname FROM Board');
        $boardSql->execute();
        $boards = $boardSql->fetchAll();
        $allBoards[] ='';
        $allTickets[] ='';
        FOREACH($boards as $selectedBoard)
        {
            $statement = $pdo->prepare('SELECT * FROM Ticket WHERE BoardId ='.$selectedBoard[0]);
            $tickets = array();
            $statement->execute();
            $rows = $statement->fetchAll();
            foreach($rows as $row)
            {
                $newTicket = new Ticket();
                $newTicket->setTicketId($row[0]);
                $newTicket->setTicketSummary($row[2]);
                $ticketDetailQuery = $pdo->prepare('SELECT Username FROM User WHERE UserId = ?');
                $ticketDetailQuery->execute($row[3]);
                $newTicket->setTicketAuthor($ticketDetailQuery->fetch());
                $newTicket->setTicketDescription($row[4]);
                $ticketDetailQuery = $pdo->prepare('SELECT Username FROM User WHERE UserId = ?');
                $ticketDetailQuery->execute($row[5]);
                $newTicket->setTicketAssignee($ticketDetailQuery->fetch());
                $newTicket->setTicketStatus($row[6]);
                $newTicket->setTicketLogs($row[7]);
                array_push($tickets, $newTicket);
                array_push($allTickets,$newTicket);
            }
            $stati = array();
            //ToDo: Change the select so that only stati will be selected that are used on the board
            $statiSql = $pdo->query('SELECT * FROM Status');
            $stati = $statiSql->fetchAll();
            FOREACH($stati as $status)
            {
                $board = $board.'<div id="status_"'.$ticket[0].' onclick="on(this)" class="board">';
                $board = $board.'<h1>'.$status[1].'</h1><hr>';
                $statusassigneedTickets[] ='';
                FOREACH($tickets as $ticket)
                {
                    if($ticket->getStatus() === $status[0])
                    {
                        array_push($statusassigneedTickets, $ticket);
                        $tickets = array_diff($tickets, $ticket);
                    }
                }
                FOREACH($statusassigneedTickets as $statusassigneedTicket)
                {
                    $board = $board.'<div id="ticket"class="ticket">';
                    $board = $board.
                    $ticket->getTicketSummary().'<hr>'.
                    'Author: '.$ticket->getTicketAuthor().'<hr>'.
                    $ticket->getTicketDescription().'<hr>'.
                    'Zugewiesen: '.$ticket->getTicketAssignee();
                    $board = $board.'</div>';
                }
                $board = $board.'</div>';
                $boardsRow[] ='';
                array_push($boardsRow, $selectedBoard[1]);
                array_push($boardsRow, $board);
                array_push($allBoards, $boardsRow);
            }
        }
        //List of all Tickets, needed for detailview
        $_SESSION['Tickets'] = $allTickets;
        //finished boards
        $_SESSION['Boards'] = $allBoards;
        closePDO();
        die('Ticket could not be found');
    }
    //searches for the selected Board in the Session, returns only the bord
    function getBoardFromList($boardname)
    {
        FOREACH($_SESSION['Boards'] as $sessionboard)
        {
            if($sessionboard[0]===$boardname)
            {
                $_SESSION['usedBoard'] = $boardname;
                return $sessionboard[1];                
            }
        }
        
    }
