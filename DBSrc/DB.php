<?php
    class DB
    {
        static private ?DB $instance = null;
        static private $conn;

        private function __construct()
        {
            include("config.php");
            self::$conn = new mysqli($hostname, 
                                     $username, 
                                     $password, 
                                     $database);

            if (self::$conn->connect_error) 
            {
                die("Connection failed: " . self::$conn->connect_error);
            }
        }   

        function __destruct() 
        {
            self::$conn->close();
        }

        static public function connection() 
        {
            if (self::$instance == null)
            {
                self::$instance = new DB();
            }
            return self::$conn; 
        }
    }
?>