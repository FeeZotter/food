<?php
    class DBConnection
    {
        private $conn;

        function __construct($servername, $username, $password, $dbname)
        {
            $this->conn = new mysqli($servername, 
                                     $username, 
                                     $password, 
                                     $dbname);

            if ($this->conn->connect_error) 
            {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }   

        function __destruct() 
        {
            $this->conn->close();
        }

        function getConnection(){ return $this->conn; }
    }
?>