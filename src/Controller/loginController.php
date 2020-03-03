<?php 
    include 'connectorController.php';
    session_start();
    
    signUp("Timo", "timoadelmann@gmail.com", "69ForLife", "Developer");
    //signUp("Jamie", "jolo@gmail.com", "Jolo69", "Developer");
    
    
    function showAllUser()
    {
        connectPDO();
        $pdo = $_SESSION['conn'];
        $statement = $pdo->query("SELECT Username FROM `User`");
        $user = $statement->fetchAll();
        
        foreach($user as $username)
        {
            echo $username['Username'];
        }
    }

    function login ($username, $password)
    {
        if(isset($_SESSION))
        {
            session_destroy();
        }
        session_start();
        connectPDO();
        $pdo = $_SESSION['conn'];
        if ($username !== null && $password !== null)
        {
            $statement = $pdo->prepare("SELECT * FROM `User` WHERE Username = ? OR Email = ?");
            $statement->execute([$username, $username]);
            $user = $statement->fetch();

            if($user === true && password_verify($password, $user['Password']))
            {
                $_SESSION['userId'] = $user['UserId'];
                $_SESSION['email'] = $user['Email'];
                $_SESSION['username'] = $user['Username'];
                $_SESSION['usertype'] = $user['Usertype'];
            } else {
                $_SESSION['error'] =  "Bitte überprüfen sie Ihre Nutzerdaten";
            }
        }
        closePDO();
    }
    
    function signUp ($username, $email, $password, $usertype)
    {
        $passwordHash = hash('md5', $password);
        
        connectPDO();
        if (isset($_SESSION['conn']))
        {
            $pdo = $_SESSION['conn'];
            if($username !== null && $passwordHash !== null && $email !== null && $usertype !== null)
            {
                $statement = $pdo->prepare("INSERT INTO `User` (username, email, passwort, usertype) VALUES (?, ?, ?, (SELECT UsertypeId FROM `Usertype` WHERE `Usertype` = ?))");
                $user = $statement->execute([$username, $email, $passwordHash, $usertype]);
                echo $username;

                if($user === true)
                {
                    login($username, $password);
                }
            }
        }
    }
