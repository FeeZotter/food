<?php
//include
include("HTML.php");
include("HTMLModules.php");
class DirectLink 
{
    public function Person(string $alias)
    {
        //check if there is an error
        $htmlComp = new HTMLModules();  
        $name = '';
        try {
            $name = $htmlComp->getFirstMatchValue('name', 'persons', "alias='$alias'");
        } catch (\Throwable $throwedError) {
            $html = new HTML('error 404');
            $html->resetScript();
            $html->addScript('/food/js/error404.js');
            $html->addToBody('Person not found | redirecting you shortly in <a id="timer"></a> seconds');
            return $html->getHTML();
        }

        //innitialize classes
        $html = new HTML('LiKings');
        $htmlComp = new HTMLModules();  

        $html->addToHead('<link rel="stylesheet" href="/food/style/style.css">');
        $html->addToHead('<link rel="stylesheet" 
                          href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
                          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
                          crossorigin="anonymous">');

        $html->addToHead($htmlComp->navigationBar('Start', $alias, null));

        $html->addToBody($htmlComp->categoriesTable($name));

        echo $html->getHTML();
    }

    public function Preference(string $alias, string $category)
    {
        //innitialize classes
        $html = new HTML('LiKings');
        $htmlComp = new HTMLModules();  

        //style
        $html->addToHead('<link rel="stylesheet" href="/food/style/style.css">');
        $html->addToHead('<link rel="stylesheet" 
                          href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
                          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
                          crossorigin="anonymous">');

        //body
            //start navigation bar
        $persons_id = $htmlComp->getFirstMatchValue('name', 'persons', "alias='$alias'");
        $cross_person_categories_id = $htmlComp->getFirstMatchValue('cross_person_categories_id', 
                                                                    'cross_person_categories', 
                                                                    "persons_id='$persons_id'&&categories_id='$category'");

        $html->addToHead($htmlComp->navigationBar('Start', $alias, $category));
            //end navigation bar
        $html->addToBody($htmlComp->preferenceTable($cross_person_categories_id));

        echo $html->getHTML();
    }

    public function PreferenceByID(int $preferenceID)
    {
        //innitialize classes
        $html = new HTML('LiKings');
        $htmlComp = new HTMLModules();  

        //style
        $html->addToHead('<link rel="stylesheet" href="/food/style/style.css">');
        $html->addToHead('<link rel="stylesheet" 
                          href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
                          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
                          crossorigin="anonymous">');

        //body
            //start navigation bar
        $cross_person_categories_id = $htmlComp->getFirstMatchValue('cross_person_categories_id', 
                                                                    'preferences', 
                                                                    "preferences_id='$preferenceID'");
        $result = $htmlComp->dataTableWhere('categories_id, persons_id', 
                                            'cross_person_categories', 
                                            "cross_person_categories_id=$cross_person_categories_id");
        $result = $result[0];
        $categories_id = $result['categories_id'];
        $persons_id    = $result['persons_id'];
        $name = $htmlComp->getFirstMatchValue('alias', 'persons', "name='$persons_id'");
        $html->addToHead($htmlComp->navigationBar('Start', $name, $categories_id));
            //end navigation bar
        $html->addToBody($htmlComp->preferenceTable($preferenceID));

        echo $html->getHTML();
    }

    public function main()
    {
        //innitialize classes
        $html = new HTML('LiKings');
        $htmlComp = new HTMLModules();  

        $html->addToHead('<link rel="stylesheet" href="/food/style/style.css">');
        $html->addToHead('<link rel="stylesheet" 
                          href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
                          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
                          crossorigin="anonymous">');

        $html->addToBody($htmlComp->navigationBar('Start', null, null));
        $html->addToBody($htmlComp->table('alias', 'persons'));

        echo $html->getHTML();
    }

    public function adminPage()
    {
        $html = new HTML('Admin');
        echo $html->getHTML();
    }

    public function regristration()
    {
        $html = new HTML('Regrister');
        $html->addScript("/js/regrister.js");
        echo $html;
    }

    public function login()
    {
        $html = new HTML('Login');
        $html->addScript("/js/login.js");
        echo $html;
    }
}
?>