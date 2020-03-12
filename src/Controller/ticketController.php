<?php
    include 'connectorController.php';
    include 'classes.php';
    addTicket("420", "Hallo", "Timo", "lololololol101", "Low", "Ready");

    function addTicket($projectname, $ticketSummary, $authorname, $ticketDescribtion, $priority, $status)
    {
        if($projectname !== null && $ticketSummary !== null && $authorname !== null && $ticketDescribtion !== null)
        {
            if($priority === null)
            {
                $priority = 'Low';
            }
            if($status === null)
            {
                $status = 'Ready';
            }
            connectPDO();
            $pdo = $_SESSION['conn'];
            $projectSql = $pdo->prepare('SELECT boardId FROM Board WHERE ProjectName = ?');
            $projectSql->execute([$projectname]);
            $projectId = $projectSql->fetch();
            echo $projectId[0];

            $authorSql = $pdo->prepare('SELECT UserId FROM User WHERE Username = ?');
            $authorSql->execute([$authorname]);
            $authorId = $authorSql->fetch();
            echo $authorId[0];

            $prioritySql = $pdo->prepare('SELECT priorityId FROM priority WHERE priority = ?');
            $prioritySql->execute([$priority]);
            $priorityId = $prioritySql->fetch();
            echo $priorityId[0];

            $statusSql = $pdo->prepare('SELECT statusId FROM status WHERE status = ?');
            $statusSql->execute([$status]);
            $statusId = $statusSql->fetch();
            echo $statusId[0];

            addTicketWithIds($pdo, $projectId, $ticketSummary, $authorId, $ticketDescribtion, $priorityId, $statusId);
        }
        closePDO();
    }

    function addTicketWithIds($pdo, $projectId, $ticketSummary, $authorId, $ticketDescribtion, $priorityId, $statusId)
    {
        $ticketInsert = $pdo->prepare('INSERT INTO Ticket (TicketSummary, Priority, Author, Status, Logs, TicketDescribtion, board) VALUES (?, ?, ?, ?, 0, ?, ?)');
        $success = $ticketInsert->execute([$ticketSummary, $priorityId[0], $authorId[0], $statusId[0], $ticketDescribtion, $projectId[0]]);
        
        if($success === true)
        {
            echo "hallo";
            $UserTicket = $pdo->prepare('INSERT INTO User_Ticket (User, Ticket) VALUES (?, (SELECT MAX(TicketId) FROM Ticket))');
            $UserTicket->execute([$authorId[0]]);

            if($UserTicket === false)
            {
                $_SESSION['error'] = "Insert Into UserTicket failed";
            }
        } else {
            $_SESSION['error'] = "Insert Into Ticket failed";
        }
    }

    function deleteTicket($tickSummary)
    {
        if($ticketSummary !== null)
        {
            connectPDO();
            $pdo = $_SESSION['conn'];
            $deleteUserTicket = $pdo->prepare('DELETE User_Ticket FROM User_Ticket WHERE ticket = (SELECT TicketId FROM Ticket WHERE ticketsummary = ?)');
            $deleteUserTicket->execute([$ticketSummary]);

            $deleteTicket = $pdo->prepare('DELETE FROM Ticket WHERE ticketsummary = ?');
            $deleteTicket->execute([$ticketSummary]);

            if(deleteTicket === false)
            {
                die('Ticket could not be deleted');
            }
            closePDO();
        }
    }

    function getTicket($ticketId)
    {
        connectPDO();
        $pdo = $_SESSION['conn'];
        
        $statement = $pdo->prepare('SELECT * FROM Ticket WHERE TicketId = '.$ticketId);
        
        $tickets = array();
        $statement->execute();
        $row = $statement->fetchAll();

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
        
        closePDO();
        return $newTicket;
    }