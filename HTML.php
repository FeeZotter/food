<?php
include('DMLModules.php');
class HTML
{
    private $htmlstart   = "<!DOCTYPE html><html>";
    private $headstart   = "<head><title>$title</title>";
    private $style       = "";
    private $headcontent = "";
    private $headend     = "</head>";
    private $bodystart   = "<body>";
    private $bodycontent = "";
    private $bodyend     = "</body>";
    private $htmlend     = "</html>";
    private $script      = "";
    function __construct()
    {
        $this->addStyle("/food/style/style.css");
        $this->addStyleAdvanced('<link rel="stylesheet" 
                                  href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
                                  integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
                                  crossorigin="anonymous">');
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
    public function resetScript() { $this->script      = ""; }
    public function resetStyle()  { $this->style       = ""; }

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
            $name = $this->getName($alias);
        } catch (\Throwable $throwedError) {
            $html = new HTML('error 404');
            $html->resetScript();
            $html->addScript('/food/js/error404.js');
            $html->addToBody('Person not found | redirecting you shortly in <a id="timer"></a> seconds');
            return $html->getHTML();
        }

        $this->navigationBar('Start', $alias, null);

        $this->categoriesTable($name);

        echo $this->getHTML();
    }

    public function Preference(string $alias, string $category)
    {
        //innitialize classes
        $html = new HTML('LiKings');
        $htmlComp = new HTMLModules();  

        //body
            //start navigation bar
        $persons_id = $htmlComp->getName($alias);
        $cross_person_categories_id = $htmlComp->getPersonCategoryIdByPersCate($persons_id, $category);

        $html->addToHead($htmlComp->navigationBar('Start', $alias, $category));
            //end navigation bar
        $html->addToBody($htmlComp->preferenceTable($cross_person_categories_id));

        echo $html->getHTML();
    }

    public function PreferenceByID(int $preferenceId)
    {
        //innitialize classes
        $html = new HTML('LiKings');
        $htmlComp = new HTMLModules();  

        //body
            //start navigation bar
        $cross_person_categories_id = $htmlComp->getPersonCategoryIdByPreference($preferenceId);
        $result = $htmlComp->dataTableWhere('categories_id, persons_id', 
                                            'cross_person_categories', 
                                            "cross_person_categories_id=$cross_person_categories_id");
        $result = $result[0];
        $categories_id = $result['categories_id'];
        $persons_id    = $result['persons_id'];
        $name = $htmlComp->getAlias($persons_id);
        $html->addToHead($htmlComp->navigationBar('Start', $name, $categories_id));
            //end navigation bar
        $html->addToBody($htmlComp->preferenceTable($preferenceId));

        echo $html->getHTML();
    }

    public function main()
    {
        //innitialize classes
        $html = new HTML('LiKings');
        $htmlComp = new HTMLModules();  

        $html->addToBody($htmlComp->navigationBar('Start', null, null));
        $html->addToBody($htmlComp->table('alias', 'persons'));

        echo $html->getHTML();
    }

    public function adminPage()
    {
        $html = new HTML('Admin');
        $htmlComp = new HTMLModules();

        $html->resetScript();
        $html->addScript('food/js/admin.js');

        $html->addToBody($htmlComp->keyModule());

        echo $html->getHTML();
    }

    public function regristration()
    {
        $html = new HTML('Regrister');
        $html->addScript("food/js/regrister.js");
        echo $html;
    }

