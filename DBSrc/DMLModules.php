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
         * returns a html table where every preference is listed with the corresponding value. Needs the ID of the cross table of persons & category
         * TODO: delete this
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
        public static function getPreferenceTableData(int $crossPersonCategoryID) : array
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
        public static function userCategoryTable(string $person)
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
                $stmt->bind_param("", $id['cross_person_categories_id']);
//todo finish $stmt
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

        /**
        * get cross_person_categories_id by preferenceId
        */
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
         * checks if a product key has available uses
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

            $stmt->bind_result($max_users, $count);
            $stmt->fetch();

            if($max_users <= $count)
                return false;
            return true;
        } 

        //////////////////////////////////
        /////////////Accounts/////////////
        
        /**
        * TODO: implement SQL prepare statemnt and document properly
        * returns true when account got created. Else a string with all problems 
        */ 
        public static function addAccount(string $accountname, string $alias, string $password, string $key) : string | true
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
        $errorString = "";
            include_once("../config.php");
            //check accountname
            //if the accountname contains no letters throw an error
            if(!UniversalLibrary::validName($accountname))
                $errorString .= "Name invalid! ";

            if(!preg_match($nameRegex, $accountname))
                $errorString .= "Your account name has to pass the '" . $nameRegex . "' regex. ";

            if(strlen($accountname) > $nameMaxLength)
                $errorString .= "A maximum of ". $nameMaxLength . " Letters are allowed for the Account name. ";

            if(strlen($accountname) < $nameMinLength)
                $errorString .= "You need at least " . $nameMinLength . " Letters for the Account name. ";

            //check alias
            if(!UniversalLibrary::validName($alias))
                $errorString .= "Alias invalid! ";

            if(!preg_match($nameRegex, $alias))
                $errorString .= "Your account alias has to pass the '" . $nameRegex . "' regex. ";

            if(strlen($alias) > $nameMaxLength)
                $errorString .= "A maximum of " . $nameMaxLength . " Letters are allowed for the public alias. ";

            if(strlen($alias) < $nameMinLength)
                $errorString .= "You need at least " . $nameMinLength . " Letters for the public alias. ";     
                
            //check password
            if(!UniversalLibrary::validPassword($password))
                $errorString .= "Password invalid! ";

            if(!preg_match($passRegex, $password))
                $errorString .= "Your account password has to pass the '" . $passRegex . "' regex. ";

            if(strlen($password) > $passMaxLength)
                $errorString .= "A maximum of " . $passMaxLength . " Letters are allowed for the password. ";

            if(strlen($password) < $passMinLength)
                $errorString .= "You need at least " . $passMinLength . " Letters for the password. ";   


            //check Key
            if(!UniversalLibrary::validKey($key))
                $errorString -= "Key invalid! ";
            if (strlen($key) != 32)
                $errorString .= "The key needs a lenght of 32. Current length is " . strlen($key) . ". ";
            if (!preg_match("#^[a-zA-Z0-9]+$#", $key)) 
                $errorString .= 'The key has illegal Letters. ';
            if(!self::keyUsable($key))
                $errorString .= "You cant use this key. Please insert another. ";

            if($errorString == "")
            {
                $stmt = DB::connection()->prepare(
                    "SELECT p1.alias, p2.name
                    FROM persons 
                    LEFT JOIN persons as p2 ON p2.name=(?) OR p2.name=null
                    LEFT JOIN persons as p1 ON p1.alias(?) OR p1.alias=null
                    GROUP BY p1.alias, p2.name;"
                );
                $stmt->bind_param("ss", $accountname, $alias);
                $stmt->execute();
                $stmt->bind_param($alias, $name);

                //check if account name exists
                if($name != null)
                    $errorString .= "There is already a person with this name, please choose another or fail again.";

                //check if alias exists
                if($alias != null)
                    $errorString .= "There is already a person with this alias, you are not the first.";
            } 

            //if there is at least one error send error and return
            if($errorString != "")
                return $errorString;

            //////////////////Error handeling ends
            //////////////////Add new user
            //todo prepare
            //try adding a new user || not really for testing purposes
            $password = hash('sha256', "'" . $password . "'");
            $stmt->prepare(
                "INSERT INTO persons (
                    name, 
                    pasword, 
                    alias, 
                    product_key)
                VALUES (
                    (?),
                    (?),
                    (?),
                    (SELECT product_key FROM product_keys WHERE product_key = (?)))
                ");
            $stmt->bind_param("ssss", $accountname, $password, $alias, $key);
            if($stmt->execute()) //todo: Does this work? 
                return true;
            else 
                return $errorString . "Error with adding account -> please contact support!";
        }
    

        /**
         * true if the login credentials are correct 
         */
        public static function loginSuccess(string $accountname, string $password) : bool
        {
            if(!UniversalLibrary::validName($accountname))
            	return false;
            if(!UniversalLibrary::validPassword($password))
                return false;

            $stmt = DB::connection()->prepare(
                "SELECT 1 FROM persons WHERE name=(?) AND pasword=(?)"
            );
            $stmt->bind_param("ss", $accountname, UniversalLibrary::hashPass($password));
            $stmt->execute();
            $result = $stmt->get_result();

            if(mysqli_fetch_row($result) == null)
                return false;
            return true;
        }

        /**
         * returns true if 1 account got deleted. Sends a notification to the user in case if not 0 or 1 accounts got deleted
         */
        public static function deleteAccount(string $accountname, string $password) : bool
        {
            $stmt = DB::connection()->prepare("DELETE FROM persons WHERE name=(?) AND pasword=(?)");
            $stmt->bind_param("ss", $accountname, $password);
            $stmt->execute(); 
            $stmt->affected_rows;
            
            switch ($stmt->affected_rows) {
                case 0:
                    return false;
                    break;
                case 1:
                    return true;
                    break;
                default:
                    echo "<script>alert('DELETED " . $stmt->affected_rows . " ACCOUNTS. PLEASE CONTACT THE ADMINISTRATOR')</script>";
                    return false;
                    break;
            }
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