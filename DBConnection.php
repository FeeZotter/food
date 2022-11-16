<?php
    class DBConnection
    {
        private $conn;

        function __construct()
        {
            $this->conn = new mysqli("localhost", 
                                     "mypref", 
                                     "wH5dKtdFaUe3wbX", 
                                     "mypreferences");

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