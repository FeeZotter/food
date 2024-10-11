<?php
//contains hashing and time
class UniversalLibrary
{

    public static function hashPass($password): string
    {
        return hash("sha256", "'" . $password . "'");
    }

    public static function validName($accountname): bool
    {
        include_once("./config.php");
        if(!preg_match($nameRegex, $accountname))
            return false;
        return self::validWordLength($accountname, $nameMinLength, $nameMaxLength);
    }

    public static function validPassword($password): bool
    {
        include_once("./config.php");
        if(!preg_match($passRegex, $password))
            return false;
        return self::validWordLength($password, $passMinLength, $passMaxLength);
    }

    public static function validWordLength(string $string, int $min, int $max): bool
    {
        if (strlen($string) > $max)
            return false;
        if (strlen($string) < $min)
            return false;
        return true;
    }

    public static function validKey($key) : bool {
        if (!preg_match("#^[a-zA-Z0-9]+$#", $key))
            return false;
        if (strlen($key) != 32)
            return false;
        return true
    }
}
