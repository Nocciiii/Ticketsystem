<?php
   include ("../Controller/classes.php");
   include ("../Controller/boardController.php");
   include ("../Controller/ticketController.php");
   $boardController = new BoardController();
   $boards = $boardController->getProjects();
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css"href="../CSS/main.css">
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
        <script>
            document.getElementById("board").onclick = function() {
                    $.ajax({
                        url : "../Controller/ticketController.php",
                        type : "POST",
                        data : { action: 'getTickets', 
                            username : document.getElementById("board") },
                        processData: false,
                        contentType: false,
                    }); 
                };
        </script>
    </head>
    <body>
        <div class="logo">
            <img id="logo" src="../../Bilder/LogoPLZKILLME.png" alt="logo" >
        </div>
        <div class="menu">
            <table style="width: 100%">
                <tr>
                    <th width="10%">
                        <label>Tickets</label>
                    </th>
                    <th width="10%">
                        <div class="dropdownTickets">
                            <label>Boards</label>
                            <div class="dropdownContent">
                                <table style="width: 100%">      
                                    <!-- PHP loop for all tickets -->
                                    <?php
                                        foreach($boards as $board)
                                        {
                                            printf("<tr><td><label id='board'>".$board[1]."</label></td></tr>");
                                        }
                                    ?>
                                    <!-- -->
                                </table>
                            </div>
                        </div>
                    </th>
                    <th width="5%">
                        <div class="dropdownTickets">
                            <label>+</label>
                            <div class="dropdownContent">
                                <table style="width: 100%">
                                    <tr width="100%">
                                        <td>
                                            <h3>Board anlegen</h3>
                                        </td>
                                    </tr>        
                                    <tr>
                                        <td width="100%">
                                        <label style="width:33%">Projektname:</label><li style=" with: 67%; list-style-type: none"><input type="text" name="lUsername"></li>
                                        </td>
                                    </tr>
                                    <tr height="45px">   
                                    </tr>
                                    <tr>
                                        <td width="100%">
                                        <input type="button" value="Hinzufügen">
                                        </td>
                                    </tr>   
                                </table>
                            </div>
                        </div>
                    </th>
                    <th width="50%">
                        <!-- Empty column for layout -->
                    </th>
                    <th width="20%">
                        <a href="login.php">Login</a>
                    </th>
                    <th width="5%">
                        <img id="options" src="../../Bilder/options.png" alt="Optionen">
                    </th>
                </tr>
            </table>
        </div>
        <div class="body">
        </div>
        <footer>
            <div class="footer">
                <div class="footertable">
                        <div class="footertableElement">
                            Kontakt
                        </div>
                        <div class="footertableElement">
                            Impressum
                        </div>
                        <div class="footertableElement">
                            Datenschutz
                        </div>
                        <div class="footertableElement">
                            Quellen
                        </div>
            </div>
        </footer>
    </body>
</html>