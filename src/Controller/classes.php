<?php
class Board {
    private $boardId = '';
    private $boardName = '';
    private $privilege = '';
    private $status = array();
    
    public function getBoardName()
    { 
        return $this->boardName; 
    }
    public function setBoardName($boardName)
    { 
        $this->boardName = $boardName; 
    }
    public function getBoardId()
    { 
        return $this->boardId; 
    }
    public function setBoardId($boardId)
    { 
        $this->boardId = $boardId; 
    }
    public function getPrivilege()
    { 
        return $this->privilege; 
    }
    public function setPrivilege($privilege)
    { 
        $this->privilege = $privilege; 
    }
    public function getStatus()
    { 
        return $this->status; 
    }
    public function setStatus($status)
    { 
        array_push($this->status, $status);
    }
}

class Ticket{
    private $ticketId='';
    private $ticketSummary='';
    private $ticketAuthor='';
    private $ticketDescription='';
    private $ticketAssignee='';
    private $ticketStatus='';
    private $ticketLogs='';
    
    public function getTicketId()
    { 
        return $this->ticketId; 
    }
    public function setTicketId($ticketId)
    { 
        $this->ticketId = $ticketId; 
    }
    public function getTicketSummary()
    { 
        return $this->ticketSummary; 
    }
    public function setTicketSummary($ticketSummary)
    { 
        $this->ticketSummary = $ticketSummary; 
    }
    public function getTicketAuthor()
    { 
        return $this->ticketAuthor; 
    }
    public function setTicketAuthor($ticketAuthor)
    { 
        $this->ticketAuthor = $ticketAuthor; 
    }
    public function getTicketDescription()
    { 
        return $this->ticketDescription; 
    }
    public function setTicketDescription($ticketDescription)
    { 
        $this->ticketDescription = $ticketDescription; 
    }
    public function getTicketAssignee()
    { 
        return $this->ticketAssignee; 
    }
    public function setTicketAsssignee($ticketAssignee)
    { 
        $this->ticketAssignee = $ticketAssignee; 
    }
    public function geTicketStatus()
    { 
        return $this->ticketStatus; 
    }
    public function setTicketStatus($ticketStatus)
    { 
        $this->ticketStatus = $ticketStatus; 
    }
    public function getTicketLogs()
    { 
        return $this->ticketLogs; 
    }
    public function setTicketLogs($ticketLogs)
    { 
        $this->ticketLogs = $ticketLogs; 
    }
}
?>