<?php
    include("databaseConnection.php");
    include("DMLModules.php");
    $dbConn = new DBConnection();
    $dml = new DMLModules();

    $dml->addContent($dbConn->getConnection(), 
                     $_REQUEST['preference'], 
                     $_REQUEST['rating'], 
                     $_REQUEST['cross_person_categories_id'])

?>
