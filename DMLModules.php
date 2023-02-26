<?php
    include('DB.php');
    class DMLModules
    {
        ///////////////////////////////////////////
        ////////////////punlic tables//////////////
        public static function getTable($select, $from)
        {
            //anti SQL injection
            mysqli_real_escape_string(DB::connection(), $select);
            mysqli_real_escape_string(DB::connection(), $from);
            
            //try sql selection
            $sql = "SELECT $select FROM $from ORDER BY $select ASC";
            $result = mysqli_query(DB::connection() ,$sql);

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

        public static function getTableWhere($select, $from, $where)
        {
            //anti SQL injection
            mysqli_real_escape_string(DB::connection(), $select);
            mysqli_real_escape_string(DB::connection(), $from);
            mysqli_real_escape_string(DB::connection(), $where);
            //try sql selection
            $sql = "SELECT $select FROM $from WHERE $where ORDER BY $select ASC";
            $result = mysqli_query(DB::connection() ,$sql);
            
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

        public static function getPreferenceTable($crossPersonCategoryID)
        {
            //anti SQL injection
            mysqli_real_escape_string(DB::connection(), $crossPersonCategoryID);
            
            //try sql selection
            $limit = "";
            $sql = "SELECT persons_id FROM cross_person_categories WHERE cross_person_categories_id='$crossPersonCategoryID' ORDER BY persons_id ASC";
            $result = mysqli_query(DB::connection() ,$sql);
            $person_id = mysqli_fetch_row($result)[0];

            $sql = "SELECT product_key FROM persons WHERE name='$person_id'";
            $result = mysqli_query(DB::connection() ,$sql);
            $key = mysqli_fetch_row($result)[0];
            if(!$key)
            {
                $limit = "LIMIT 20";
                echo "<p class='deleteme'>The Owner of this list has no key so the visible entrys are limited to 20. </p> ";
            }

            $sql = "SELECT preference, rating 
                    FROM preferences 
                    WHERE cross_person_categories_id='$crossPersonCategoryID'
                    ORDER BY rating DESC, preference ASC 
                    $limit";
            $result = mysqli_query(DB::connection() ,$sql);
            
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
        public static function getPreferenceTableData($crossPersonCategoryID)
        {
            //anti SQL injection
            mysqli_real_escape_string(DB::connection(), $crossPersonCategoryID);
            
            //try sql selection
            $limit = "";
            $sql = "SELECT persons_id FROM cross_person_categories WHERE cross_person_categories_id='$crossPersonCategoryID'";
            $result = mysqli_query(DB::connection() ,$sql);
            $person_id = mysqli_fetch_row($result)[0];

            $sql = "SELECT product_key FROM persons WHERE name='$person_id'";
            $result = mysqli_query(DB::connection() ,$sql);
            $key = mysqli_fetch_row($result)[0];

            $sql = "SELECT preference, rating 
                    FROM preferences 
                    WHERE cross_person_categories_id='$crossPersonCategoryID'
                    ORDER BY rating DESC, preference ASC 
                    $limit";
                    
                #    ORDER BY preference ASC, rating DESC";
            $result = mysqli_query(DB::connection() ,$sql);
            
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

        public static function userCategoryTable($person)
        {
            $table = array();
            $result = self::getTableWhere("cross_person_categories_id", "cross_person_categories", "persons_id='$person'");
            foreach ($result as $key => $id) {
                $sql = "SELECT categories_id, (SELECT COUNT(*) 
                                               FROM preferences 
                                               WHERE cross_person_categories_id=$id[cross_person_categories_id]) 
                        FROM cross_person_categories 
                        WHERE cross_person_categories_id=$id[cross_person_categories_id];";
                $secondResult = mysqli_query(DB::connection(), $sql);
                $table[] = mysqli_fetch_row($secondResult);
            }  
            return [$table, $result];
        }

        /////////////////////////////////////
        /////////single value////////////////
        private static function getFirstMatchValue($select, $from, $where)
        {
            //anti SQL injection
            mysqli_real_escape_string(DB::connection(), $select);
            mysqli_real_escape_string(DB::connection(), $from);
            mysqli_real_escape_string(DB::connection(), $where);
            //try sql selection
            $sql = "SELECT $select FROM $from WHERE $where";
            
            //echo $sql; //when debug in next row is needed this helps
            $result = mysqli_query(DB::connection() ,$sql);
            
            return mysqli_fetch_row($result)[0];
        }

        public static function getAlias($name)
        {
            return self::getFirstMatchValue('alias', 'persons', "name='$name'");
        }

        public static function getName($alias)
        {
            return self::getFirstMatchValue('name', 'persons', "alias='$alias'");
        }

        public static function getPersonCategoryIdByPersCate($persons_id, $category)
        {
            return self::getFirstMatchValue('cross_person_categories_id', 'cross_person_categories', "persons_id='$persons_id'&&categories_id='$category'");
        } 
                
        public static function getPersonCategoryIdByPreference($preferenceId)
        {
            return self::getFirstMatchValue('cross_person_categories_id', 'preferences', "preferences_id='$preferenceId'");
        } 
        
        private static function keyUsable(string $key)
        {
            $sql = "SELECT EXISTS(SELECT product_key from product_keys WHERE product_key='$key')";
            $result = mysqli_query(DB::connection() ,$sql);
            if(!mysqli_fetch_row($result)[0])
                return false;
            $keyUses = intval(self::getFirstMatchValue('max_users', 'product_keys', "product_key='$key'"));
            $sql = "SELECT COUNT(product_key) FROM persons WHERE product_key='$key'";
            $result = mysqli_query(DB::connection() ,$sql);
            $alreadyUsed = mysqli_fetch_row($result)[0];

            if($keyUses <= $alreadyUsed)
                return false;

            return true;
        } 

        //////////////////////////////////
        /////////////Accounts/////////////
        public static function addAccount($accountname, $alias, $password, $key)
        {
            /**
             * trys to add an account to the database
             *
             *  accountname min 5, max 32 letters
             *  alias min 5, max 32 letters
             *  password 
             *  key 32 letters, a-z, A-Z, 0-9 
             * 
             *  Some_Exception_Class If something interesting cannot happen
             *  Status
             */ 

            //////////////////Error handeling
            $echo = "";
            //check accountname
            //if the accountname contains no letters throw an error
            if(!preg_match("/[a-z]/i", $accountname))
                $echo .= "You need at least 1 alphabet letter in your Account name. ";

            if(strlen($accountname) > 32)
                $echo .= "A maximum of 32 Letters are allowed for the Account name. ";

            if(strlen($accountname) < 5)
                $echo .= "You need at least 5 Letters for the Account name. ";


            //check alias
            if(!preg_match("/[a-z]/i", $alias))
                $echo .= "You need at least 1 alphabet letter in your public alias. ";

            if(strlen($alias) > 32)
                $echo .= "A maximum of 32 Letters are allowed for the public alias. ";

            if(strlen($alias) < 5)
                $echo .= "You need at least 5 Letters for the public alias. ";     
            
                
            //check password
            if(!preg_match("/[a-z]/i", $password))
                $echo .= "You need at least 1 alphabet letter in your password. ";

            if(strlen($password) > 50)
                $echo .= "A maximum of 50 Letters are allowed for the password. ";

            if(strlen($password) < 5)
                $echo .= "You need at least 5 Letters for the password. ";   


            //check Key
            if (strlen($key) != 32)
                $echo .= "The key needs a lenght of 32. " . strlen($key) . " " . $key;
            if (!preg_match("#^[a-zA-Z0-9]+$#", $key)) 
                $echo .= 'The key has illegal Letters. ';
            if(!self::keyUsable($key))
                $echo .= "You cant use this key. Please insert another. ";
            

            //anti sql injection
            mysqli_real_escape_string(DB::connection(), $accountname);
            mysqli_real_escape_string(DB::connection(), hash('sha256', "'" . $password . "'"));
            mysqli_real_escape_string(DB::connection(), $alias);
            mysqli_real_escape_string(DB::connection(), $key);

            //to save ressources only check something with the database if there is no error
            if($echo == "")
            {
                //check if account name exists
                $sql = "SELECT EXISTS(SELECT 1 FROM persons WHERE name='$accountname')";
                $result = mysqli_query(DB::connection() ,$sql);
                if(mysqli_fetch_row($result)[0])
                    $echo .= "There is already a person with this name, please choose another or you fail again.";

                //check if alias exists
                $sql = "SELECT EXISTS(SELECT 1 FROM persons WHERE alias='$alias')";
                $result = mysqli_query(DB::connection() ,$sql);
                if(mysqli_fetch_row($result)[0])
                    $echo .= "There is already a person with this alias, you are not the first.";
            } 

            //if there is at least one error send error and return
            if($echo != "")
            {
                echo $echo;
                return false;
            }

            //////////////////Error handeling ends
            //////////////////Add new user

            //try adding a new user || not really for testing purposes
            $sql = "INSERT INTO persons (
                        name, 
                        pasword, 
                        alias, 
                        product_key) 
                    VALUES (
                        '$accountname', 
                        '" . hash('sha256', "'" . $password . "'") . "', 
                        '$alias', 
                        (select product_key from product_keys where product_key = '$key')
                    )";
            //if i want users without key if($key == "") { $sql = "INSERT INTO persons (name, pasword, alias) VALUES ('$accountname', '$password', '$alias')"; }
            if(mysqli_query(DB::connection() ,$sql))
                return true;
            else 
                return false;
        }
    
        public static function loginSuccess($accountname, $password)
        {
            mysqli_real_escape_string(DB::connection(), $accountname);
            mysqli_real_escape_string(DB::connection(), hash('sha256', "'" . $password . "'"));


            $sql = "SELECT 1 FROM persons WHERE name='$accountname' AND pasword='" . hash('sha256', "'" . $password . "'") . "'";
            $result = mysqli_query(DB::connection() ,$sql);#
            if(mysqli_fetch_row($result) == null)
                return false;
            return true;
        }

        public static function deleteAccount($accountname, $password)
        {
            mysqli_real_escape_string(DB::connection(), $accountname);
            mysqli_real_escape_string(DB::connection(), $password);

            $sql = "SELECT 1 FROM persons WHERE name='$accountname' AND pasword='$password'";
            $result = mysqli_query(DB::connection() ,$sql);
            if(!mysqli_fetch_row($result)[0])
            {
                echo "Account does not exist or password is wrong.";
                return;
            }
            $sql = "DELETE FROM persons WHERE name='$accountname' AND pasword='$password'";
            echo mysqli_query(DB::connection() ,$sql);
        }

        ///////////////////////////////////////////
        ////////////administration/////////////////
        public static function addNewKey(int $max_users, string $adminname, string $adminpassword)
        {
            include('admin.php');
            if (!admin($adminname, $adminpassword))
                return 'nokey|foryou';

            function RandomLetter()
            {
                $letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                $randomletter = substr($letters, (rand(0, strlen($letters)-1)), 1);
                return $randomletter;
            }
            
            $newKey = '';
            while (strlen($newKey) != 32) 
            { 
                $newKey .= RandomLetter();
            }

            if($max_users <= 1)
            {
                $sql = "INSERT INTO product_keys (product_key) VALUE ('$newKey')";
                $max_users = 1;
            } 
            else
            {
                $max_users = $max_users < 100 ? $max_users : 100; //100 maximal per key
                $sql = "INSERT INTO product_keys (product_key, max_users) VALUES ('$newKey', '$max_users')";
            }
            mysqli_query(DB::connection() ,$sql);
            echo $newKey . "|" . $max_users;
        }

        //////////////////////////////////////
        ///////testarea userinteraction///////

        static function addChangePreference ($user, $password, $category, $preference, $rating)
        {
            mysqli_real_escape_string(DB::connection(), $user);
            mysqli_real_escape_string(DB::connection(), $password);
            mysqli_real_escape_string(DB::connection(), $category);
            mysqli_real_escape_string(DB::connection(), $preference);
            mysqli_real_escape_string(DB::connection(), $rating);

            if (!self::loginSuccess($user, $password))
                return false;

            $cpc = self::getPersonCategoryIdByPersCate($user, $category);

            $sql = "INSERT INTO preferences (cross_persons_categories_id, 
                                             preference, 
                                             rating) 
                    VALUES (" . 
                            $cpc . ", " . 
                            $preference . ", " . 
                            $rating . 
                           ")";

                           
            if(mysqli_query(DB::connection(), $sql))
                return true;
            return false;
        }

        static function removePreference ($user, $password, $category, $preference)
        {
            mysqli_real_escape_string(DB::connection(), $user);
            mysqli_real_escape_string(DB::connection(), $password);
            mysqli_real_escape_string(DB::connection(), $category);
            mysqli_real_escape_string(DB::connection(), $preference);
        }

        static function addCategory ($name, $password, $category)
        {
            mysqli_real_escape_string(DB::connection(), $name);
            mysqli_real_escape_string(DB::connection(), $password);
            mysqli_real_escape_string(DB::connection(), $category);

            if(!self::loginSuccess($name, $password))
                return false;

            $sql = "INSERT INTO cross_person_categories (persons_id, categories_id) 
                    VALUES ('" . $name . "','" . $category . "'     )";

            if(!mysqli_query(DB::connection(), $sql))
                return false;
            return json_encode(self::getPersonCategoryIdByPersCate($name, $category));     
        }

        static function removeCategory ($name, $password, $category)
        {
            mysqli_real_escape_string(DB::connection(), $name);
            mysqli_real_escape_string(DB::connection(), $password);
            mysqli_real_escape_string(DB::connection(), $category);

            if(!self::loginSuccess($name, $password))
                return false;

            $sql = "DELETE FROM cross_person_categories WHERE persons_id='" . $name . "' AND categories_id='" . $category . "';";
            echo $sql;

            if(mysqli_query(DB::connection(), $sql))
                return true;
            return false;
        }
    }
?>