<?php
//include
include("HTML.php");
include("HTMLModules.php");
class DirectLink 
{
    public function Person(string $person)
    {
        //need rewriting, should be like main only that it moves directly to the person

        $personNavigation = null;
        $htmlComp = new HTMLModules();  

        try {
            $result = $htmlComp->getFirstMatchValue('alias', 'persons', "alias='$person'");
            $personNavigation = $result;
        } catch (\Throwable $throwedError) {
            echo 'Person not found';
            echo $throwedError;
            return;
        }

        //////////////////////main() code
        //innitialize classes
        $html = new HTML('LiKings');
        $htmlComp = new HTMLModules();  

        //html scripts
        $html->addScript('<script src="./food/js/index.js"></script>');
        $html->addScript('<script src="./food/js/viewLayer1.js"></script>');

        $html->addToHead('<link rel="stylesheet" href="./food/style/style.css">');
        $html->addToHead('<link rel="stylesheet" 
                          href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
                          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
                          crossorigin="anonymous">');

        $html->addToHead($htmlComp->navigationBar('Start', $personNavigation, null));
        $html->addToBody($htmlComp->table('alias', 'persons'));

        echo $html->getHTML();
    }

    public function Preference(int $cross_person_categories_id)
    {
        //////////////////////main() code
        //innitialize classes
        $html = new HTML('LiKings');
        $htmlComp = new HTMLModules();  

        //html scripts
        $html->addScript('<script src="./food/js/index.js"></script>');
        $html->addScript('<script src="./food/js/viewLayer1.js"></script>');

        $html->addToHead('<link rel="stylesheet" href="./food/style/style.css">');
        $html->addToHead('<link rel="stylesheet" 
                          href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
                          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
                          crossorigin="anonymous">');

        $html->addToHead($htmlComp->navigationBar('Start', null, null));
        $html->addToBody($htmlComp->table('alias', 'persons'));

        echo $html->getHTML();
    }

    public function main()
    {
        //innitialize classes
        $html = new HTML('LiKings');
        $htmlComp = new HTMLModules();  

        //html scripts
        $html->addScript('<script src="./food/js/index.js"></script>');
        $html->addScript('<script src="./food/js/viewLayer1.js"></script>');

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