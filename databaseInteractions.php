<?php
    public function connect()
    {
        $server = '';
        $user = '';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

        try
        {
            $pdo = new PDO ($server, $user, '', $options);
        }
        catch(PDOException $e)
        {
            die('Connection unsuccessful');
        }
        return $pdo;
    }
//Board
    public function addProject()
    {
        if($_POST['projectname'] != '')
        {
            $pdo = connect();
            $statement = $pdo->prepare('
            INSERT INTO Board 
            (ProjectName, Privilege, ColumnOrder) 
            VALUES 
            {
                '. $_POST['projectname'].',
                1,
                1
            }'
            );
            try
            {
                $statement->execute();
            }
            catch(PDOException $e)
            {
                die('Insert Failed');
            }
        }
    }
    public function deleteProject()
    {
        if($_POST['projectId'] != '')
        {
            $pdo = connect();
            $statement1 = $pdo->prepare('
                DELETE 
                FROM Board 
                WHERE BoardId ='.$_POST['projectId']
            );
            $statement2 = $pdo->prepare('
                DELETE
                FROM Ticket 
                WHERE board ='.$_POST['projectId']
            );
            try
            {
                $statement1->execute();
                $statement2->execute();
            }
            catch(PDOException $e)
            {
                die('Project could not be deleted');
            }
        }
    }
    public function getProject()
    {
        if($_POST['projectId'] != '')
        {
            $pdo = connect();
            $statement = $pdo->prepare('
                SELECT * FROM Board where BoardId ='.$_POST['projectId']
            );
            try
            {
                return $statement->execute();
                
            }
            catch(PDOException $e)
            {
                die('Project could not be found');
            }
        }
    }
    
//Ticket
    public function addTicket()
    {
        if($_POST['projectname'] != '' && $_POST['ticketSummary'] != '' && $_POST['author'] != '' && $_POST['ticketDescription' != ''] && $_Post['projektId'] != '')
        {
            if($_POST['priority'] == '')
            {
                $priority = 1;
            }
            if($_POST['assignee'] == '')
            {
                $assignee = $_POST['author'];
            }
            if($_POST['status'] == '')
            {
                $status = 1;
            }
            $pdo = connect();
            $statement1 = $pdo->prepare('
            INSERT INTO Ticket 
            (TicketSummary, Priority, Author, Assignee, Status, Logs, TicketDescription, board) 
            VALUES 
            {
                '. $_POST['ticketSummary'].',
                '. $priority.',
                '. $_POST['author'].',
                '. $assignee.',
                '. $status.',
                '. $_POST['logs'].',
                '. $_POST['ticketDescription'].',
                '. $_POST['projektId'].'
            }'
            );
            try
            {
                $statement1->execute();
                $statement2 = $pdo->prepare('
                INSERT INTO User_Ticket
                (User, Ticket)
                VALUES
                (
                '.$statement1.ticketId.',
                '.$ticket.'
                )
                ');
                $statement2->execute();
            }
            catch(PDOException $e)
            {
                die('Insert Failed');
            }
        }
    }
    public function deleteTicket()
    {
        if($_POST['ticketId'] != '')
        {
            $pdo = connect();
            $statement = $pdo->prepare('
                DELETE 
                FROM Ticket 
                WHERE ticketId ='.$_POST['ticketId']
            );
            try
            {
                $statement->execute();
            }
            catch(PDOException $e)
            {
                die('Ticket could not be deleted');
            }
        }
    }
    public function getTicket()
    {
        if($_POST['ticketId'] != '')
        {
            $pdo = connect();
            $statement = $pdo->prepare('
                SELECT * FROM Ticket where BoardId ='.$_POST['ticketId']
            );
            try
            {
                return $statement->execute();
                
            }
            catch(PDOException $e)
            {
                die('Ticket could not be found');
            }
        }
    }

?>