<?php
    include("databaseConnection.php");
    include("dmlModules.php");
    $dbConn = new DBConnection();
    $dbConn->addContent($_REQUEST['food'],$_REQUEST['rating']);
    addContent($dbConn, "food_fee")

?>
