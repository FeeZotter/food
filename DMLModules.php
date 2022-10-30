<?php
    include('DBConnection.php');
    class DMLModules
    {
        private $db;
        private mysqli $dbconn;

        function __construct()
        {
            include('serverconfig.php');

            $this->db = new DBConnection($servername, $username, $password, $dbname);
            $this->dbconn = $this->db->getConnection();;
        } 

        function addContent(
                            $user,
                            $password,
                            $preference,
                            $rating, 
                            $cross_person_categories_id)
        {
            //trim empty spaces from $preference
            trim($preference, " \n\r\t\v\x00");
            
            //anti SQL injection
            mysqli_real_escape_string($this->dbconn, $user);
            mysqli_real_escape_string($this->dbconn, $password);
            mysqli_real_escape_string($this->dbconn, $preference);
            mysqli_real_escape_string($this->dbconn, $rating);
            mysqli_real_escape_string($this->dbconn, $cross_person_categories_id);
        }

        function deleteContent(string $from,  
                               string $where, 
                               string $eqals) 
        {
            //anti SQL injection
            mysqli_real_escape_string($this->dbconn, $from);
            mysqli_real_escape_string($this->dbconn, $where);
            mysqli_real_escape_string($this->dbconn, $eqals);

            //try sql delete
            $sql = "DELETE FROM $from
                    WHERE       $where = '$eqals'";

            if(mysqli_query($this->dbconn, $sql))
            {
                $echo = "'$eqals' deleted successfully";
            } 
            else
            {
                $echo = "ERROR: Could not able to execute " . $sql . ". " . $this->dbconn->connect_error;
            }
            echo $echo;
        }

        public function getTable($select, $from)
        {
            //anti SQL injection
            mysqli_real_escape_string($this->dbconn, $select);
            mysqli_real_escape_string($this->dbconn, $from);
            
            //try sql selection
            $sql = "SELECT $select FROM $from";
            $result = mysqli_query($this->dbconn ,$sql);

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

        public function getTableWhere($select, $from, $where)
        {
            //anti SQL injection
            mysqli_real_escape_string($this->dbconn, $select);
            mysqli_real_escape_string($this->dbconn, $from);
            mysqli_real_escape_string($this->dbconn, $where);
            //try sql selection
            $sql = "SELECT $select FROM $from WHERE $where";
            $result = mysqli_query($this->dbconn ,$sql);
            
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

        public function getFirstMatchValue($select, $from, $where)
        {
             //anti SQL injection
             mysqli_real_escape_string($this->dbconn, $select);
             mysqli_real_escape_string($this->dbconn, $from);
             mysqli_real_escape_string($this->dbconn, $where);
             //try sql selection
             $sql = "SELECT $select FROM $from WHERE $where";
 
             $result = mysqli_query($this->dbconn ,$sql);
             
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