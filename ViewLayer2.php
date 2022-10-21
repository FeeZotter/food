<!DOCTYPE html>
<html>
    <head>
        <?php
            include("HTMLModules.php");
            include("DBConnection.php");
            include("preferencesDB.php");
            include("serverconfig.php");
            include("DMLModules.php");
            $db = new DBConnection($servername, 
                                   $username, 
                                   $password, 
                                   $dbname);
            $dbconn = $db->getConnection();
            function layer2Table($dbconn)
            {
                $dml = new DMLModules();
                $htmlComp = new HTMLModules();
                $alias = mysqli_real_escape_string($dbconn, $_REQUEST['alias']);
                $result = $dml->getTableWhere($dbconn, 
                                              'name', 
                                              "persons", 
                                              "alias='$alias'");
                $tableContent = $htmlComp->tableWhere($dbconn, 
                                                      'categories_id', 
                                                      "cross_person_categories", 
                                                      "persons_id='$result[0]'");
                return $tableContent;
            }
        ?>
        <title>title</title>
    </head>
    <body>
        <?php echo layer2Table($dbconn); ?>
    </body>
</html>