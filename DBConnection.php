<?php
    class DBConnection
    {
        private $servername;
        private $username;
        private $password;
        private $dbname;
        private $conn;

        function __construct($servername, $username, $password, $dbname)
        {
            $this->servername = $servername;
            $this->username   = $username;
            $this->password   = $password;
            $this->dbname     = $dbname;
 
            $this->conn = new mysqli($this->servername, 
                                     $this->username, 
                                     $this->password, 
                                     $this->dbname);

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