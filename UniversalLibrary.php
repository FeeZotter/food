<?php
//contains hashing and time
class UniversalLibrary
{

    public static function hashPass($password): string
    {
        return hash("sha256", "'" . $password . "'");
    }

    static function validName($accountname): bool
    {
        if(!preg_match("/[a-z]/i", $accountname))
            return false;
        return self::validWordLength($accountname, 5, 32);
    }

    static function validPassword($password): bool
    {
        if(!preg_match("/[a-z]/i", $password))
            return false;
        return self::validWordLength($password, 5, 50);
    }

    static function validWordLength(string $string, int $min, int $max): bool
    {
        if (strlen($string) > $max)
            return false;
        if (strlen($string) < $min)
            return false;
        return true;
    }
}
