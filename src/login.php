<php?
    if(isset($_SESSION['active']))
    {
        session_start;
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="main.css">
        <script>
            document.getElementById("signIn").onclick = function() {
                $.ajax({
                    url : "loginController.php",
                    type : "POST",
                    data : { action: 'connectPDO', $user, $password, $servername, $dbname },
                    dataType: "json"
                });
                $.ajax({
                    url : "loginController.php",
                    type : "POST",
                    data : { action: 'login', 
                        $username : document.getElementById("lUsername"), 
                        $password : document.getElemtById("lPassword") },
                    dataType: "json"
                });
                $.ajax({
                    url : "loginController.php", 
                    type : "POST", 
                    data : { action: 'closePDO', $user, $password, $servername, $dbname },
                    dataType: "json"
                });
            };
            
            document.getElementById("signUp").onclick = function() {
                $.ajax({
                    url : "loginController.php",
                    type : "POST",
                    data : { action: 'connectPDO', $user, $password, $servername, $dbname },
                    dataType: "json"
                });
                $.ajax({
                    url : "signUpController.php",
                    type : "POST",
                    data : { action: 'login', 
                        $username : document.getElementById("lUsername"), 
                        $password : document.getElemtById("lPassword") },
                    dataType: "json"
                });
                $.ajax({
                    url : "loginController.php", 
                    type : "POST", 
                    data : { action: 'closePDO', $user, $password, $servername, $dbname },
                    dataType: "json"
                });
            };
        </script>
    </head>
    <body>
        <div class="logo">
            <img src="logo.png" alt="logo">
        </div>
        <div class="menu">
            <table style="width: 100%">
                <tr>
                    <th width="10%">
                        <label>Tickets</label>
                    </th>
                    <th width="10%">
                        <label>Boards</label>
                    </th>
                    <th width="75%">
                        <!-- Empty column for layout -->
                    </th>

                    <th width="5%">
                        <img width="28px" height="28px" src="J:\Projekt\Kümmert\Bilder\options.png" alt="Optionen">
                    </th>
                </tr>
            </table>
        </div>
        <div class="body">
                <table style="width: 100% hight: 500px" frame="box" align="center">
                    <tr>
                        <td width="50%">
                            <table style=" height: 100%; width: 100%" frame="box">
                                <tr width="100%">
                                    <td>
                                       <h1>Login</h1>
                                    </td>
                                </tr>        
                                <tr>
                                    <td width="100%">
                                       <label style="width:33%">Username:</label><li style=" with: 67%; list-style-type: none"><input type="text" id="lUsername"></li>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%">
                                       <label style="width:33%">Passwort:</label><li style=" with: 67%; list-style-type: none"><input type="text" id="lPassword"></li>
                                    </td>
                                </tr>
                                <tr height="45px">   
                                </tr>
                                <tr>
                                    <td width="100%">
                                       <input type="button" id="signIn" value="Login">
                                    </td>
                                </tr>   
                            </table>
                        </td>
                        <td width="50%">
                            <table style="width: 100%; height: 100%" frame="box">
                                <tr>
                                    <td>
                                       <h1>Registrieren</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%">
                                       <label style="width:33%">Username:</label>  <li style=" with: 67%; list-style-type: none"><input type="text" id="rUsername"></li>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%">
                                       <label style="width:33%">Passwort:</label><li style=" with: 67%; list-style-type: none"><input type="text" id="rPassword"></li>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%">
                                       <label style="width:33%">Passwort best&aumltigen:</label><li style=" with: 67%; list-style-type: none"><input type="text" id="rPasswordConfirm"></li>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%">
                                       <input type="button" id="signUp" value="Registrieren">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
        </div>
        <footer>
            <div class="footer">
                <table class="footertable" style="width: 100%">
                    <tr>
                        <td class="footertableElement" width="25%">
                            Kontakt
                        </td>
                        <td class="footertableElement" width="25%">
                            Impressum
                        </td>
                        <td class="footertableElement" width="25%">
                            Datenschutz
                        </td>
                        <td class="footertableElement" width="25%">
                            Quellen
                        </td>
                    </tr>
            </div>
        </footer>
    </body>
</html>