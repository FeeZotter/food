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
            $html->addScript('./food/js/error404.js');
            $html->addToBody('Person not found | redirecting you shortly in <a id="timer"></a> seconds');
            return $html->getHTML();
        }

        //innitialize classes
        $html = new HTML('LiKings');
        $htmlComp = new HTMLModules();  

        //html scripts
        $html->addScript("./food/js/index.js");

        $html->addToHead('<link rel="stylesheet" href="./food/style/style.css">');
        $html->addToHead('<link rel="stylesheet" 
                          href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
                          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
                          crossorigin="anonymous">');

        $html->addToHead($htmlComp->navigationBar('Start', $alias, null));

        $html->addToBody($htmlComp->categoriesTable($name));

        echo $html->getHTML();
    }

    public function Preference(int $preferenceID)
    {
        //innitialize classes
        $html = new HTML('LiKings');
        $htmlComp = new HTMLModules();  

        //scripts
        $html->addScript("./food/js/index.js");

        //style
        $html->addToHead('<link rel="stylesheet" href="./food/style/style.css">');
        $html->addToHead('<link rel="stylesheet" 
                          href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
                          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
                          crossorigin="anonymous">');

        //body
            //start beauty navigation bar
        $cross_person_categories_id = $htmlComp->getFirstMatchValue('cross_person_categories_id', 
                          'preferences', 
                          "preferences_id='$preferenceID'");
        $categories_id = $htmlComp->getFirstMatchValue('categories_id', 
                                                       'cross_person_categories', 
                                                       "cross_person_categories_id='$cross_person_categories_id");
        $persons_id = $htmlComp->getFirstMatchValue('persons_id', 
                                                    'cross_person_categories', 
                                                    "cross_person_categories_id='$cross_person_categories_id");
        $html->addToHead($htmlComp->navigationBar('Start', $persons_id, $categories_id));
            //end
        $html->addToBody($htmlComp->preferenceTable($preferenceID));

        echo $html->getHTML();
    }

    public function main()
    {
        //innitialize classes
        $html = new HTML('LiKings');
        $htmlComp = new HTMLModules();  

        //html scripts
        $html->addScript("./food/js/index.js");

        $html->addToHead('<link rel="stylesheet" href="./food/style/style.css">');
        $html->addToHead('<link rel="stylesheet" 
                          href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
                          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
                          crossorigin="anonymous">');

        $html->addToHead($htmlComp->navigationBar('Start', null, null));
        $html->addToBody($htmlComp->table('alias', 'persons'));

        echo $html->getHTML();
    }
}
?>