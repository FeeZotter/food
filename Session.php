<?php
include_once("./Cookie.php");
include_once("./SQL.php");
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
        if (SQL::checkLoginRights($_POST["loginName"], $_POST["loginPass"]) == null) { return false; }// need update

        $_SESSION["login"] = true;
        self::checkRights($_POST["loginName"], $_POST["loginPass"]);
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
