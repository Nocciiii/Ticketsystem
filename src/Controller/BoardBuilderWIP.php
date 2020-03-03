<?php
$stati = array();
$statiSql = $pdo->query('SELECT * FROM Status');
$stati = $statiSql->fetchAll();

FOREACH($stati as $status)
{
    $board = $board.'<div id="status" class="board">';
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