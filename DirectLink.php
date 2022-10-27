<?php
//include
include("HTML.php");
include("HTMLModules.php");
include("DBConnection.php");
class DirectLink 
{
    public function Person(string $person)
    {
        //innitialize classes
        $html = new HTML($person);
        $htmlComp = new HTMLModules();  
        include("serverconfig.php");
        $db = new DBConnection($servername, $username, $password, $dbname);

        //innitialize database connections
        $dbconn = $db->getConnection();

        //html scripts
        $html->addScript('<script src="./js/index.js"></script>');
        $html->addScript('<script src="./js/viewLayer1.js"></script>');

        $html->addToHead('<link rel="stylesheet" href="./style/style.css">');
        $html->addToHead('<link rel="stylesheet" 
                          href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
                          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
                          crossorigin="anonymous">');

        $html->addToBody($htmlComp->nextPage('ViewLayer3.php', 'cross_person_categories_id'));
        
        $name = $htmlComp->personTable($dbconn, 'name', 'persons', 'alias', $person);

        $html->addToBody($htmlComp->table2Where($dbconn, 
                                                'categories_id',
                                                'cross_person_categories_id', 
                                                'cross_person_categories', 
                                                "persons_id='$name'"));

        echo $html->getHTML();
    }
    public function Preference(int $cross_person_categories_id)
    {
        $htmlComp = new HTMLModules();  
        include("serverconfig.php");

        $db = new DBConnection($servername, 
                                $username, 
                                $password, 
                                $dbname);
        $dbconn = $db->getConnection();

        $html = new HTML($htmlComp->getFirstMatchValue($dbconn, 'categories_id', 'cross_person_categories', "cross_person_categories_id='$cross_person_categories_id'"));

        //html scripts
        $html->addScript('<script src="./js/index.js"></script>');
        $html->addScript('<script src="./js/viewLayer1.js"></script>');

        $html->addToHead('<link rel="stylesheet" href="./style/style.css">');
        $html->addToHead('<link rel="stylesheet" 
                        href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
                        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
                        crossorigin="anonymous">');

        $html->addToBody($htmlComp->table2Where($dbconn, 
                                                'preference',
                                                'rating', 
                                                "preferences", 
                                                "cross_person_categories_id='$cross_person_categories_id'"));

        echo $html->getHTML();
    }
}
?>