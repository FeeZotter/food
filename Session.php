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
    
    static public function loginSession(string $name, string $password): bool
    {
        if (!DMLModules::loginSuccess($name, $password)) 
        {
            http_response_code(401); 
            return false; 
        }
        $_SESSION["name"] = $name;
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
    static public function user() : string
    {
        if (isset($_SESSION["name"]))
            return $_SESSION["name"];
        return "";
    }
}
 