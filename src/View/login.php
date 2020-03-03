<?php
    if(session_id() == '' || !isset($_SESSION))
    {
        session_start();
    }
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css"href="../CSS/main.css">
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
        <script>
            $( document ).ready(function() {
                addOption();

                function addOption() {
                    $('#rUsertype').append($('<option>', {
                        value: 0,
                        text: 'Developer'
                    }));
                    $('#rUsertype').append($('<option>', {
                        value: 1,
                        text: 'Product Owner'
                    }));
                    $('#rUsertype').append($('<option>', {
                        value: 2,
                        text: 'Customer'
                    }));
                }

                document.getElementById("signIn").onclick = function() {
                    $.ajax({
                        url : "../Controller/loginController.php",
                        type : "POST",
                        data : { action: 'login', 
                            username : document.getElementById("lUsername"), 
                            password : document.getElementById("lPassword") },
                        processData: false,
                        contentType: false,
                    });
                };
                
                document.getElementById("signUp").onclick = function() {
                    $.ajax({
                        url : "../Controller/loginController.php",
                        type : "POST",
                        data : { action: 'login', 
                            username : document.getElementById("rUsername"), 
                            password : document.getElementById("rPassword"),
                            email : document.getElementById("rEmail"),
                            usertype : document.getElementById("rUsertype") },
                        processData: false,                         
                        contentType: false,
                    });
                };
            });
        </script>
    </head>
    <body>
        <div class="logo">
            <img id="logo" src="../../Bilder/LogoPLZKILLME.png" alt="logo">
        </div>
        <div class="menu">
            <table style="width: 100%">
                <tr>
                    <th width="95%">
                        <!-- Empty column for layout -->
                    </th>

                    <th width="5%">
                        <img id="options" src="../../Bilder/options.png" alt="Optionen">
                    </th>
                </tr>
            </table>
        </div>
        <div class="body">
            <div class="logindata">
                <div class ="logindataContent">
                    <h1>Login</h1>
                    <label style="width:33%">Username:</label><li style=" with: 67%; list-style-type: none"><input type="text" id="lUsername"></li>
                    <label style="width:33%">Passwort:</label><li style=" with: 67%; list-style-type: none"><input type="text" id="lPassword"></li>
                    <input type="button" id="signIn" value="Login">
                </div>
                <div class ="logindataContent">
                    <h1>Registrieren</h1>
                    <label style="width:33%">Username:</label>  <li style=" with: 67%; list-style-type: none"><input type="text" id="rUsername"></li>
                    <label style="width:33%">Email:</label>  <li style=" with: 67%; list-style-type: none"><input type="text" id="rEmail"></li>
                    <label style="width:33%">Passwort:</label><li style=" with: 67%; list-style-type: none"><input type="text" id="rPassword"></li>
                    <label style="width:33%">Passwort best&aumltigen:</label><li style=" with: 67%; list-style-type: none"><input type="text" id="rPasswordConfirm"></li>
                    <label>Usertype:</label><br/>
                    <select id="rUsertype"><br/>
                    <input type="button" id="signUp" value="Registrieren">
                </div>
            </div>
        </div>
        <footer>
            <div class="footer">
                <div class="footertable" style="width: 100%">
                    <div>
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
            </div>
        </footer>
    </body>
</html>