    public function login()
    {
        $html = new HTML('Login');
        $html->addScript("food/js/login.js");
        echo $html;
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
        $dml = new DMLModules();
        $array = $dml->getTable($select, $from);
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

    private function tableWhere($select, $from, $where)
    {
        $dml = new DMLModules();
        $array = $dml->getTableWhere($select, $from, $where);
        $returnTable = "";
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td>{$value}</td>"
            ."</tr>";
        }

        $this->addToBody(   '<table class="table table-hover" id="table">
                                <thead id="tabletop">
                                    <tr>
                                        <th scope="col"><a>' . ucfirst($select) . '</a><a>'. $this->searchbarName() . '</a></th>
                                    </tr>
                                </thead>
                                <tbody id="tableContent">' .
                                    $returnTable .
                                '</tbody>
                            </table>');
    }

    function dataTableWhere($select, $from, $where)
    {
        $dml = new DMLModules();
        //returns nested array Structure == array(array['value1', 'value2', ...], array['value1', 'value2', ...], array['value1', 'value2', ...], ...)
        return $dml->getTableWhere($select, $from, $where); 
    }

    private function table2($select, $select2, $from)
    {
        $dml = new DMLModules();
        $array = $dml->getTable("$select, $select2", $from);
        $returnTable = "";
        foreach ($array as $value)
        {
            $returnTable .=
            "<tr>"
            .   "<td>{$value[0]}</td>"
            .   "<td>{$value[1]}</td>"
            ."</tr>";
        }

        $this->addToBody('  <table class="table table-hover" id="table">
                                <thead id="tabletop">
                                    <tr>
                                        <th scope="col">' . ucfirst($select)  . '</a><a>'. $this->searchbarName() . '</a></th>
                                        <th scope="col">' . ucfirst($select2) . '</a><a>'. $this->searchbarNameRating() . '</a></th>
                                    </tr>
                                </thead>
                                <tbody id="tableContent">' .
                                    $returnTable .
                                '</tbody>
                            </table>');
    }

    private function preferenceTable($categoryID)
    {
        $dml = new DMLModules();
       # $array = $dml->getTableWhere("preference, rating", 'preferences', "cross_person_categories_id='$categoryID'");
        $array = $dml->getPreferenceTable($categoryID);
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

    private function categoriesTable($personID)
    {
        $dml = new DMLModules();
        $array = $dml->getTableWhere("categories_id, cross_person_categories_id", "cross_person_categories", "persons_id='$personID'");
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
    
    private function nextPage($page, $identifier)
    {
        $this->addToBody("  <form action='$page' method='post'>
                                <label class='marginLeft' for='$identifier'>$identifier:</label>
                                <input type='text' name='$identifier' id='$identifier'>
                                <input type='submit' value='Submit'>
                            </form>");
    }

    private function navigationBar($navigationPoint1, $navigationPoint2, $navigationPoint3)
    {
        $this->addToBody("  <h1 class='navigation' id='navigation'>
                                <a class='Start' id='navigation1'>" . ucfirst($navigationPoint1) . "</a>
                                <a class=''      id='navigation2'>" . ucfirst($navigationPoint2) . "</a>                
                                <a class=''      id='navigation3'>" . ucfirst($navigationPoint3) . "</a>
                            </h1>");
    }
    
    function getByRequest($select, $from, $where)
    {
        $dml = new DMLModules();
        $result = $dml->getTableWhere($select, 
                                      $from, 
                                      "$where='$_REQUEST[$where]'");

        return $result[0][$select];
    }

    public function personTable($select, $from, $where, $person)
    {
        $dml = new DMLModules();
        $result = $dml->getTableWhere($select, 
                                      $from, 
                                      "$where='$person'");

        return $result[0][$select];
    }

    public function getAlias($name)
    {
        $dml = new DMLModules();
        return $dml->getAlias($name);
    }

    public function getName($alias)
    {
        $dml = new DMLModules();
        return $dml->getName($alias);
    }

    public function getPersonCategoryIdByPersCate($persons_id, $category)
    {
        $dml = new DMLModules();
        return $dml->getPersonCategoryIdByPersCate($persons_id, $category);
    }

    public function getPersonCategoryIdByPreference($preferenceId)
    {
        $dml = new DMLModules();
        return $dml->getPersonCategoryIdByPreference($preferenceId);
    }

    public function newKey($max_users, $adminname, $adminpass)
    {
        $dml = new DMLModules();
        return $dml->addNewKey($max_users, $adminname, $adminpass);
    }

    function addAccount($accountname, $alias, $password, $key)
    {
        $dml = new DMLModules();
        return $dml->addAccount($accountname, $alias, $password, $key);
    }

    private function keyModule()
    {
        $this->addToBody("  <span class='border border-light'>
                                <form>
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
                                            <input type='number' class='form-control' id='inputKeyCount'>
                                        </div>
                                        <div class='form-group col-md-4'>
                                            <label for='inputKeyUses'>Key Uses</label>
                                            <input type='number' name='inputKeyUses' id='inputKeyUses' class='form-control'></input>
                                        </div>
                                    </div>
                                    <button type='button' class='btn btn-primary' id='getNewKeysBtn'>Submit</button>
                                </form>
                            </span>");
    }
}
?>