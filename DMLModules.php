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

        ///////////////////////////////////////////
        ////////////////punlic tables//////////////
        public function getTable($select, $from)
        {
            //anti SQL injection
            mysqli_real_escape_string($this->dbconn, $select);
            mysqli_real_escape_string($this->dbconn, $from);
            
            //try sql selection
            $sql = "SELECT $select FROM $from ORDER BY $select ASC";
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
            $sql = "SELECT $select FROM $from WHERE $where ORDER BY $select ASC";
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

        public function getPreferenceTable($crossPersonCategoryID)
        {
            //anti SQL injection
            mysqli_real_escape_string($this->dbconn, $crossPersonCategoryID);
            
            //try sql selection
            $limit = "";
            $sql = "SELECT persons_id FROM cross_person_categories WHERE cross_person_categories_id='$crossPersonCategoryID'";
            $result = mysqli_query($this->dbconn ,$sql);
            $person_id = mysqli_fetch_row($result)[0];

            $sql = "SELECT product_key FROM persons WHERE name='$person_id'";
            $result = mysqli_query($this->dbconn ,$sql);
            $key = mysqli_fetch_row($result)[0];
            if(!$key)
            {
                $limit = "LIMIT 20";
                echo "<p class='deleteme'>The Owner of this list has no key so the visible entrys are limited to 20. </p> ";
            }

            $sql = "SELECT preference, rating 
                    FROM preferences 
                    WHERE cross_person_categories_id='$crossPersonCategoryID'
                    $limit";
                #    ORDER BY preference ASC, rating DESC";
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


        /////////////////////////////////////
        /////////single value////////////////
        private function getFirstMatchValue($select, $from, $where)
        {
            //anti SQL injection
            mysqli_real_escape_string($this->dbconn, $select);
            mysqli_real_escape_string($this->dbconn, $from);
            mysqli_real_escape_string($this->dbconn, $where);
            //try sql selection
            $sql = "SELECT $select FROM $from WHERE $where";
            
            //echo $sql; //when debug in next row is needed this helps
            $result = mysqli_query($this->dbconn ,$sql);
            
            return mysqli_fetch_row($result)[0];
        }

        public function getAlias($name)
        {
            return $this->getFirstMatchValue('alias', 'persons', "name='$name'");
        }

        public function getName($alias)
        {
            return $this->getFirstMatchValue('name', 'persons', "alias='$alias'");
        }

        public function getPersonCategoryIdByPersCate($persons_id, $category)
        {
            return $this->getFirstMatchValue('cross_person_categories_id', 'cross_person_categories', "persons_id='$persons_id'&&categories_id='$category'");
        }     
        
        public function getPersonCategoryIdByPreference($preferenceId)
        {
            return $this->getFirstMatchValue('cross_person_categories_id', 'preferences', "preferences_id='$preferenceId'");
        }  

        //////////////////////////////////
        /////////////Accounts/////////////
        public function addAccount($accountname, $alias, $password, $key)
        {
            /**
             * trys to add an account to the database
             *
             * @param accountname min 5, max 32 letters
             * @param alias min 5, max 32 letters
             * @param password 
             * @param key 32 letters, a-z, A-Z, 0-9 
             * 
             * @throws Some_Exception_Class If something interesting cannot happen
             * @return Status
             */ 

             //////////////////Error handeling
            $echo = "";
            //check accountname
            //if the accountname contains no letters throw an error
            if(!preg_match("/[a-z]/i", $accountname)){
                $echo .= "You need at least 1 alphabet letter in your Account name. ";
            }

            if(strlen($accountname) > 32)
            {
                $echo .= "A maximum of 32 Letters are allowed for the Account name. ";
            }

            if(strlen($accountname) < 5)
            {
                $echo .= "You need at least 5 Letters for the Account name. ";
            }

            //check alias
            if(!preg_match("/[a-z]/i", $alias)){
                $echo = "You need at least 1 alphabet letter in your public alias. ";
            }

            if(strlen($alias) > 32)
            {
                $echo .= "A maximum of 32 Letters are allowed for the public alias. ";
            }

            if(strlen($alias) < 5)
            {
                $echo .= "You need at least 5 Letters for the public alias. ";
            }

            //check Key
            if($key != "")
            {
                trim($key, " \n\r\t\v\x00");
                if (strlen($key) != 32) {
                    $echo .= "The key needs a lenght of 32. ";
                }
                if (!preg_match("#^[a-zA-Z0-9]+$#", $key)) {
                    $echo .= 'The key has illegal Letters. ';
                } 
            }

            //to save ressources only check something with the database if there is no error
            if($echo == "")
            {
                mysqli_real_escape_string($this->dbconn, $accountname);
                mysqli_real_escape_string($this->dbconn, $password);
                mysqli_real_escape_string($this->dbconn, $alias);
                mysqli_real_escape_string($this->dbconn, $key);

                //check if account name exists
                $sql = "SELECT FROM persons WHERE name='$accountname'";
                $result = mysqli_query($this->dbconn ,$sql);
                if(mysqli_fetch_row($result)[0])
                {
                    $echo .= "There is already a person with this name, please choose another or you fail again.";
                }

                //check if alias exists
                $sql = "SELECT FROM persons WHERE alias='$alias'";
                $result = mysqli_query($this->dbconn ,$sql);
                if(mysqli_fetch_row($result)[0])
                {
                    $echo .= "There is already a person with this alias, you are not the first.";
                }
            } 


            //if there is at least one error send error and return
            if($echo != "")
            {
                echo $echo;
                return;
            }

            //////////////////Error handeling ends
            //////////////////Add new user

            //try adding a new user
            $sql = "INSERT INTO persons name, password, alias, key VALUES ($accountname, $password, $alias, $key)";
        }

        public function deleteAccount($accountname, $password)
        {
            mysqli_real_escape_string($this->dbconn, $accountname);
            mysqli_real_escape_string($this->dbconn, $password);

            $sql = "SELECT 1 FROM persons WHERE name='$accountname' AND password='$password'";
            $result = mysqli_query($this->dbconn ,$sql);
            if(!mysqli_fetch_row($result)[0])
            {
                echo "Account does not exist or password is wrong.";
                return;
            }
            $sql = "DELETE FROM persons WHERE name='$accountname' AND password='$password'";
            echo mysqli_query($this->dbconn ,$sql);
        }

        ///////////////////////////////////////////
        ////////////administration/////////////////
        public function addNewKey(int $max_users, string $adminname, string $adminpassword)
        {
            function RandomLetter()
            {
                $letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                $randomletter = substr($letters, (rand(0, strlen($letters))), 1);
                return $randomletter;
            }
            
            $newKey = '';
            for ($i=0; $i < 32; $i++) { 
                $newKey .= RandomLetter();
            }

            if($max_users <= 1)
            {
                $sql = "INSERT INTO product_keys (product_key) VALUE ('$newKey')";
                $max_users = 1;
            } 
            else
            {
                $sql = "INSERT INTO product_keys (product_key, max_users) VALUES ('$newKey', '$max_users')";
            }
            mysqli_query($this->dbconn ,$sql);
            echo "New Key: " . $newKey . " | Amount of users: " . $max_users;
        }

        //////////////////////////////////////
        ///////////outdated///////////////////
        function addContent($user,
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
    }
?>