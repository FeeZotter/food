<?php
//contains hashing and time
class UniversalLibrary
{
    /**
     *
     * Will focus on the parameters (name, password) or uses $_POST["loginName"] AND $_POST["loginPass"] 
     * @param string firstname AND
     * @param string password
     * @return string hashed password
     */
    public static function hashPass(): string
    {
        $n = "";
        $p = "";
        $numargs = func_num_args();
        if ($numargs == 2) {
            $n = func_get_arg(0);
            $p = func_get_arg(1);
        } else {
            $n = $_POST["loginName"];
            $p = $_POST["loginPass"];
        }
        return hash("sha256", $n . "meep" . $p);
    }

    public static function timeNow(): string
    {
        return date("H:i:s");
    }

    public static function dateNow(): string
    {
        return date("Y-m-d");
    }

    public static function weekdayNow(): string
    {
        return date("D");
    }

    public static function weekday($date): string
    {
        return date('w', strtotime($date));
    }

    public static function dateTimeNow(): string
    {
        return date("d-m-Y (D) H:i:s");
    }

    /**
     * stringRandomNumber(string $seed) || stringRandomNumber(string $seed, int $min, int $max)
     * @param string $seed
     * @param int $min
     * @param int $max
     */
    public static function stringRandomNumber(string $seed): int
    {
        $IntSeed = crc32($seed);
        srand($IntSeed);

        if (!func_num_args() == 3) {
            return rand();
        }
        if (!is_int(func_get_arg(1))) {
            return rand();
        }
        if (!is_int(func_get_arg(2))) {
            return rand();
        }

        return rand(func_get_arg(1), func_get_arg(2));
    }

    static function checkName($name): bool
    {
        if (!preg_match("/[a-z]/i", $name))
            return false;
        return self::checkWordlenght($name, 2, 32);
    }

    static function checkPassword($name): bool
    {
        if (!preg_match("/[a-z]/i", $name))
            return false;
        return self::checkWordlenght($name, 12, 32);
    }

    static function checkWordlenght(string $string, int $min, int $max): bool
    {
        if (strlen($string) > $max)
            return false;
        if (strlen($string) < $min)
            return false;
        return true;
    }
    /**explode time and convert into seconds */
    static function explode_time($time): int
    {
        $time = explode(':', $time);
        $time = $time[0] * 3600 + $time[1] * 60;
        return $time;
    }
    /**convert seconds to hh:mm */
    static function second_to_hhmm($time): string
    {
        $hour = floor($time / 3600);
        $minute = strval(floor(($time % 3600) / 60));
        if ($minute == 0) {
            $minute = "00";
        } else {
            $minute = $minute;
        }
        $time = $hour . ":" . $minute;
        return $time;
    }
}
