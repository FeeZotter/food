<?php
    include("databaseConnection.php");
    include("DMLModules.php");
    $dbConn = new DBConnection();
    $dml = new DMLModules();
    $dml->addContent($dbConn->getConnection(), $table)
?>
