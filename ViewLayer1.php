<!DOCTYPE html>
<html>
    <head>
        <?php
            include("HTMLModules.php");
            include("DBConnection.php");
            include("serverconfig.php");
            include("DMLModules.php");
            $htmlComp = new HTMLModules();  
            $db = new DBConnection($servername, $username, $password, $dbname);
            $dbconn = $db->getConnection();
        ?>
        <title>title</title>
        <link rel="stylesheet" href="./style/style.css">
        <link rel="stylesheet" 
              href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
              crossorigin="anonymous">
    </head>
    <body>
        <?php echo $htmlComp->nextPage('ViewLayer2.php', 'alias'); ?>
        <?php echo $htmlComp->table($dbconn, 'alias', 'persons'); ?>
    </body>
</html>
<script src="./js/index.js"></script>  
<script src="./js/ViewLayer1.js"></script> 
