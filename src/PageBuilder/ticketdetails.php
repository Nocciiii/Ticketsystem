<?php
public function getTicketdetails()
{
    connectPDO();
    $pdo = $_SESSION['conn'];

    //check which Ticket got selected for a detailview
    foreach($Session['tickets'] as $ticket)
    {
        if("status_".$ticket->getTicketId() === $status)
        {
            detailTicket = $ticket;
        }
    }

    //Summary and Closingbutton
    $ticketdetails='
        <div id ="details">
            <textfield id="title">'
                .$detailticket->getTicketSummary().
            '</textfield>
            <label id="exitDetail" onclick="off()">X</label><br>
            <label id="assigned">Zugeordnet:</label><select id="assignee_select">';

    //Get all Users to fill them into the Box, the assigned Account will be the selected one
    $users = array();
    $usersSql = $pdo->prepare('SELECT * FROM User');
    $usersSql->execute();
    $users = $usersSql->fetchAll();

    FOREACH($users as $user)
    {
        $ticketdetails = $ticketdetails.'<option value="'.$user[0].'"';
        if($user[0]===$detailticket->getTicketAssignee())
        {
            $ticketdetails = $ticketdetails.'selected="selected"';
        }
        $ticketdetails=$ticketdetails.'>'.$user[1].'</option>';             
    }
    $ticketdetails=$ticketdetails.'</select><br>';

    //Description
    $ticketdetails=$ticketdetails.
            '<label id="description">Beschreibung:</label>
            <textarea id="description_textarea">'
                .$detailticket->getTicketDescription().'</textarea><br>
            <label id="status">Status:</label><select id="status_select">';
    //The same way The assignee was handled, just for all states
    $stati = array();
    $statiSql = $pdo->prepare('SELECT * FROM Status');
    $statiSql->execute();
    $stati = $statiSql->fetchAll();

    FOREACH($stati as $status)
    {
        $ticketdetails = $ticketdetails.'<option value="'.$status[0].'"';
        if($status[0]===$detailticket->getTicketStatus())
        {
            $ticketdetails = $ticketdetails.'selected="selected"';
        }
        $ticketdetails=$ticketdetails.'>'.$status[1].'</option>';             
    }
    $ticketdetails=$ticketdetails.'</select><br>';

    //Author
    $ticketdetails=$ticketdetails.$ticket->getTicketStatus().
            '<label id="author">Author: '
                .$detailticket->getTicketAuthor()).            
            '</label><br>
            <input type ="button" value="update" onclick="updateTicket()"><br>
            <button type="button" onclick="deleteTicket('.$detailticket.getTicketSummary().')">L&ouml;schen</button>
        </div>';

    closePDO();
    echo $ticketdetails;
}