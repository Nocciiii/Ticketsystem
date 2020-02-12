<php? 
    function login ($username, $password)
    {
        session_destroy;
        session_start;
        $_SESSION['active'] = true;
        $pdo = $_SESSION['conn'];
        if ($username !== null && $password !== null)
        {
            $statement = $pdo->query("SELECT * FROM "User" u WHERE u.Username = :username OR u.Email = :email);
            $statement->execute(array('username' => $username, 'email' => $username));
            $user = $statement->fetch();

            if($user === true && password_verify($password, $user['Password']))
            {
                $_SESSION['userId'] = $user['UserId'];
                $_SESSION['email'] = $user['Email'];
                $_SESSION['username'] = $user['Username'];
                $_SESSION['usertype'] = $user['Usertype'];
            } else {
                $_SESSION['error'] = "Bitte überprüfen sie Ihre Nutzerdaten";
            }
        }
    }

    function connectPDO($user, $password, $servername, $dbname)
    {
        try {
            $_SESSION['conn'] = new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
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
        $_SESSION['conn'] = null;
    }
?>