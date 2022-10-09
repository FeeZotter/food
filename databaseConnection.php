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
        private $tableId = "ID_Food_Fee";
        private $tableContent = 'food';
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

        function getData()
        {

        }

        function setData()
        {
            $food = mysqli_real_escape_string($this->conn, $_REQUEST['food']);
            $rating = mysqli_real_escape_string($this->conn, $_REQUEST['rating']);
            $this->sql = "SELECT $this->tableContent, 
                           $this->tableRating 
                    FROM   $this->tableName 
                    WHERE  $this->tableContent='$food'";

            $result = $this->conn->query($this->sql);

            if(mysqli_num_rows($result) != 0)
            {
                while($row = $result->fetch_assoc()) {
                    if($row["$this->tableRating "] == $rating)
                    {
                        //add new food
                        $this->sql = "UPDATE $this->tableName 
                                SET $this->tableRating = '$rating' 
                                WHERE $this->tableContent = '$food'";

                        // Attempt insert query execution
                        if(mysqli_query($this->conn, $this->sql)){
                        //   echo "Food added successfully.";
                            echo ("'$food' rating changed to '$rating'");
                        } else{
                            echo "ERROR: Could not able to execute $this->sql. " . mysqli_error($link);
                        }
                    }
                }
                echo "$food already exists";
            }
            else
            {
            //add new food
                $this->sql = mysqli_real_escape_string(
                    "INSERT INTO $this->tableName 
                               ('$this->tableContent', 
                                '$this->tableRating') 
                     VALUES ('$food', 
                             '$rating')");

                // Attempt insert query execution
                if(mysqli_query($this->conn, $this->sql))
                {
                    echo ("'$food' added successfully");
                } else{
                    echo "ERROR: Could not able to execute $this->sql. " . mysqli_error($link);
                }
            }
        }

        function changeData()
        {

        }
        
        function __destruct() {
            $this->conn->close();
        }
    }
?>

$conn = new mysqli($conf_servername, 
                       $conf_username, 
                       $conf_password, 
                       $conf_dbname);

                       $conn = new mysqli($conf_servername, 
                       $conf_username, 
                       $conf_password, 
                       $conf_dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape user inputs for security
    $food = mysqli_real_escape_string($conn, $_REQUEST['food']);
    $rating = mysqli_real_escape_string($conn, $_REQUEST['rating']);

    //check if entry exists
    $sql = "SELECT $conf_tableContent, 
                   $conf_tableRating 
            FROM $conf_tableName 
            WHERE $conf_tableContent='$food'";

    $result = $conn->query($sql);

    if(mysqli_num_rows($result) != 0)
    {
        while($row = $result->fetch_assoc()) {
            if($row["$conf_tableRating "] == $rating)
            {
                //add new food
                $sql = "UPDATE $conf_tableName 
                        SET $conf_tableRating = '$rating' 
                        WHERE $tableContent = '$food'";

                // Attempt insert query execution
                if(mysqli_query($conn, $sql)){
                //   echo "Food added successfully.";
                    echo ("'$food' rating changed to '$rating'");
                } else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }
            }
        }
        echo "$food already exists";
    }
    else
    {
        //add new food
        $sql = mysqli_real_escape_string(
            "INSERT INTO $conf_tableName ("$conf_tableContent", "$conf_tableRating") 
            VALUES ("$food", "$rating")");

        // Attempt insert query execution
        if(mysqli_query($conn, $sql))
        {
            echo ("'$food' added successfully");
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }

    $conn->close();