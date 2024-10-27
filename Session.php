<?php
include_once("./DBSrc/DMLModules.php");
class Session
{
    static public function innit(): void
    {
        if(!session_id())
        {
            session_start();
            $_SESSION["login"] = false;
            $_SESSION["name"] = "";
        }
    }

    static public function killSession(): bool
    {
        session_start();
        session_unset(); 
        return session_destroy();
    }
    
    static public function loginSession(): bool
    {
        if (!isset($_POST["name"])) { return false; }
        if (!isset($_POST["password"])) { return false; }
        if (!DMLModules::loginSuccess($_POST["name"], $_POST["password"])) { return false; }
        $_SESSION["name"] = $_POST["name"];
        $_SESSION["login"] = true;
        return $_SESSION["login"];
    }

    static public function logout() : bool {
        $_SESSION["login"] = false;
        return !$_SESSION["login"];
    }

    static public function isLogin(): bool
    {
        if (isset($_SESSION["login"]))
            return $_SESSION["login"];
        return false;
    }
}
 