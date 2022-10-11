<?php
    //manages every DB connection
    //functions:
    //getTableName()    |39   |offline
    //setTableName()    |40   |offline
    //getContentTable() |52   |need to return list
    //addContent()      |67
    //deleteContent()   |133  |unfinished
    class DBConnection
    {
        private $servername = "localhost";
        private $username = "foodServer";
        private $password = "iWouldLikeToKnowSomeFööd";
        private $dbname = "mysql";
        private $sql = "";
        private mysqli $conn;

        //private $tableName = "food_fee";
        //private $tableId = "ID";
        //private $tableContent = 'food';
        //private $tableRating = 'rating';

        function __construct()
        {
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

        //function getTableName() { return $this->tableName; }
        //function setTableName(string $table) 
        //{ 
        //    $this->sql = "SELECT $this->tableId, 
        //                    $this->tableContent, 
        //                    $this->tableRating 
        //            FROM    $table";
        //    if(mysqli_query($this->conn, $this->sql))
        //        $this->tableName = mysqli_real_escape_string($this->conn, $table);; 
        //}


        function getContentTable(string $tableName, 
                                 string $tableId, 
                                 string $tableContent, 
                                 string $tableRating)
        {
            $contentTable = "";
        
            $this->sql = "SELECT $tableId, 
                                 $tableContent, 
                                 $tableRating 
                          FROM   $tableName";
                    
            return $this->conn->query($this->sql);
        }

        function addContent(string $tableName, 
                            string $tableContent, 
                            string $tableRating,
                            string $content, 
                            int    $rating)
        {
            $echo = "";
            trim($content, " \n\r\t\v\x00");
            $content = mysqli_real_escape_string($this->conn, $content);
            $rating  = mysqli_real_escape_string($this->conn, $rating);
            $this->sql = "SELECT $tableContent, 
                                 $tableRating 
                          FROM   $tableName 
                          WHERE  $tableContent='$content'";

            $result = $this->conn->query($this->sql);

            if(mysqli_num_rows($result) != 0)
            {
                while($row = $result->fetch_assoc()) {
                    if($row["$this->tableRating"] != $rating)
                    {
                        //change rating of content
                        $this->sql = "UPDATE $this->tableName 
                                      SET $this->tableRating    = '$rating' 
                                      WHERE $this->tableContent = '$content'";

                        // Attempt insert query execution
                        if(mysqli_query($this->conn, $this->sql))
                        {
                            $echo = "'$content' rating changed to '$rating'";
                        } 
                        else
                        {
                            $echo = "ERROR: Could not able to execute $this->sql. " . $this->conn->connect_error;
                        }
                    }
                    else
                    {
                        $echo = "$content already exists";
                    }
                }
            }
            else
            {
                //add new content
                //this does not work
                $this->sql = "INSERT INTO $tableName 
                                         ($tableContent, 
                                          $tableRating) 
                              VALUES    ('$content', 
                                         '$rating')";

                // Attempt insert query execution || here is an error
                if(mysqli_query($this->conn, $this->sql))
                {
                    $echo = "'$content' added successfully";
                } 
                else
                {
                    $echo = "ERROR: Could not able to execute $this->sql. " . $this->conn->connect_error;
                }
            }
            echo $echo;
        }

        function deleteContent(string $tableName,  
                               string $tableContent, 
                               string $content) 
        {
            $this->sql = "DELETE FROM $tableName
                          WHERE       $tableContent = '$content'";
            if(mysqli_query($this->conn, $this->sql))
            {
                $echo = "'$content' deleted successfully";
            } 
            else
            {
                $echo = "ERROR: Could not able to execute $this->sql. " . $this->conn->connect_error;
            }
            echo $echo;
        }
    }
?>