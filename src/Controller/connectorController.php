<?php
function connectPDO()
{    
    $username = "fi11";
    $servername = "172.16.5.55"; 
    $dbname = "fi12-projekt-ticketsystem";
     
    try {
        $_SESSION['conn'] = new PDO("mysql:host=$servername;dbname=$dbname", $username);
        $_SESSION['conn']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
}

function closePDO()
{
    if(isset($_SESSION['conn']))
    {
        $_SESSION['conn'] = null;
        if($_SESSION['conn'] === null)
        {
            echo "Connection closed";
        }
    }
}
?>