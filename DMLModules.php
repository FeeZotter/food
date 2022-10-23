<?php
    class DMLModules
    {
        function addContent($db,
                            $preference,
                            $rating, 
                            $cross_person_categories_id)
        {
            //trim empty spaces from $preference
            trim($preference, " \n\r\t\v\x00");
            
            //anti SQL injection
            $preference                 = mysqli_real_escape_string($db, $preference);
            $rating                     = mysqli_real_escape_string($db, $rating);
            $cross_person_categories_id = mysqli_real_escape_string($db, $cross_person_categories_id);
            
            $array = getTableWhere($db, "$preference, $rating", "cross_person_categories='$cross_person_categories_id'");

            if(sizeof($array) == 0)
            {
                //when entry already exists
                foreach($array as $row) 
                {
                    if($row["$this->rating"] == $rating)
                    {
                        $echo = "$preference already exists";
                    }
                    else
                    {
                        //change rating of content
                        $this->sql = "UPDATE $this->preferences 
                                      SET    $this->rating      = '$rating' 
                                      WHERE  $this->preference  = '$preference'";

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
                //when entry not exists
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
                               string $from,  
                               string $where, 
                               string $eqals) 
        {
            //anti SQL injection
            $from  = mysqli_real_escape_string($db, $from);
            $where = mysqli_real_escape_string($db, $where);
            $eqals = mysqli_real_escape_string($db, $eqals);

            //try sql delete
            $sql = "DELETE FROM $from
                    WHERE       $where = '$eqals'";

            if(mysqli_query($db, $sql))
            {
                $echo = "'$eqals' deleted successfully";
            } 
            else
            {
                $echo = "ERROR: Could not able to execute " . $sql . ". " . $db->connect_error;
            }
            echo $echo;
        }

        public function getTable($db, $select, $from)
        {
            //anti SQL injection
            $select = mysqli_real_escape_string($db, $select);
            $from = mysqli_real_escape_string($db, $from);
            
            //try sql selection
            $sql = "SELECT $select FROM $from";
            $result = mysqli_query($db ,$sql);

            //compose array from data
            $data;
            if ($result)
            {
                while($row = $result->fetch_assoc())
                {
                    $data[] = $row[$select];
                }
            }
            return $data;
        }

        public function getTableWhere($db, $select, $from, $where)
        {
            //anti SQL injection
            $select = mysqli_real_escape_string($db, $select);
            $from = mysqli_real_escape_string($db, $from);
            $where = mysqli_real_escape_string($db, $where);
 
            //try sql selection
            $sql = "SELECT $select FROM $from WHERE $where";
            $result = mysqli_query($db ,$sql);
            
            //compose array from data
            $data = array();
            if ($result)
            {
                while($row = $result->fetch_assoc())
                {
                    $data[] = $row;
                  
                }
            }
            return $data;
        }
    }
?>