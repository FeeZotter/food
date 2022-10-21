<!DOCTYPE html>
<html>
    <head>
        <?php
            include("HTMLModules.php");
            include("DBConnection.php");
            include("serverconfig.php");
            include("DMLModules.php");
            $htmlComp = new HTMLModules();
            $db = new DBConnection($servername, 
                                   $username, 
                                   $password, 
                                   $dbname);
            $dbconn = $db->getConnection();

            function layer2Table($dbconn)
            {
                $htmlComp = new HTMLModules();
                $alias = mysqli_real_escape_string($dbconn, $_REQUEST['alias']);
                $dml = new DMLModules();
                $result = $dml->getTableWhere($dbconn, 
                                              'name', 
                                              "persons", 
                                              "alias='$alias'");

                $name = $result[0]['name'];
                $tableContent = $htmlComp->table2Where($dbconn, 
                                                      'categories_id',
                                                      'cross_person_categories_id', 
                                                      "cross_person_categories", 
                                                      "persons_id='$name'");
                return $tableContent;
            }
        ?>
        <title>title</title>
        <link rel="stylesheet" href="./style/style.css">
        <link rel="stylesheet" 
              href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
              crossorigin="anonymous">
    </head>
    <body>
        <?php echo $htmlComp->nextPage('ViewLayer3.php', 'cross_person_categories_id'); ?> <!-- category may be false -->
        <?php echo layer2Table($dbconn); ?>
    </body>
</html>