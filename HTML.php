<?php
include('DMLModules.php');
class HTML
{
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   basic                                                                                                            //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function getHTML($style, $headcontent, $bodycontent, $script)
    {
        return "<!DOCTYPE html><html>
                <head><title>Preferix</title>
                <link rel='stylesheet' href='/food/style/style.css'>
                <link rel='stylesheet' href='/food/style/bootstrap-5.2.2-dist/css/bootstrap.min.css'>".
                $style.
                $headcontent.
               "</head>
                <body>
                    <div id='content' style='width:80vw;margin:auto;'>".
                        $bodycontent.
               '    </div>' . 
               self::Impressum() .
               '
                </body>
                </html>'.
                $script;
    }

    private static function script($src)
    {
        return "<script src='food/js/".$src.".js'></script>";
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

    public static function Impressum()
    {
        return '
        <footer class="bg-light text-center text-lg-start" style="width: 100%;">
        <div class="container p-6 pb-0 row row-cols-2 py-2 my-2 border-top">
            <div class="col">
                <div class="col-auto mb-4 mb-md-0">
                    <h1>Impressum</h1>
                    <table>
                        <tbody>
                            <tr>
                                <th scope="col"><b>Name: </b></th>
                                <th scope="col">Fee-Zara Julianna Zotter</th>
                            </tr>  
                            <tr>
                                <th scope="col"><b>E-Mail: </b></th>
                                <th scope="col"> julianazotter@proton.me</th>
                            </tr>   
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col">
                <div class="col-auto mb-4 mb-md-0">
                    <h1>Links</h1>
                    <table>
                        <tbody>
                            <tr>    
                                <th scope="col"><a href="/">main page</a></th>
                            </tr> 
                            <tr>
                                <th scope="col"><a href="/login">login</a></th>
                            </tr>  
                            <tr>
                                <th scope="col"><a href="/reg">regristration (key neened)</a></th>
                            </tr>   
                            <tr>
                                <th scope="col"><a href="/impressum">impressum</a></th>
                            </tr>  
                            <tr>
                                <th scope="col"><a href="/hints">API and shortlink manual (not implemented -> blank page)</a></th>
                            </tr> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        </footer>
        ';
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
        $result = self::dataTableWhere('categories_id, persons_id', 
                                        'cross_person_categories', 
                                        "cross_person_categories_id=$cross_person_categories_id");
        $result = $result[0];
        $categories_id = $result['categories_id'];
        $persons_id    = $result['persons_id'];
        $name = DMLModules::getAlias($persons_id);
        $bodycontent = self::navigationBar('Start', $name, $categories_id);
            //end navigation bar
        $bodycontent .= self::preferenceTable($preferenceId);

        echo self::getHTML("", "", $bodycontent, "");
    }

    public static function main()
    {
        echo self::getHTML("", "", self::navigationBar('Start', null, null) . self::table('alias', 'persons'), self::script("index"));
    }

    public static function adminPage()
    {
        echo self::getHTML("", "", self::keyModule(), self::script("admin"));
    }

    public static function regristration()
    {
        echo self::getHTML("", "", self::accountCreateModule(), self::script("regrister"));
    }

    public static function login($name, $password)
    {
        echo self::getHTML("", "", self::loginModule($name, $password), self::script("login"));
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

        $array = DMLModules::getTable("category", "categories");
        $table = "";
        foreach ($array as $value) { $table .= "<option value='$value'>$value</option>"; }

        return self::getHTML("", "", 
                            self::helloUser($userName, $password) . 
                           "<h6>Note: reload the page often to see if you did everything right, when updating or deleting a preference or category it gets not shown in the list and you cant search for preferences...</h6>
                            <div class='container text-center'>
                                <div class='row'>
                                    <div class='col-6' id='userCategories'>" .
                                        self::userCategoyTable($userName) .
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
                                        <button id='deleteCategory'class='btn btn-dark' onclick='deleteCategory()'>Delete Category</button>
                                    </div>
                                    <div class='col-6'>
                                        <input id='inputPreference' class='form-control' type='text' placeholder='your preference'>
                                        <input id='inputRating' class='form-control' type='number' value='0' min='0' max='10' placeholder='rating'>
                                        <button id='addChangePreference' class='btn btn-primary'onclick='acPreference()'>Add/Change Preference</button>
                                        <button id='deletePreference' class='btn btn-dark onclick='deletePreference()'>Delete Preference</button>
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
    private static function searchbarName()
    {
        return '<input class="input marginLeft" type="text" id="sortValue" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByName()"/>';
    }

    private static function searchbarNameRating()
    {
        return ('<input class="input marginLeft" type="text" id="sortValue" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByName()"/>
                 <input class="input" type="text" id="sortRating" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByRating()"/>');
    }

    private static function searchbarRating()
    {
        return '<input class="input" type="text" id="sortRating" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByRating()"/>';
    }

    private static function helloUser($name, $password)
    {
        return ("<h1>Hello <b id='myUsername' class='$password'>$name</b> and i know your public name is <b id='myAlias'>" . DMLModules::getAlias($name) . "</b></h1>");
    }

    private static function table($select, $from)
    {
        $array = DMLModules::getTable($select, $from);
        $returnTable = "";
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td class='$value'>{$value}</td>"
            ."</tr>";
        }

        return self::tableOne($select, $returnTable);
    }

    private static function tableOne($header, $table)
    {
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
                        <th scope='col'><a>" . ucfirst($header) . '</a><a>' . self::searchbarName() . '</a>' . "</th>
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
                        <th scope='col'><a>" . ucfirst($header1) . "</a><a>" . self::searchbarName() .   "</a></th>
                        <th scope='col'>" .    ucfirst($header2) . '</a><a>' . self::searchbarRating() . "</a></th>
                    </tr>   
                </thead>
            </table>
        </div>";
    }

    public static function returnTable($select, $from)
    {
        $array = DMLModules::getTable($select, $from);
        $returnTable = "";
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td class='$value'>{$value}</td>"
            ."</tr>";
        }
        return self::tableOne($select, $returnTable);
    }

    function dataTableWhere($select, $from, $where)
    {
        //returns nested array Structure == array(array['value1', 'value2', ...], array['value1', 'value2', ...], array['value1', 'value2', ...], ...)
        return DMLModules::getTableWhere($select, $from, $where); 
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

        return self::tableTwo('Preference', 'Rating', $returnTable);
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
        return self::userCategoyTable($userName);
    }

    private static function userCategoyTable($userId)
    {
        $arrays = DMLModules::userCategoryTable($userId);
        $array1 = $arrays[0];
        $array2 = $arrays[1];
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
            ."</tr>";
        }
        return self::tableTwo('Category', 'Amount', $returnTable);
    }

    private function categoriesTable($personID)
    {
        $array = DMLModules::getTableWhere("categories_id, cross_person_categories_id", "cross_person_categories", "persons_id='$personID'");
        $returnTable = "";
        
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td class='" . $value["cross_person_categories_id"] . "' id='" . $value['categories_id'] . "'>" . ucfirst($value['categories_id']) . "</td>"
            ."</tr>";
        }
        return self::tableOne('Preference', $returnTable);
    }

