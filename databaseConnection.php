<?php

    class DBConnection
    {
        private $servername = "localhost";
        private $username = "foodServer";
        private $password = "iWouldLikeToKnowSomeFööd";
        private $dbname = "mysql";
        private $tableName = "food_fee";
        private $sql = "";
        private $conn;
       
        private $tableId = "ID_Food_fee";
        private $contentTable = 'food';
        private $tableRating = 'rating';

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
                           $this->contentTable, 
                           $this->tableRating 
                    FROM   $this->tableName";
            $result = $this->conn->query($sql);
        
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $contentTable = $contentTable. 
                    "<tr 
                        class='color" . $row[$this->tableRating]  . "'>"
                        . "<td><b>"   . $row[$this->contentTable] . "</b</td>"
                        . "<td><b>"   . $row[$this->tableRating]  . "</b></td>"
                    ."</tr>";
                }
            } else {
                $contentTable = "0 results";
            }
            return $contentTable;
        }

        function addContent($content, $rating)
        {
            $content = mysqli_real_escape_string($this->conn, $content);
            $rating = mysqli_real_escape_string($this->conn, $rating);
            $this->sql = "SELECT $this->contentTable, 
                                 $this->tableRating 
                          FROM   $this->tableName 
                          WHERE  $this->contentTable='$content'";

            $result = $this->conn->query($this->sql);

            if(mysqli_num_rows($result) != 0)
            {
                while($row = $result->fetch_assoc()) {
                    if($row["$this->tableRating "] == $rating)
                    {
                        //add new conten$content
                        $this->sql = "UPDATE $this->tableName 
                                SET $this->tableRating = '$rating' 
                                WHERE $this->contentTable = '$content'";

                        // Attempt insert query execution
                        if(mysqli_query($this->conn, $this->sql)){
                        //   echo "conten$content added successfully.";
                            echo ("'$content' rating changed to '$rating'");
                        } else{
                            echo "ERROR: Could not able to execute $this->sql. " . mysqli_error($link);
                        }
                    }
                }
                echo "$content already exists";
            }
            else
            {
            //add new conten$content
                $this->sql = mysqli_real_escape_string($this->conn,
                            "INSERT INTO $this->tableName 
                                       ('$this->contentTable', 
                                        '$this->tableRating') 
                             VALUES ('$content', 
                                     '$rating')");

                // Attempt insert query execution || here is an error
                if(mysqli_query($this->conn, $this->sql))
                {
                    echo ("'$content' added successfully");
                } else{
                    echo "ERROR: Could not able to execute $this->sql. " . mysqli_error($link);
                }
            }
        }
        
        function __destruct() {
            $this->conn->close();
        }
    }
?>