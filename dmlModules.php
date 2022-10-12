<?php
    function addContent(mysqli $db,
                        string $tableName, 
                        string $tableContent, 
                        string $tableRating,
                        string $content, 
                        int    $rating)
    {
        $echo = "";
        trim($content, " \n\r\t\v\x00");
        $content = mysqli_real_escape_string($db, $content);
        $rating  = mysqli_real_escape_string($db, $rating);
        $sql = "SELECT $tableContent, 
                       $tableRating 
                FROM   $tableName 
                WHERE  $tableContent='$content'";

        $result = $db->query($sql);

        if(mysqli_num_rows($result) == 0)
        {
            while($row = $result->fetch_assoc()) 
            {
                if($row["$this->tableRating"] == $rating)
                {
                    $echo = "$content already exists";
                }
                else
                {
                    //change rating of content
                    $this->sql = "UPDATE $this->tableName 
                                  SET    $this->tableRating  = '$rating' 
                                  WHERE  $this->tableContent = '$content'";

                    // Attempt insert query execution
                    if(mysqli_query($db, $sql))
                    {
                        $echo = "'$content' rating changed to '$rating'";
                    } 
                    else
                    {
                        $echo = 'ERROR: Could not able to execute ' . $sql . '. ' . $db->connect_error;
                    }
                }
            }
        }
        else
        {
            //add new content
            //this does not work
            $sql = "INSERT INTO $tableName 
                               ($tableContent, 
                                $tableRating) 
                    VALUES    ('$content', 
                               '$rating')";

            // Attempt insert query execution || here is an error
            if(mysqli_query($db, $sql))
            {
                $echo = "'$content' added successfully";
            } 
            else
            {
                $echo = "ERROR: Could not able to execute " . $sql . ". " . $db->connect_error;
            }
        }
        echo $echo;
    }

    function deleteContent(mysqli $db,
                           string $tableName,  
                           string $tableContent, 
                           string $content) 
        {
            $sql = "DELETE FROM $tableName
                    WHERE       $tableContent = '$content'";

            if(mysqli_query($db, $sql))
            {
                $echo = "'$content' deleted successfully";
            } 
            else
            {
                $echo = "ERROR: Could not able to execute " . $sql . ". " . $db->connect_error;
            }
            echo $echo;
        }
?>