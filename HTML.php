<?php
include('DMLModules.php');
class HTML
{
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   basic                                                                                                            //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private $htmlstart   = "<!DOCTYPE html><html>";
    private $headstart   = "<head><title>LiKings</title>";
    private $style       = "";
    private $headcontent = "";
    private $headend     = "</head>";
    private $bodystart   = "<body>";
    private $bodycontent = "";
    private $bodyend     = "</body>";
    private $htmlend     = "</html>";
    private $script      = "";

    private $dml;
    function __construct()
    {
        $this->dml = new DMLModules();
        $this->addStyle("/food/style/style.css");
        $this->addStyle("/food/style/bootstrap-5.2.2-dist/css/bootstrap.min.css");
        $this->addScript('/food/js/index.js');
    }

    public function getHTML()
    {
        return $this->htmlstart.
               $this->headstart.
               $this->style.
               $this->headcontent.
               $this->headend.
               $this->bodystart.
               $this->bodycontent.
               $this->bodyend.
               $this->htmlend.
               $this->script;
    }

    public function resetHead()   { $this->headcontent = ""; }
    public function resetBody()   { $this->bodycontent = ""; }
    public function resetStyle()  { $this->style       = ""; }
    public function resetScript() { $this->script      = ""; }

    private function addToBody($addToBody)
    {
        $this->bodycontent .= $addToBody;
    }

    private function addStyle($styleLink)
    {
        $this->style .="<link rel='stylesheet' href='$styleLink'>";
    }

    private function addStyleAdvanced($style)
    {
        $this->style .= $style;
    }

    private function addToHead($addToHead)
    {
        $this->headcontent .= $addToHead;
    }

    private function addScript($script)
    {
        $this->script .= "<script src='$script'></script>";
    }

