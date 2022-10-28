<?php
    class DMLModules
    {
        /*
        function addContent($db,
                            $preference,
                            $rating, 
                            $cross_person_categories_id)
        {
            //trim empty spaces from $preference
            trim($preference, " \n\r\t\v\x00");
            
            //anti SQL injection
            mysqli_real_escape_string($db, $preference);
            mysqli_real_escape_string($db, $rating);
            mysqli_real_escape_string($db, $cross_person_categories_id);
        }*/

        function deleteContent(mysqli $db,
                               string $from,  
                               string $where, 
                               string $eqals) 
        {
            //anti SQL injection
            mysqli_real_escape_string($db, $from);
            mysqli_real_escape_string($db, $where);
            mysqli_real_escape_string($db, $eqals);

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
            mysqli_real_escape_string($db, $select);
            mysqli_real_escape_string($db, $from);
            
            //try sql selection
            $sql = "SELECT $select FROM $from";
            $result = mysqli_query($db ,$sql);

            //compose array from data
            $data = null;
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
            mysqli_real_escape_string($db, $select);
            mysqli_real_escape_string($db, $from);
            mysqli_real_escape_string($db, $where);
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

        public function getFirstMatchValue($db, $select, $from, $where)
        {
             //anti SQL injection
             mysqli_real_escape_string($db, $select);
             mysqli_real_escape_string($db, $from);
             mysqli_real_escape_string($db, $where);
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
             return $data[0];
        }
    }
?>