    private static function categoriesTableReturn($personID)
    {
        $array = DMLModules::getTableWhere("categories_id, cross_person_categories_id", "cross_person_categories", "persons_id='$personID'");
        $returnTable = "";
        
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td class='" . $value["cross_person_categories_id"] . "' id='" . $value['categories_id'] . "'>" . ucfirst($value['categories_id']) . "</td>"
            ."</tr>";
        }
        return self::tableOne('Preference', $returnTable);
    }

    public static function returnCategoriesTable($personID)
    {
        $array = DMLModules::getTableWhere("categories_id, cross_person_categories_id", "cross_person_categories", "persons_id='$personID'");
        $returnTable = "";
        
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td class='" . $value["cross_person_categories_id"] . "' id='" . $value['categories_id'] . "'>" . ucfirst($value['categories_id']) . "</td>"
            ."</tr>";
        }
        return self::tableOne('Preference', $returnTable);
    }

    private static function navigationBar($navigationPoint1, $navigationPoint2, $navigationPoint3)
    {
        return ("   <h2 class='navigation' id='navigation'>
                        <a class='Start text-decoration-none' id='navigation1'>" . ucfirst($navigationPoint1) . "</a>
                        <a class='text-decoration-none'      id='navigation2'>"  . ucfirst($navigationPoint2) . "</a>                
                        <a class='text-decoration-none'      id='navigation3'>"  . ucfirst($navigationPoint3) . "</a>
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
        <table class='tableFixHead table table-hover ' id='table'>
            <thead id='tabletop'>
                <tr>
                    <th scope='col'>" . 'Preference' . '<a>'. self::searchbarName()   . "</a></th>
                    <th scope='col'>" . 'Rating' .     '<a>'. self::searchbarRating() . "</a></th>
                </tr>
            </thead>
            <tbody id='userItemsTable' class=''>
            </tbody>
        </table>";

    }


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Forwarings                                                                                                       //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function personTable($select, $from, $where, $person)
    {
        $result = DMLModules::getTableWhere($select, 
                                            $from, 
                                            "$where='$person'");
        return $result[0][$select];
    }

    public static function getFrontPageData()
    {
        return json_encode(DMLModules::getTable('alias', 'persons'));
    }

    public static function getCategoriesTableData($personID)
    {
        return json_encode(DMLModules::getTableWhere("categories_id, cross_person_categories_id", "cross_person_categories", "persons_id='$personID'"));
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

    public static function newKey($max_users, $adminname, $adminpass)
    {
        return DMLModules::addNewKey($max_users, $adminname, $adminpass);
    }

    public static function addAccount($accountname, $alias, $password, $key)
    {
        if(DMLModules::addAccount($accountname, $alias, $password, $key))
        {
            echo self::login($accountname, $password);
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