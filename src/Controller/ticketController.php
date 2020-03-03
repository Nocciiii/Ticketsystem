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

            $authorSql = $pdo->prepare('SELECT UserId FROM User WHERE Username = ?');
            $authorSql->execute([$authorname]);
            $authorId = $authorSql->fetch();

            $prioritySql = $pdo->prepare('SELECT priorityId FROM priority WHERE priority = ?');
            $prioritySql->execute([$priority]);
            $priorityId = $prioritySql->fetch();

            $statusSql = $pdo->prepare('SELECT statusId FROM status WHERE status = ?');
            $statusSql->execute([$status]);
            $statusId = $statusSql->fetch();

            addTicketWithIds($pdo, $projectId, $ticketSummary, $authorId, $ticketDescribtion, $priorityId, $statusId);
        }
        closePDO();
    }

    function addTicketWithIds($pdo, $projectId, $ticketSummary, $authorId, $ticketDescribtion, $priorityId, $statusId)
    {
        $ticketInsert = $pdo->prepare('INSERT INTO Ticket (
            TicketSummary, Priority, Author, Status, Logs, TicketDescribtion, board
        ) VALUES (?, ?, ?, ?, 0, ?, ?)'
        );
        $ticketInsert->execute([$ticketSummary, $priorityId[0], $authorId[0], $statusId[0], $ticketDescribtion, $projectId[0]]);
        $pdo->commit();
        $ticketId = $pdo->lastInsertId();
        
        if($ticketInsert === true)
        {
            $UserTicket = $pdo->prepare('INSERT INTO User_Ticket (
                User, Ticket
            ) VALUES (?, ?)'
            );
            $UserTicket->execute([$authorId, $ticketId]);

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
            $deleteUserTicket = $pdo->prepare('DELETE User_Ticket
                FROM User_Ticket ut LEFT JOIN Ticket t
                ON ut.Ticket = t.TicketId
                WHERE t.ticketSummary = ?');
            $deleteUserTicket->execute([$ticketSummary]);

            $deleteTicket = $pdo->prepare('DELETE 
                FROM Ticket 
                WHERE ticketname = ?'
            );
            $deleteTicket->execute();

            if(deleteTicket === false)
            {
                die('Ticket could not be deleted');
            }
        }
    }

    function getTicket($boardname)
    {
        connectPDO();
        $pdo = $_SESSION['conn'];
        $boardSql = $pdo->prepare('SELECT BoardId FROM Board WHERE BoardName = ?');
        $boardSql->execute([$boardname]);
        $boardId = $boardSql->fetchAll();
        
        $statement = $pdo->prepare('SELECT * 
            FROM Ticket WHERE BoardId = ?'
        );
        
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
        $board;
        $_SESSION['Board'] = $board;
            
        die('Ticket could not be found');
    }