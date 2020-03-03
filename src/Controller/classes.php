<?php
class Board {
    public $boardId='';
    public $boardName='';
    public $privilege='';
    
    function getBoardName()
    { 
        return $this->boardName; 
    }
    function setBoardName($boardName)
    { 
        $this->boardName = $boardName; 
    }
    function getBoardId()
    { 
        return $this->boardId; 
    }
    function setBoardId($boardId)
    { 
        $this->boardId = $boardId; 
    }
    function getPrivilege()
    { 
        return $this->privilege; 
    }
    function setPrivilege($privilege)
    { 
        $this->privilege = $privilege; 
    }
}

class Ticket{
    public $ticketId='';
    public $ticketSummary='';
    public $ticketAuthor='';
    public $ticketDescription='';
    public $ticketAssignee='';
    public $ticketStatus='';
    public $ticketLogs='';
    
    function getTicketId()
    { 
        return $this->ticketId; 
    }
    function setTicketId($ticketId)
    { 
        $this->ticketId = $ticketId; 
    }
    function getTicketSummary()
    { 
        return $this->ticketSummary; 
    }
    function setTicketSummary($ticketSummary)
    { 
        $this->ticketSummary = $ticketSummary; 
    }
    function getTicketAuthor()
    { 
        return $this->ticketAuthor; 
    }
    function setTicketAuthor($ticketAuthor)
    { 
        $this->ticketAuthor = $ticketAuthor; 
    }
    function getTicketDescription()
    { 
        return $this->ticketDescription; 
    }
    function setTicketDescription($ticketDescription)
    { 
        $this->ticketDescription = $ticketDescription; 
    }
    function getTicketAssignee()
    { 
        return $this->ticketAssignee; 
    }
    function setTicketAsssignee($ticketAssignee)
    { 
        $this->ticketAssignee = $ticketAssignee; 
    }
    function geTicketStatus()
    { 
        return $this->ticketStatus; 
    }
    function setTicketStatus($ticketStatus)
    { 
        $this->ticketStatus = $ticketStatus; 
    }
    function getTicketLogs()
    { 
        return $this->ticketLogs; 
    }
    function setTicketLogs($ticketLogs)
    { 
        $this->ticketLogs = $ticketLogs; 
    }
}
?>