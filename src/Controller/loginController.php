<?php 
    include 'connectorController.php';
    session_start();
    
    signUp("Timo", "timoadelmann@gmail.com", "69ForLife", "Developer", ["YoloTrollMaster69", "WASGEHTAB"]);
    //signUp("Jamie", "jolo@gmail.com", "Jolo69", "Developer");
    //login("Timo", "69ForLife");
    //addPrivileges(["IAMBORED"]);
    
    
    function showAllUser()
    {
        connectPDO();
        $pdo = $_SESSION['conn'];
        $getAllUser = $pdo->query("SELECT Username FROM `User`");
        $user = $getAllUser->fetchAll();
        
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
            $getUser = $pdo->prepare("SELECT * FROM `User` WHERE Username = ? OR Email = ?");
            $getUser->execute([$username, $username]);
            $user = $statement->fetch();

            if(password_verify($password, $user['Password']))
            {
                $_SESSION['email'] = $user['Email'];
                $_SESSION['username'] = $user['Username'];
                $_SESSION['usertype'] = $user['Usertype'];
            } else {
                $_SESSION['error'] =  "Bitte überprüfen sie Ihre Nutzerdaten";
            }
        }
        closePDO();
    }
    
    function signUp ($username, $email, $password, $usertype, array $privilege)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        connectPDO();
        if (isset($_SESSION['conn']))
        {
            $pdo = $_SESSION['conn'];
            
            if($username !== null && $passwordHash !== null && $email !== null && $usertype !== null)
            {
                $addUser = $pdo->prepare("INSERT INTO `User` (username, email, password, usertype) VALUES (?, ?, ?, (SELECT UsertypeId FROM `Usertype` WHERE `Usertype` = ?))");
                $success = $addUser->execute([$username, $email, $passwordHash, $usertype]);

                if($success === true)
                {
                    foreach($privilege as $privilegeString)
                    {
                        $getPrivilege = null;
                        $getPrivilege = $pdo->prepare("SELECT PrivilegeId FROM Privilege WHERE Privilege = ?");
                        $getPrivilege->execute([$privilegeString]);
                        
                        if(!$privilegeId = $getPrivilege->fetch(PDO::FETCH_ASSOC))
                        {
                            $addPrivilege = $pdo->prepare("INSERT INTO Privilege (Privilege) VALUES (?)");
                            $addPrivilege->execute([$privilegeString]);
                            
                            $getPrivilege = $pdo->query("SELECT MAX(PrivilegeId) AS PrivilegeId FROM Privilege WHERE Privilege = ?");
                            $privilegeId = $getPrivilege->fetch(PDO::FETCH_ASSOC);
                        }
                        
                        if($privilegeId)
                        {
                            $checkPrivilege = $pdo->prepare("SELECT * FROM User_Privilege WHERE User = (SELECT MAX(UserId) FROM User) AND Privilege = ?");
                            $checkPrivilege->execute([$privilegeId["PrivilegeId"]]);

                            if(!$checkPrivilege->fetch())
                            {
                                $addUserPrivilege = $pdo->prepare("INSERT INTO User_Privilege (User, Privilege) VALUES ((SELECT MAX(UserID) FROM `User`), ?)");
                                $addUserPrivilege->execute([$privilegeId["PrivilegeId"]]);
                            }
                        }
                    } 
                    
                    closePDO();
                    login($username, $password);  
                }
            }
        }
    }
        
    function addPrivileges(array $privilege)
    {
        connectPDO();
        if (isset($_SESSION['conn']))
        {
            $pdo = $_SESSION['conn'];
            var_dump($_SESSION['username']);
            
            if(isset($_SESSION['username']))
            {
                $getUser = $pdo->prepare("SELECT UserId FROM `User` WHERE Username = ?");
                $getUser->execute([$_SESSION['username']]);
                $userId = $statement->fetch();
                
                foreach($privilege as $privilegeString)
                {
                    $getPrivilege = null;
                    $getPrivilege = $pdo->prepare("SELECT PrivilegeId FROM Privilege WHERE Privilege = ?");
                    $getPrivilege->execute([$privilegeString]);
                    
                    if(!$privilegeId = $getPrivilege->fetch(PDO::FETCH_ASSOC))
                    {
                        $addPrivilege = $pdo->prepare("INSERT INTO Privilege (Privilege) VALUES (?)");
                        $addPrivilege->execute([$privilegeString]);
                        
                        $getPrivilege = $pdo->query("SELECT MAX(PrivilegeId) AS PrivilegeId FROM Privilege WHERE Privilege = ?");
                        $privilegeId = $getPrivilege->fetch(PDO::FETCH_ASSOC);
                    }
                    
                    if($privilegeId)
                    {
                        $checkPrivilege = $pdo->prepare("SELECT * FROM User_Privilege WHERE User = (SELECT MAX(UserId) FROM User) AND Privilege = ?");
                            $checkPrivilege->execute([$privilegeId["PrivilegeId"]]);

                        if(!$checkPrivilege->fetch(PDO::FETCH_ASSOC))
                        {
                            $addUserPrivilege = $pdo->prepare("INSERT INTO User_Privilege (User, Privilege) VALUES ((SELECT MAX(UserID) FROM `User`), ?)");
                            $addUserPrivilege->execute([$privilegeId["PrivilegeId"]]);
                        }
                    }
                }
            }
        }
        closePDO();
    }