    private function addScriptWithSource($script)
    {
        $this->script .= $script;
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Pages                                                                                                            //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function Person(string $alias)
    {
        //check if there is an error
        $name = '';
        try {
            $name = DMLModules::getName($alias);
        } catch (\Throwable $throwedError) {
            return $this->error404();
        }
        $this->navigationBar('Start', $alias, null);
        $this->categoriesTable($name);
        echo $this->getHTML();
    }

    public function Preference(string $alias, string $category)
    {
            //start navigation bar
        $persons_id = DMLModules::getName($alias);
        $cross_person_categories_id = DMLModules::getPersonCategoryIdByPersCate($persons_id, $category);
        $this->navigationBar('Start', $alias, $category);
            //end navigation bar
        $this->preferenceTable($cross_person_categories_id);
        echo $this->getHTML();
    }

    public function PreferenceByID(int $preferenceId)
    {
            //start navigation bar
        $cross_person_categories_id = DMLModules::getPersonCategoryIdByPreference($preferenceId);
        $result = $this->dataTableWhere('categories_id, persons_id', 
                                        'cross_person_categories', 
                                        "cross_person_categories_id=$cross_person_categories_id");
        $result = $result[0];
        $categories_id = $result['categories_id'];
        $persons_id    = $result['persons_id'];
        $name = DMLModules::getAlias($persons_id);
        $this->navigationBar('Start', $name, $categories_id);
            //end navigation bar
        $this->preferenceTable($preferenceId);

        echo $this->getHTML();
    }

    public function main()
    {
        $this->navigationBar('Start', null, null);
        $this->table('alias', 'persons');
        echo $this->getHTML();
    }

    public function adminPage()
    {
        $this->resetScript();
        $this->addScript('food/js/admin.js');

        $this->keyModule();

        echo $this->getHTML();
    }

    public function regristration()
    {
        $this->resetScript();
        $this->accountCreateModule();
        echo $this->getHTML();
    }

    public function login($name, $password)
    {
        $this->resetScript();
        $this->addScript("food/js/login.js");
        $this->loginModule($name, $password);
        echo $this->getHTML();
    }

    public function error404()
    {
        $html = new HTML();
        $html->resetScript();
        $html->addScript('/food/js/error404.js');
        $html->addToBody('Error 404: Page not found | redirecting you shortly in <a id="timer"></a> seconds');
        return $html->getHTML();
    }

    public function userMainPage($userName, $password)
    {
        if(!DMLModules::loginSuccess($userName, $password))
        {
            return self::error404();
        }
        $html = new HTML();
        $html->addToBody("nothing here for the moment.<br>
                          Want: See list with all categories<br>
                          +------------------------+<br>
                          |Category   |Count Items |<br>
                          +------------------------+<br>
                          |Food       | 4          |<br>
                          |Colour     | 0          |<br>
                          |Flowers    | 0          |<br>
                          |Laptops    | 7          |<br>
                          +------------------------+<br>
                          <br>
                          if clicked it looks like this:<br>
                          Add Food: [____] with Rating: [_____]<br>
                          +---------------------+<br>
                          |Food     | Rating    |<br>
                          +---------------------+<br>
                          |Potato   | 9         |<br>
                          |Potato   | 9         |<br>
                          |Potato   | 9         |<br>
                          |Potato   | 9         |<br>
                          +---------------------+<br>  
                          ");
        $html->addToBody($html->userCategoyTable($userName));
        return $html->getHTML();
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Modules                                                                                                          //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private function searchbarName()
    {
        $this->addToBody('<input class="input marginLeft" type="text" id="sortValue" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByName()"/>');
    }

    private function searchbarNameRating()
    {
        $this->addToBody('<input class="input marginLeft" type="text" id="sortValue" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByName()"/>
                          <input class="input" type="text" id="sortRating" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByRating()"/>');
    }

    private function searchbarRating()
    {
        $this->addToBody('<input class="input" type="text" id="sortRating" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByRating()"/>');
    }

    private function table($select, $from)
    {
        $array = $this->dml->getTable($select, $from);
        $returnTable = "";
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td class='$value'>{$value}</td>"
            ."</tr>";
        }

        $this->addToBody("  <table class='table table-hover' id='table'>
                                <thead id='tabletop'>
                                    <tr>
                                        <th scope='col'><a>" . ucfirst($select) . '</a><a>' . $this->searchbarName() . '</a>' . '</th>
                                    </tr>
                                </thead>
                                <tbody id="tableContent">' .
                                    $returnTable .
                                '</tbody>
                            </table>');
    }

    public function returnTable($select, $from)
    {
        $array = $this->dml->getTable($select, $from);
        $returnTable = "";
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td class='$value'>{$value}</td>"
            ."</tr>";
        }

        return "<table class='table table-hover' id='table'>
                    <thead id='tabletop'>
                        <tr>
                            <th scope='col'><a>" . ucfirst($select) . '</a><a>' . $this->searchbarName() . '</a>' . '</th>
                        </tr>
                    </thead>
                    <tbody id="tableContent">' .
                        $returnTable .
                    '</tbody>
                </table>';
    }

    function dataTableWhere($select, $from, $where)
    {
        //returns nested array Structure == array(array['value1', 'value2', ...], array['value1', 'value2', ...], array['value1', 'value2', ...], ...)
        return $this->dml->getTableWhere($select, $from, $where); 
    }

    private function preferenceTable($categoryID)
    {
       # $array = $dml->getTableWhere("preference, rating", 'preferences', "cross_person_categories_id='$categoryID'");
        $array = $this->dml->getPreferenceTable($categoryID);
        $returnTable = "";
        
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td class='color" . $value['rating'] . "'>" . ucfirst($value['preference']) . "</td>"
            .   "<td class='color" . $value['rating'] . "'>" . ucfirst($value['rating'])    . "</td>"
            ."</tr>";
        }

        $this->addToBody("  <table class='table table-hover' id='table'>
                                <thead id='tabletop'>
                                    <tr>
                                        <th scope='col'>" . 'Preference'       . '</a><a>'. $this->searchbarName() . "</a></th>
                                        <th scope='col'>" . 'Rating' . '</a><a>'. $this->searchbarRating() . "</a></th>
                                    </tr>
                                </thead>
                                <tbody id='tableContent'>" .
                                    $returnTable .
                                "</tbody>
                            </table>");
    }

    public function returnPreferenceTable($categoryID)
    {
       # $array = $dml->getTableWhere("preference, rating", 'preferences', "cross_person_categories_id='$categoryID'");
        $array = $this->dml->getPreferenceTable($categoryID);
        $returnTable = "";
        
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td class='color" . $value['rating'] . "'>" . ucfirst($value['preference']) . "</td>"
            .   "<td class='color" . $value['rating'] . "'>" . ucfirst($value['rating'])    . "</td>"
            ."</tr>";
        }

        return "<table class='table table-hover' id='table'>
                    <thead id='tabletop'>
                        <tr>
                            <th scope='col'>" . 'Preference'       . '</a><a>'. $this->searchbarName() . "</a></th>
                            <th scope='col'>" . 'Rating' . '</a><a>'. $this->searchbarRating() . "</a></th>
                        </tr>
                    </thead>
                    <tbody id='tableContent'>" .
                        $returnTable .
                    "</tbody>
                </table>";
    }

    private function userCategoyTable($userId)
    {
        $array = $this->dml->userCategoryTable($userId);
        $returnTable = "";
        $a = 0;
        $b = 1;
        
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>" //need to look for values
            .   "<td class='" . $value . "' id='" . $value . "'>" . ucfirst($value) . "</td>"
            ."</tr>";
        }

        $this->addToBody("  <table class='table table-hover' id='table'>
                                <thead id='tabletop'>
                                    <tr>
                                        <th scope='col'>" . 'Category'  . "</th>
                                        <th scope='col'>" . 'Amonut'  . "</th>
                                    </tr>
                                </thead>
                                <tbody id='tableContent'>" .
                                    $returnTable .
                                "</tbody>
                            </table>");
        return print_r($this->dml->userCategoryTable($userId), true);
    }

    private function categoriesTable($personID)
    {
        $array = $this->dml->getTableWhere("categories_id, cross_person_categories_id", "cross_person_categories", "persons_id='$personID'");
        $returnTable = "";
        
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td class='" . $value["cross_person_categories_id"] . "' id='" . $value['categories_id'] . "'>" . ucfirst($value['categories_id']) . "</td>"
            ."</tr>";
        }

        $this->addToBody("  <table class='table table-hover' id='table'>
                                <thead id='tabletop'>
                                    <tr>
                                        <th scope='col'>" . 'Preference'  . '</a><a>'. $this->searchbarName() . "</a></th>
                                    </tr>
                                </thead>
                                <tbody id='tableContent'>" .
                                    $returnTable .
                                "</tbody>
                            </table>");
    }

    public function returnCategoriesTable($personID)
    {
        $array = $this->dml->getTableWhere("categories_id, cross_person_categories_id", "cross_person_categories", "persons_id='$personID'");
        $returnTable = "";
        
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td class='" . $value["cross_person_categories_id"] . "' id='" . $value['categories_id'] . "'>" . ucfirst($value['categories_id']) . "</td>"
            ."</tr>";
        }

        return "<table class='table table-hover' id='table'>
                    <thead id='tabletop'>
                        <tr>
                            <th scope='col'>" . 'Preference'  . '</a><a>'. $this->searchbarName() . "</a></th>
                        </tr>
                    </thead>
                    <tbody id='tableContent'>" .
                        $returnTable .
                    "</tbody>
                </table>";
    }

    private function navigationBar($navigationPoint1, $navigationPoint2, $navigationPoint3)
    {
        $this->addToBody("  <h1 class='navigation' id='navigation'>
                                <a class='Start text-decoration-none' id='navigation1'>" . ucfirst($navigationPoint1) . "</a>
                                <a class='text-decoration-none'      id='navigation2'>"  . ucfirst($navigationPoint2) . "</a>                
                                <a class='text-decoration-none'      id='navigation3'>"  . ucfirst($navigationPoint3) . "</a>
                            </h1>");
    }

    private function keyModule()
    {
        $this->addToBody("  <span class='border border-light'>
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

    private function accountCreateModule()
    {
        $this->addScript("food/js/regrister.js");
        $this->addToBody("  <form id='regristerForm' method='post'>
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

    private function loginModule($name, $password)
    {
        $this->addScript("food/js/login.js");
        $this->addToBody("  <form id='loginForm' method='post'>
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


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   Forwarings                                                                                                       //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getByRequest($select, $from, $where)
    {
        $result = $this->dml->getTableWhere($select, 
                                            $from, 
                                            "$where='$_REQUEST[$where]'");
        return $result[0][$select];
    }

    public function personTable($select, $from, $where, $person)
    {
        $result = $this->dml->getTableWhere($select, 
                                            $from, 
                                            "$where='$person'");
        return $result[0][$select];
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
            $html = new HTML();
            return $html->login($accountname, $password);
        }
        else 
        {
            $html = new HTML();
            return $html->error404();
        }
    } 
}
?>