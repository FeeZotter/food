<?php
//include_once('/xampp/htdocs/food/DBSrc/DMLModules.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/DBSrc/DMLModules.php');
class HTML
{
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   basic                                                                                                            //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function getHTML($style, $headcontent, $bodycontent, $script)
    {
        return "<!DOCTYPE html><html>
                <head><title>Preferix</title>
                <link rel='stylesheet' href='/style/style.css'>
                <link rel='stylesheet' href='/style/bootstrap-5.2.2-dist/css/bootstrap.min.css'>".
                $style.
                $headcontent.
               "</head>
                <body>
                    <div id='content' style='width:100vw;margin:auto;'>".
                        $bodycontent.
               '    </div>' . 
               (include_once("./modules/impressumFooter.php")) .
               '
                </body>
                </html>'.
                $script;
    }

    private static function script($src)
    {
        return "<script src='js/".$src.".js'></script>";
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Pages                                                                                                            //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function Person(string $alias)
    {
        //check if there is an error
        $name = '';
        try {
            $name = DMLModules::getName($alias);
        } catch (\Throwable $throwedError) {
            return self::error404();
        }
        $bodycontent = self::navigationBar('Start', $alias, null);
        $bodycontent .= self::categoriesTableReturn($name);
        echo self::getHTML("", "", $bodycontent, self::script("index"));
    }

    public static function Preference(string $alias, string $category)
    {
            //start navigation bar
        $persons_id = DMLModules::getName($alias);
        $cross_person_categories_id = DMLModules::getPersonCategoryIdByPersCate($persons_id, $category);
        $bodycontent = self::navigationBar('Start', $alias, $category);
            //end navigation bar
        $bodycontent .= self::preferenceTable($cross_person_categories_id);
        echo self::getHTML("", "", $bodycontent, self::script("index"));
    }

    public static function PreferenceByID(int $preferenceId)
    {
            //start navigation bar
        $cross_person_categories_id = DMLModules::getPersonCategoryIdByPreference($preferenceId);
        $persons_id = DMLModules::getPersonID($cross_person_categories_id);
        $result = DMLModules::getPersonCategoryTable($persons_id);
        $result = $result[0];
        $categories_id = $result['categories'];
        $alias = DMLModules::getAlias($persons_id);
        $bodycontent = self::navigationBar('Start', $alias, $categories_id);
            //end navigation bar
        $bodycontent .= self::preferenceTable($preferenceId);

        echo self::getHTML("", "", $bodycontent, "");
    }

    public static function main()
    {
        echo self::getHTML("", "", self::navigationBar('Start', null, null) . self::tableOne("users", DMLModules::getAliasTable()), self::script("index"));
    }

    public static function adminPage()
    {
        echo self::getHTML("", "", self::keyModule(), self::script("admin"));
    }

    public static function regristration()
    {
        echo self::getHTML("", "", self::accountCreateModule(), self::script("regrister"));
    }

    public static function error404()
    {
        return self::getHTML('', 
                             '', 
                             'Error 418: I AM A TEAPOD | redirecting you shortly in <a id="timer"></a> seconds',
                             self::script("error404"));
    }

    public static function userMainPage($userName, $password)
    {
        if(!DMLModules::loginSuccess($userName, $password))
            return self::error404();

        $array = DMLModules::getCategories();
        $table = "";
        foreach ($array as $value) { $table .= "<option value='$value'>$value</option>"; }

        return self::getHTML("", "", 
                            self::helloUser($userName, $password) . 
                           "<h6>Note: reload the page often to see if you did everything right, when updating or deleting a preference or category it gets not shown in the list and you cant search for preferences...</h6>
                            <div class='container text-center'>
                                <div class='row'>
                                    <div class='col-6' id='userCategories'>" .
                                        self::userCategoryTable($userName) .
                                   "</div>
                                    <div class='col-6' id='userItems'>" .
                                        self::userItemsTable() .
                            "       </div>
                                </div>
                                <div class='row overflow-auto'>
                                    <div class='col-6'>
                                        <select class='form-select' aria-label='Default select example' id='selectCategories'>" . 
                                            $table .                                            
                                        "</select>
                                        <button id='addCategory' class='btn btn-primary' onclick='addCategory()'>Add Category</button>
                                    </div>
                                    <div class='col-6'>
                                        <input id='inputPreference' class='form-control' type='text' placeholder='your preference'>
                                        <input id='inputRating' class='form-control' type='number' value='0' min='0' max='10' placeholder='rating'>
                                        <button id='addChangePreference' class='btn btn-primary'onclick='acPreference()'>Add/Change Preference</button>
                                    </div>
                                </div>
                            </div>", 
                            self::script("userPage"));
    }

    public static function hints()
    {
        return self::getHTML("", "", "
        <h1>Shortlink</h1>
        /s/name OR /s/name/category OR /s/id (left in a list as a class you can only see if you inspect the page)

        <h1>API</h1>
        note: please made your own page, mine is only functional but else crap
        <table>
            <thead>
            <tr><th>type</th><th>parameters</th><th>input</th><th>output</th></tr>
            </thead>
            <tbody>
                <tr><td>get</td><td>none<td><td>/login</td><td>login page</td></tr>
            </tbody>
        </table>
        ", "");
    } 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Modules                                                                                                          //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private static function searchbarName($id, $function)
    {
        if ($id == "")
        {
            $id = "sortValue";
            $function = "searchByName()";
        }
        return '<input class="input marginLeft" type="text" id="' . $id . '" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="' . $function . '"/>';
    }

    private static function searchbarRating($id, $function)
    {
        if ($id == "")
        {
            $id = "sortRating";
            $function = "searchByRating()";
        }
        return '<input class="input" type="text" id="' . $id . '" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="' . $function . '"/>';
    }

    private static function searchbarNameRating()
    {
        return ('<input class="input marginLeft" type="text" id="sortValue" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByName()"/>
                 <input class="input" type="text" id="sortRating" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByRating()"/>');
    }

    private static function helloUser($name, $password)
    {
        return ("<h1>Hello <b id='myUsername' class='$password'>$name</b> and i know your public name is <b id='myAlias'>" . DMLModules::getAlias($name) . "</b></h1>");
    }

    private static function tableOne($header, $array)
    {
        $table = "";
        foreach ($array as $value)
        {
            $table .=
            "<tr>"
            .   "<td class='$value[alias]'>{$value['alias']}</td>"
            ."</tr>";
        }
        return (
        '<div id="table">' .
            self::theadOne($header) . 
            self::tbody($table) .
        '</div>'
        );
    }

    private static function theadOne($header)
    {
        return ("  
        <div class='col-xs-8 col-xs-offset-2'>
            <table class='table' id='oneTableHead'>
                <thead id='tabletop'>
                    <tr>
                        <th scope='col'><a>" . ucfirst($header) . '</a><a>' . self::searchbarName("", "") . '</a>' . "</th>
                    </tr>   
                </thead>
            </table>
        </div>");
    }

    private static function tbody($table)
    {
        return 
        "<div class='col-xs-8 col-xs-offset-2 tableFixHead' style=''>
            <table class='table tableFixHead table-hover' id='oneTable'>
                <tbody id='tableContent'>" .
                        $table .
               '</tbody>
            </table>
        </div>';
    }

    private static function tableTwo($header1, $header2, $table)
    {
        return
        '<div id="twoTable">' .
            self::theadTwo($header1, $header2) . 
            self::tbody($table) .
        '</div>';
    }

    private static function theadTwo ($header1, $header2)
    {
        return
        "<div class='col-xs-8 col-xs-offset-2' style=''>
            <table class='table' id='twoTableHead'>
                <thead id='tabletop'>
                    <tr>
                        <th scope='col'><a>" . ucfirst($header1) . "</a><a>" . self::searchbarName("", "") .   "</a></th>
                        <th scope='col'>" .    ucfirst($header2) . '</a><a>' . self::searchbarRating("", "") . "</a></th>
                    </tr>   
                </thead>
            </table>
        </div>";
    }

    private static function preferenceTable($categoryID)
    {
       # $array = $dml->getTableWhere("preference, rating", 'preferences', "cross_person_categories_id='$categoryID'");
        $array = DMLModules::getPreferenceTable($categoryID);
        $returnTable = "";
        
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td class='color" . $value['rating'] . "'>" . ucfirst($value['preference']) . "</td>"
            .   "<td class='color" . $value['rating'] . "'>" . ucfirst($value['rating'])    . "</td>"
            ."</tr>";
        }

        return self::tableTwo('Search Preference (not working)', 'Search Rating (not working)', $returnTable);
    }

    public static function returnPreferenceTable($categoryID)
    {
       # $array = $dml->getTableWhere("preference, rating", 'preferences', "cross_person_categories_id='$categoryID'");
        $array = DMLModules::getPreferenceTable($categoryID);
        $returnTable = "";
        
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td class='color" . $value['rating'] . "'>" . ucfirst($value['preference']) . "</td>"
            .   "<td class='color" . $value['rating'] . "'>" . ucfirst($value['rating'])     . "</td>"
            ."</tr>";
        }

        return self::tableTwo('Preference', 'Rating', $returnTable);
    }

    public static function onlyUserCategoryTable($userName, $password)
    {
        if(!DMLModules::loginSuccess($userName, $password))
            return self::error404();
        return self::userCategoryTable($userName);
    }

    private static function userCategoryTable($name)
    {
        //[pc_id, categories, entry_count]
        $arrays = DMLModules::getPersonCategoryTable($name);
        $array1 = $arrays[1];
        $array2 = $arrays[2];
        $returnTable = "";

        $a = 0;
        $b = 1;
        $c = "cross_person_categories_id";

        for ($i = 0; $i != count($array1); $i++)
        {
            $value  = $array1[$i];
            $value2 = $array2[$i];
            $returnTable .=
            "<tr>" //need to look for values
            .   "<td class='" . $value2[$c] . "' id='" . $value[$a] . "'>" . ucfirst($value[$a]) . "</td>"
            .   "<td class='" . $value2[$c] . "' id='" . $value[$b] . "'>" . ucfirst($value[$b]) . "</td>"
            .   "<td>"
            .   "<button id='" . $value2[$c] . "' class='input-group-append btn btn-outline-danger'>🗙</button>" . "</td>"
            ."</tr>";
        }
        return self::tableTwo('Search Category', 'Search Amount', $returnTable);
    }

    private static function categoriesTableReturn($alias)
    {
        $array = DMLModules::getPersonCategoryTable($alias);
        $returnTable = "";
        
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td class='" . $value["pc_id"] . "' id='" . $value['categories'] . "'>" . ucfirst($value['categories']) . "</td>"
            ."</tr>";
        }
        return self::tableOne('Preference', $returnTable);
    }

    public static function returnCategoriesTable($name)
    {
        $array = DMLModules::getPersonCategoryTable($name);
        $returnTable = "";
        
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td class='" . $value["pc_id"] . "' id='" . $value['categories'] . "'>" . ucfirst($value['categories']) . "</td>"
            ."</tr>";
        }
        return self::tableOne('Preference', $returnTable);
    }

