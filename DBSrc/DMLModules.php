<?php
    include_once('DB.php');
    include_once("../UniversalLibrary.php");
    /**
     * TODO: implement SQL prepare statemnts everywhere
     * 
     */
    class DMLModules
    {
        ///////////////////////////////////////////
        ////////////////punlic tables//////////////
        /**
         * returns a table where every preference is listed with the corresponding value. Needs the ID of the cross table of persons & category
         */
        public static function getPreferenceTable(int $crossPersonCategoryID)
        {
            $stmt = DB::connection()->prepare(
               "SELECT persons_id 
                FROM cross_person_categories
                WHERE cross_person_categories_id=(?) 
                ORDER BY persons_id ASC"
            );
            $stmt->bind_param("i", $crossPersonCategoryID);
            $stmt->execute();
            $result = $stmt->get_result();
            $person_id = mysqli_fetch_row($result)[0];
            
            
            $stmt = DB::connection()->prepare(
                "SELECT product_key 
                FROM persons 
                WHERE name=(?)"
            );
            $stmt->bind_param("s", $person_id);
            $result = $stmt->get_result();
            $key = mysqli_fetch_row($result)[0];

            $limit = "";
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

        /**
         * returns a table of preferences. Limited by preferenceLimitForFreeAccounts in config.php
         */
        public static function getPreferenceTableData($crossPersonCategoryID)
        {
            //try sql selection
            $limit = "";
            $person_id = self::getPersonID($crossPersonCategoryID);

            $stmt = DB::connection()->prepare(
                "SELECT product_key FROM persons WHERE name=(?)"
            );
            $stmt->bind_param("s", $person_id);
            $result = $stmt->get_result();
            $key = mysqli_fetch_row($result)[0];
            $limit = "";
            include_once("../config.php");
            if($preferenceLimitForFreeAccounts != null)
            {   
                if(!$key) { $limit = "LIMIT $preferenceLimitForFreeAccounts"; }
            }


            $stmt = DB::connection()->prepare(
                "SELECT preference, rating 
                FROM preferences 
                WHERE cross_person_categories_id=(?)
                ORDER BY rating DESC, preference ASC 
                (?)"
            );
            $stmt->bind_param("is", $crossPersonCategoryID, $limit);
            $result = $stmt->get_result();
            
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

        /**
        * TODO: implement SQL prepare statemnt and document properly
        */
        public static function userCategoryTable($person)
        {
            $table = array();

            $stmt = DB::connection()->prepare(
                "SELECT cross_person_categories_id FROM cross_person_categories WHERE persons_id=(?) ORDER BY cross_person_categories_id ASC"
            );
            $stmt->bind_param("s", $person);
            $stmt->execute();
            $resultPersonIDs = $stmt->get_result();
            //compose array from data
            $data = null;
            if ($resultPersonIDs)
            {
                while($row = $resultPersonIDs->fetch_assoc())
                {
                    $data[] = $row["cross_person_categories_id"];
                }
            }
            $result = $data;


            foreach ($result as $key => $id) {
                $stmt = DB::connection()->prepare(
                    "SELECT categories_id, (SELECT COUNT(*) 
                    FROM preferences 
                    WHERE cross_person_categories_id=$id[cross_person_categories_id]) 
                    FROM cross_person_categories 
                    WHERE cross_person_categories_id=$id[cross_person_categories_id];"
                );

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

        /**
        * get alias by user name
        */
        public static function getAlias(string $name) : string
        {
            $stmt = DB::connection()->prepare(
                "SELECT alias FROM persons WHERE name=(?)"
            );
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $result = $stmt->get_result();

            return mysqli_fetch_row($result)[0];
        }

        /**
        * get name by user alias
        */
        public static function getName(string $alias) : string
        {
            $stmt = DB::connection()->prepare(
                "SELECT name FROM persons WHERE alias=(?)"
            );
            $stmt->bind_param("s", $alias);
            $stmt->execute();
            $result = $stmt->get_result();

            return mysqli_fetch_row($result)[0];
        }

        /**
        * get person_id/persons.name by crossPersonCategoryID
        */
        public static function getPersonID(int $crossPersonCategoryID) : string
        {
            $stmt = DB::connection()->prepare(
                "SELECT persons_id FROM cross_person_categories WHERE cross_person_categories_id=(?)"
            );
            $stmt->bind_param("i", $crossPersonCategoryID);
            $stmt->execute();
            $result = $stmt->get_result();

            return mysqli_fetch_row($result)[0];
        }

        /**
        * get cross_person_categories by persons_id and categories_id
        */
        public static function getPersonCategoryIdByPersCate(string $persons_id, string $category) : int
        {
            $stmt = DB::connection()->prepare(
                "SELECT persons_id FROM cross_person_categories WHERE persons_id=(?) && categories_id=(?)"
            );
            $stmt->bind_param("ss", $persons_id, $category);
            $stmt->execute();
            $result = $stmt->get_result();

            return mysqli_fetch_row($result)[0];
        } 

        public static function getPersonCategoryIdByPreference(int $preferenceId) : int
        {
            $stmt = DB::connection()->prepare(
                "SELECT cross_person_categories_id FROM preferences WHERE preferences_id=(?)"
            );
            $stmt->bind_param("i", $preferenceId);
            $stmt->execute();
            $result = $stmt->get_result();

            return mysqli_fetch_row($result)[0];
        } 


        /**
         * TODO: implement SQL prepare statemnt and document properly
         */
        private static function keyUsable(string $key) : bool
        {
            $stmt = DB::connection()->prepare(
                "SELECT 
                product_keys.max_users as max_users, COUNT(product_keys.product_key) as count
                FROM
                product_keys
                JOIN persons ON persons.product_key=(?) AND product_keys.product_key=(?)
                GROUP BY product_keys.product_key, product_keys.max_users;"
            );
            $stmt->bind_param("ss", $key, $key);
            $stmt->execute();
            $result = $stmt->get_result();
            $result = mysqli_fetch_row($result)[0];

            if(!$result) return false;


            $keyUses = intval($result);
            $sql = "SELECT COUNT(product_key) FROM persons WHERE product_key='$key'";
            $result = mysqli_query(DB::connection() ,$sql);
            $alreadyUsed = mysqli_fetch_row($result)[0];

            if($keyUses <= $alreadyUsed)
                return false;

            return true;
        } 

        //////////////////////////////////
        /////////////Accounts/////////////
        
        /**
        * TODO: implement SQL prepare statemnt and document properly
        */ 
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
    

        /**
         * TODO: implement SQL prepare statemnt and document properly
         */
        public static function loginSuccess(string $accountname, string $password) : bool
        {
            if(!UniversalLibrary::validName($accountname))
            	return false;
            if(!UniversalLibrary::validPassword($password))
                return false;

            $sql = "SELECT 1 FROM persons WHERE name='" . $accountname . "' AND pasword='" . UniversalLibrary::hashPass($password) . "'";
            $result = mysqli_query(DB::connection() ,$sql);#
            if(mysqli_fetch_row($result) == null)
                return false;
            return true;
        }

        /**
         * TODO: implement SQL prepare statemnt and document properly
         */
        public static function deleteAccount($accountname, $password)
        {
            //replace with prepared statement
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
        /**
         * TODO: implement SQL prepare statemnt and document properly
         * TODO: check if Key exists
         */
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
        /**
         * TODO: implement SQL prepare statemnt and document properly
         */
        static function addChangePreference ($user, $password, $category, $preference, $rating)
        {
            //replace with prepared statement
            mysqli_real_escape_string(DB::connection(), $user);
            mysqli_real_escape_string(DB::connection(), $password);
            mysqli_real_escape_string(DB::connection(), $category);
            mysqli_real_escape_string(DB::connection(), $preference);
            mysqli_real_escape_string(DB::connection(), $rating);

            if (!self::loginSuccess($user, $password))
                return false;

            $cpc = self::getPersonCategoryIdByPersCate($user, $category);

            $sql = "DELETE FROM preferences
                    WHERE   cross_person_categories_id=$cpc AND
                            preference='$preference';";
            mysqli_query(DB::connection(), $sql);

            $sql = "INSERT INTO preferences (cross_person_categories_id, 
                                             preference, 
                                             rating) 
                    VALUES (" . 
                            $cpc . ", '" . 
                            $preference . "', " . 
                            $rating . 
                           ");";
            
            if(!mysqli_query(DB::connection(), $sql))
                return false;
            return true;
        }

        /**
         * TODO: implement SQL prepare statemnt and document properly
         */
        static function deletePreference ($user, $password, $category, $preference)
        {
            // replace with prepared statement
            mysqli_real_escape_string(DB::connection(), $user);
            mysqli_real_escape_string(DB::connection(), $password);
            mysqli_real_escape_string(DB::connection(), $category);
            mysqli_real_escape_string(DB::connection(), $preference);

            if (!self::loginSuccess($user, $password))
                return false;

            $cpc = self::getPersonCategoryIdByPersCate($user, $category);

            $sql = "DELETE FROM preferences
                    WHERE   cross_person_categories_id=$cpc AND
                            preference='$preference'";
            if(mysqli_query(DB::connection(), $sql))
                return true;
            return false;
        }

        /**
         * TODO: implement SQL prepare statemnt and document properly
         */
        static function addCategory ($name, $password, $category)
        {
            // replace with prepared statement
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

        /**
         * TODO: implement SQL prepare statemnt and document properly
         */
        static function removeCategory ($name, $password, $category)
        {
            // replace with prepared statement
            mysqli_real_escape_string(DB::connection(), $name);
            mysqli_real_escape_string(DB::connection(), $password);
            mysqli_real_escape_string(DB::connection(), $category);

            if(!self::loginSuccess($name, $password))
                return false;

            $sql = "DELETE FROM cross_person_categories WHERE persons_id='" . $name . "' AND categories_id='" . $category . "';";

            if(mysqli_query(DB::connection(), $sql))
                return true;
            return false;
        }
    }
?>