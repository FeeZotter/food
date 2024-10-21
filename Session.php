<?php
include_once("./DBSrc/DMLModules.php");
class Session
{
    static public function innit(): void
    {
        session_start();
        $_SESSION["login"] = false;
        $_SESSION["userName"] = "";
        if (!isset($_SESSION["login"]))
            {}
    }

    static public function killSession(): bool
    {
        session_start();
        session_unset(); 
        return session_destroy();
    }
    
    static public function loginSession(): bool
    {
        if (!isset($_POST["userName"])) { return false; }
        if (!isset($_POST["userPassword"])) { return false; }
        if (!DMLModules::loginSuccess($_POST["userName"], $_POST["userPassword"])) { return false; }
        $_SESSION["userName"] = $_POST["userName"];
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
 