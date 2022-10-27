<?php
//include
include("HTML.php");
include("HTMLModules.php");
include("DBConnection.php");
include("serverconfig.php");

//innitialize classes
$html = new HTML('specific Person');
$htmlComp = new HTMLModules();  
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

$name = $htmlComp->getByRequest($dbconn, 
                                'name', 
                                'persons', 
                                'alias');

$html->addToBody($htmlComp->table2Where($db, 
                                        'categories_id',
                                        'cross_person_categories_id', 
                                        'cross_person_categories', 
                                        "persons_id='$name'"));

echo $html->getHTML();
?>