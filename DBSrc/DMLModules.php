<?php
    include_once('DB.php');
    include_once(dirname(__FILE__) . "/../UniversalLibrary.php");
    /**
     * TODO: solve to do's (4 left)
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
        * person_id == name. returns pc_id, categories and entry_amounts as an array
        */
        public static function getPersonCategoryTable(string $name) : array
        {
            $table = array();

            $stmt = DB::connection()->prepare(
                "SELECT cross_person_categories.cross_person_categories_id as pc_id, cross_person_categories.categories_id as categories, COUNT(preferences.cross_person_categories_id) as entry_amounts
                FROM cross_person_categories 
                LEFT JOIN preferences ON cross_person_categories.cross_person_categories_id = preferences.cross_person_categories_id
                WHERE cross_person_categories.persons_id=(?)
                GROUP BY preferences.cross_person_categories_id"
            );
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * get every category
         */
        public static function getCategories() : array
        {
            $stmt = DB::connection()->prepare(
                "SELECT * FROM categories"
            );
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * get every alias
         */
        public static function getAliasTable() : array
        {
            $stmt = DB::connection()->prepare(
                "SELECT alias FROM persons"
            );
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
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
        public static function keyUsable(string $key) : bool
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
            
            $max_users = "";
            $count = 0;
            $stmt->bind_result($max_users, $count);
            $stmt->fetch();

            if($max_users <= $count)
                return false;
            return true;
        } 

        public static function keyExists(string $key) : bool
        {
            $stmt = DB::connection()->prepare(
                "SELECT * FROM product_keys WHERE product_key=(?)"
            );
            $stmt->bind_param("s", $key);
            $stmt->execute();
            $result = $stmt->get_result();

            if(mysqli_fetch_row($result)[0]) 
                return true;
            return false;
        } 

        //////////////////////////////////
        /////////////Accounts/////////////
        
        /**
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
            include_once("../UniversalLibrary.php");
            //check accountname
            //if the accountname contains no letters throw an error
            if(!UniversalLibrary::validName($accountname))
                $errorString .= "Name invalid! ";
            
            //check alias
            if(!UniversalLibrary::validName($alias))
                $errorString .= "Alias invalid! ";

            //check password
            if(!UniversalLibrary::validPassword($password))
                $errorString .= "Password invalid! ";

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
            if($stmt->execute())
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

            $hashPass = UniversalLibrary::hashPass($password);

            $stmt = DB::connection()->prepare("SELECT 1 FROM persons WHERE name=(?) AND pasword=(?)");
            $stmt->bind_param("ss", $accountname, $hashPass);
            if(!$stmt->execute())
            {
                http_response_code(500);
                return false;
            }
            $result = $stmt->get_result();

            if(mysqli_fetch_row($result) != null)
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
         * adds a key with between 1 and $keyMaxUsers uses. returns "{key}|{uses}" string
         */
        public static function addNewKey(int $max_users, string $adminname, string $adminpassword) : string
        {
            include_once('./admin.php');
            if (!UniversalLibrary::admin($adminname, $adminpassword))
            {
                return "wrong credentials";
                http_response_code(401);
            }

            if($max_users <= 1) { $max_users = 1; } 
            else
            {
                //set max_users to keyMaxUsers if max_users is above keyMaxUsers
                $max_users = $max_users < UniversalLibrary::getKeyMaxUsers() ? $max_users : UniversalLibrary::getKeyMaxUsers(); 
            }

            $newKey = UniversalLibrary::generateNewKey();
            $stmt = DB::connection()->prepare(
                "INSERT INTO product_keys (product_key, max_users) VALUE ((?), (?));"
            );
            $stmt->bind_param("si", $newKey, $max_users);

            if($stmt->execute())
            {
                http_response_code(201);
                return $newKey . "|" . $max_users;
            }
            return "DB fail";
            http_response_code(500);
        }

        //////////////////////////////////////
        ///////testarea userinteraction///////
        /**
         * returns true if preference got added or changed
         */
        static function addChangePreference (string $category, string $preference, int $rating) : bool
        {
            if (!Session::isLogin())
            {
                http_response_code(401);
                return false;
            }

            $pcID = self::getPersonCategoryIdByPersCate(Session::user(), $category);
            $stmt = DB::connection()->prepare(
                "INSERT INTO preferences (
                    preferences.cross_person_categories_id, 
                    preferences.preference, 
                    preferences.rating)
                VALUES ((?), (?), (?))
                ON DUPLICATE KEY UPDATE
                    preferences.rating=(?);
            ");
            $stmt->bind_param("isii", $pcID, $preference, $rating, $rating);
            $responseSuccess = $stmt->execute();
            if($responseSuccess)
            {
                return true;
            }
            http_response_code(500);
            return false;
        }

        /**
         * if more than 0 rows got deleted returns true
         */
        static function deletePreference ($category, $preference) : bool
        {
            if (!Session::isLogin())
            {
                http_response_code(401);
                return false;
            }
            
            $stmt = DB::connection()->prepare(
                "DELETE preferences 
                FROM preferences
                LEFT JOIN cross_person_categories 
                    ON cross_person_categories.cross_person_categories_id = preferences.cross_person_categories_id
                WHERE cross_person_categories.persons_id=(?) 
                    AND cross_person_categories.categories_id=(?)
                    AND preference=(?))"
            );
            $stmt->bind_param("sss", Session::user(), $category, $preference);
            $stmt->execute();

            if($stmt->affected_rows == 1)
                return true;
            http_response_code(500);
            return false;
        }

        /**
         * true on success
         */
        static function addCategory ($category) : bool
        {
            if(!Session::isLogin())
            {
                http_response_code(401);
                return false;
            }

            $stmt = DB::connection()->prepare(
                "INSERT INTO cross_person_categories (persons_id, categories_id) VALUES ((?),(?))"
            );
            $stmt->bind_param("ss", Session::user(), $category);
            $stmt->execute();
            
            switch ($stmt->affected_rows) {
                case 0:
                    return false;
                    break;
                case 1:
                    return true;
                    break;
                default:
                    http_response_code(500);
                    return false;
                    break;
            } 
        }

        /**
         * true on 1 delete, false on 0 delete and false + alert for the user in case of any case else
         */
        static function removeCategory (string $category) : bool
        {
            if(!Session::isLogin())
            {
                http_response_code(401);
                return false;
            }

            $stmt = DB::connection()->prepare("DELETE FROM cross_person_categories WHERE persons_id=(?) AND categories_id=(?)");
            $stmt->bind_param("ss", $name, $category);
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
                    http_response_code(500);
                    return false;
                    break;
            }
        }
    }
?>