    private static function navigationBar($navigationPoint1, $navigationPoint2, $navigationPoint3)
    {
        return ("   <h2 class='navigation' id='navigation'>
                        <a class='Start text-decoration-none' id='navigation1'>" . ucfirst($navigationPoint1 . "") . "</a>
                        <a class='text-decoration-none'      id='navigation2'>"  . ucfirst($navigationPoint2 . "") . "</a>                
                        <a class='text-decoration-none'      id='navigation3'>"  . ucfirst($navigationPoint3 . "") . "</a>
                    </h2>");
    }

    private static function navigationBarReturn($navigationPoint1, $navigationPoint2, $navigationPoint3)
    {
        return ("   <h1 class='navigation' id='navigation'>
                        <a class='Start text-decoration-none' id='navigation1'>" . ucfirst($navigationPoint1) . "</a>
                        <a class='text-decoration-none'      id='navigation2'>"  . ucfirst($navigationPoint2) . "</a>                
                        <a class='text-decoration-none'      id='navigation3'>"  . ucfirst($navigationPoint3) . "</a>
                    </h1>");
    }

    private static function keyModule()
    {
        return ("   <span class='border border-light'>
                        <form action='/newKey' method='post' id='keyForm'>
                            <div class='form-row'>
                                <div class='form-group col-md-6'>
                                    <label for='inputName'>Name</label>
                                    <input type='text' name='inputName' class='form-control' id='inputName' placeholder='AdminName'>
                                </div>
                                <div class='form-group col-md-6'>
                                    <label for='inputPassword'>Password</label>
                                    <input type='password' name='inputPassword' class='form-control' id='inputPassword' placeholder='Password'>
                                </div>
                                </div>
                                <div class='form-row'>
                                <div class='form-group col-md-4'>
                                    <label for='inputKeyCount'>Key Count</label>
                                    <input type='number' class='form-control' id='inputKeyCount' min='1' max='5'>
                                </div>
                                <div class='form-group col-md-4'>
                                    <label for='inputKeyUses'>Key Uses</label>
                                    <input type='number' name='inputKeyUses' id='inputKeyUses' class='form-control' min='1' max='100'></input>
                                </div>
                            </div>
                            <button type='submit' class='btn btn-primary' id='getNewKeysBtn'>Submit</button>
                        </form>
                        <table class='table table-hover' id='table'>
                        <thead id='tabletop'>
                            <tr>
                                <th scope='col'>Keys</a></th><th scope='col'>Uses</a></th>
                            </tr>
                        </thead>
                        <tbody id='keyTable'>
                        </tbody>
                        </table>
                    </span>");
    }

    private static function accountCreateModule()
    {
        return ("   <form id='regristerForm' method='post'>
                        <div class='form-row'>
                            <div class='form-group col-md-5'>
                                <label for='inputName'>Name</label>
                                <input type='text' class='form-control' id='inputName' name='inputName' placeholder='Private name for login'>
                            </div>
                        </div>
                        <div class='form-row'>
                            <div class='form-group col-md-5'>
                                <label for='inputPassword'>Password</label>
                                <input type='password' class='form-control' id='inputPassword' name='inputPassword' placeholder='Password'>
                            </div>
                        </div>
                        <div class='form-row'>
                            <div class='form-group col-md-5'>
                                <label for='inputAlias'>Name</label>
                                <input type='text' class='form-control' id='inputAlias' name='inputAlias' placeholder='Public name'>
                            </div>
                        </div>
                        <div class='form-row'>
                            <div class='form-group col-md-5'>
                                <label for='inputKey'>Key</label>
                                <input type='text' class='form-control' id='inputKey' name='inputKey' maxlength='32' placeholder='unlocks unlimited preferences'>
                            </div>
                        </div>
                        <button type='submit' class='btn btn-primary'>Submit Regristration</button>
                        <p>NOTE: There is <b>no email communication</b> that can help you, so its easy that the <b>password is lost</b></p>
                    </form>");  
    }

    private static function loginModule($name, $password)
    {
        return ("   <form id='loginForm' method='post'>
                        <div class='form-row'>
                            <div class='form-group col-md-5'>
                                <label for='inputName'>Name</label>
                                <input type='text' class='form-control' value='$name' id='inputName' name='inputName' placeholder='Private name for login'>
                            </div>
                        </div>
                        <div class='form-row'>
                            <div class='form-group col-md-5'>
                                <label for='inputPassword'>Password</label>
                                <input type='password' class='form-control' value='$password' id='inputPassword' name='inputPassword' placeholder='Password'>
                            </div>
                        </div>
                        <button type='submit' class='btn btn-primary'>Login</button>
                    </form>");
    }

    private static function userItemsTable()
    {
        return "
        <table class='table table-hover ' id='table'>
            <thead id='tabletop'>
                <tr>
                    <th scope='col'>" . 'Search Preference (not working)' . '<a>'. self::searchbarName("searchPreference", "searchByName2()")   . "</a></th>
                    <th scope='col'>" . 'Search Rating (not Working)' .     '<a>'. self::searchbarRating("searchPreferenceRating", "searchByRating2()") . "</a></th>
                </tr>
            </thead>
        </table>
        <div class='tableFixHead'>
            <table class='table table-hover ' id='table'>
                <tbody id='userItemsTable' class=''>
                </tbody>
            </table>
        </div>";

    }


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Forwarings                                                                                                       //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function getFrontPageData()
    {
        return json_encode(DMLModules::getAliasTable());
    }

    public static function getCategoriesTableData($personID)
    {
        return json_encode(DMLModules::getPersonCategoryTable($personID));
    }

    public static function getPreferenceTableData($categoryID)
    {
        return json_encode(DMLModules::getPreferenceTableData($categoryID));
    }

    public static function getAlias($name)
    {
        return DMLModules::getAlias($name);
    }

    public static function getName($alias)
    {
        return DMLModules::getName($alias);
    }

    public static function getPersonCategoryIdByPersCate($persons_id, $category)
    {
        return DMLModules::getPersonCategoryIdByPersCate($persons_id, $category);
    }

    public static function getPersonCategoryIdByPreference($preferenceId)
    {
        return DMLModules::getPersonCategoryIdByPreference($preferenceId);
    }

    public static function addAccount($accountname, $alias, $password, $key)
    {
        if(DMLModules::addAccount($accountname, $alias, $password, $key))
        {
            include_once("./Session.php");

        }
        else 
        {
            return self::error404();
        }
    } 

    public static function test()
    {
        
return self::getHTML("","","<div class='input-group mb-3'>
<input type='text' class='form-control' placeholder='Recipient's username' aria-label='Recipient's username' aria-describedby='basic-addon2'>
<div class='input-group-append'>
  <button class='btn btn-outline-secondary' type='button'>Button</button>
</div>
</div>'","");
    }
}
?>