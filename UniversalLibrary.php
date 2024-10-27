<?php
//contains hashing and time
class UniversalLibrary
{
    private static $preferenceLimitForFreeAccounts = 20; // int or null
    private static $keyMaxUsers = 100; // only limits during creation via admin interface
    private static $nameRegex = "/^[a-z]{0,10}$/g";
    private static $passRegex = "/^[a-z]{0,10}$/g";
    private static $keyRegex  = "/^[a-zA-Z0-9]{32,32}$/g";

    public static function getPreferenceLimitForFreeAccounts()  : int { return self::$preferenceLimitForFreeAccounts; }
    public static function getKeyMaxUsers() : int    { return self::$keyMaxUsers; }
    public static function getNameRegex()   : string { return self::$nameRegex;   }
    public static function getPassRegex()   : string { return self::$passRegex;   }
    public static function getKeyRegex()    : string { return self::$keyRegex;    }


    public static function hashPass($password): string
    {
        return hash("sha256", "'" . $password . "'");
    }

    public static function validName($accountname): bool
    {
        if(preg_match(self::$nameRegex, $accountname))
            return true;
        return false;
    }

    public static function validPassword($password): bool
    {
        if(preg_match(self::$passRegex, $password))
            return true;
        return false;
    }

    public static function validWordLength(string $string, int $min, int $max): bool
    {
        if (preg_match("/^.{" . $min . "," . $max . "}$/g", $string))
            return true;
        return false;
    }

    public static function validKey($key) : bool {
        if (preg_match(self::$keyRegex, $key))
            return true;
        return false;
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
