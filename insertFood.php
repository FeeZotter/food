<?php
    include("databaseConnection.php");
    $dbConn = new DBConnection();
    $dbConn->addContent($_REQUEST['food'],$_REQUEST['rating']);

?>
