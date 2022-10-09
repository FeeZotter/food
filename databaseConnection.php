<?php

    class DBConnection
    {
        private string $servername = "localhost";
        private string $username = "foodServer";
        private string $password = "iWouldLikeToKnowSomeFööd";
        private string $dbname = "mysql";
        private string $tableName = "food_fee";
        private string $sql = "";
        private mysqli $conn;
       
        private string $tableId = "ID_Food_fee";
        private string $tableContent = 'food';
        private string $tableRating = 'rating';

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

        function getContentTable()
        {
            $contentTable = "";
        
            $sql = "SELECT $this->tableId, 
                           $this->tableContent, 
                           $this->tableRating 
                    FROM   $this->tableName";
                    
            $result = $this->conn->query($sql);
        
            if ($result->num_rows > 0) 
            {
                // output data of each row
                while($row = $result->fetch_assoc()) 
                {
                    $contentTable = $contentTable. 
                    "<tr 
                        class='color" . $row[$this->tableRating]  . "'>"
                        . "<td><b>"   . $row[$this->tableContent] . "</b</td>"
                        . "<td><b>"   . $row[$this->tableRating]  . "</b></td>"
                    ."</tr>";
                }
            } 
            else 
            {
                $contentTable = "0 results";
            }
            return $contentTable;
        }

        function addContent(string $content, int $rating)
        {
            $echo = "";
            trim($content, " \n\r\t\v\x00");
            $content = mysqli_real_escape_string($this->conn, $content);
            $rating  = mysqli_real_escape_string($this->conn, $rating);
            $this->sql = "SELECT $this->tableContent, 
                                 $this->tableRating 
                          FROM   $this->tableName 
                          WHERE  $this->tableContent='$content'";

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
                echo $echo;
            }
            else
            {
                //add new content
                //this does not work
                $this->sql = "INSERT INTO $this->tableName 
                                        ($this->tableContent, 
                                         $this->tableRating) 
                              VALUES ('$content', 
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
        
        function __destruct() 
        {
            $this->conn->close();
        }
    }
?>