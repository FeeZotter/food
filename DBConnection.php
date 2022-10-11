<?php
    //manages every DB connection
    //functions:
    //getTableName()    |42   |offline             |
    //setTableName()    |43   |offline             |
    //addContent()      |62   |                    |$tableName, $tableContent, $tableRating, $content, $rating
    //deleteContent()   |128  |unfinished          |$tableName, $tableContent, $content
   
    class DBConnection
    {
        private $servername = "localhost";
        private $username = "foodServer";
        private $password = "iWouldLikeToKnowSomeFööd";
        private $dbname = "mysql";
        private mysqli $conn;

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
    }
?>