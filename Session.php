<?php
include_once("./DBSrc/DMLModules.php");
class Session
{
    static public function innit(): void
    {
        session_start();
        if (!isset($_SESSION["login"]))
            {}
    }

    static public function killSession(): bool
    {
        session_start();
        return session_destroy();
    }
    
    static public function loginSession(): bool
    {
        if (!isset($_POST["loginPass"])) { return false; }
        if (!isset($_POST["loginName"])) { return false; }
        if (!DMLModules::loginSuccess($_POST["loginName"], $_POST["loginPass"])) { return false; }// need update
        
        $_SESSION["login"] = true;
        return true;
    }

    static public function isLogin(): bool
    {
        if (isset($_SESSION["login"]))
            if ($_SESSION["login"])
                return true;
        return false;
    }
}
 