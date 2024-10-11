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
        return true;
    }

    public static function admin(string $name, string $password) : bool
    {
        if(hash('ripemd160', $name) != 'cbab26c4570a17bd673d64d6bc1f2df9d9b3206c')
            return false; //wrong name
        if(hash('ripemd160', $password) != '82f0b74a5e3581e346ecf2915ca6e806434d9863')
            return false; //wrong password
        return true; //no wrongs
    }    

    public static function generateNewKey() : string
    {
        include_once("./DBSrc/DMLModules.php");
        generateNewKey:
        $newKey = '';
        while (strlen($newKey) != 32) { $newKey .= UniversalLibrary::RandomLetter(); }
        if(DMLModules::keyExists($newKey))
            goto generateNewKey;
        return $newKey;
    }

    /**
     * returns one letter A-Z, a-z, 0-9
     */
    public static function RandomLetter() : string
    {
        $letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $randomletter = substr($letters, (rand(0, strlen($letters)-1)), 1);
        return $randomletter;
    }
}
