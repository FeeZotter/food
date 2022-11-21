<?php
    class DB
    {
        static private ?DB $instance = null;
        static private $conn;

        private function __construct()
        {
            self::$conn = new mysqli("localhost", 
                                     "mypref", 
                                     "wH5dKtdFaUe3wbX", 
                                     "mypreferences");

            if (self::$conn->connect_error) 
            {
                die("Connection failed: " . self::$conn->connect_error);
            }
        }   

        function __destruct() 
        {
            self::$conn->close();
        }

        static function connection() 
        {
            if (self::$instance == null)
            {
                self::$instance = new DB();
            }
            return self::$conn; 
        }
    }
?>