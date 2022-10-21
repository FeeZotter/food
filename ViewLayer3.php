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
                $htmlComp = new HTMLModules();
                $cross_person_categories_id = mysqli_real_escape_string($dbconn, $_REQUEST['cross_person_categories_id']);
                $tableContent = $htmlComp->table2Where($dbconn, 
                                                       'preference',
                                                       'rating', 
                                                       "preferences", 
                                                       "cross_person_categories_id='$cross_person_categories_id'");
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
        <?php echo layer2Table($dbconn); ?>
    </body>
</html>