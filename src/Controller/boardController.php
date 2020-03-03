<?php
    include "classes.php";
    include "connectorController.php";    
    addProject("420");
        
    function addProject($projectname)
    {
        if($projectname !== null)
        {
            connectPDO();
            $pdo = $_SESSION['conn'];
            $statement = $pdo->prepare("
            INSERT INTO Board 
            (ProjectName, Privilege, ColumnOrder) 
            VALUES (?, 1, 1)"
            );
            $success = $statement->execute([$projectname]);
            if($success === false)
            {    
                $_SESSION['error'] = "Insert Failed";
            }
        }
        closePDO();
    }
    
    function deleteProject($projectname)
    {
        if($projectname !== null)
        {
            connectPDO();
            $pdo = $_SESSION['conn'];
            $statement1 = $pdo->prepare("
                DELETE 
                FROM Board 
                WHERE ProjectName = ?"
            );
            $statement2 = $pdo->prepare("
                DELETE
                FROM Ticket 
                WHERE board = ?"
            );
            $statement1->execute([$projectname]);
            $statement2->execute([$projectname]);
            
            if($statement1 === false OR $statement2 === false)
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
        $statement = $pdo->prepare("SELECT * FROM Board");
        $projects = array();
        $statement->execute();
        $rows = $statement->fetchAll();
        if($rows === null)
        {
            $_SESSION['error'] = "Project could not be found";
        } else {
            foreach($rows as $row)
            {
                $newProject = new Board();
                $newProject->setBoardId($row[0]);
                $newProject->setBoardName($row[1]);
                $newProject->setPrivilege($row[2]);
                array_push($projects, $newProject);
            }
            $_SESSION['project'] = $projects;
        };
        closePDO();
    }
