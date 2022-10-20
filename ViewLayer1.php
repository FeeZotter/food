<!DOCTYPE html>
<html>
    <head>
        <?php
            include("HTMLModules.php");
            include("DBConnection.php");
            include("preferencesDB.php");
            include("serverconfig.php");
            include("DMLModules.php");
            $htmlComp = new HTMLModules();  
            $db = new DBConnection($servername, $username, $password, $dbname);
            $dbconn = $db->getConnection();
        ?>
        <title>title</title>
        <link rel="stylesheet" href="./style/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <form action="ViewLayer2.php" method="post">
            <label class="marginLeft" for="alias">Alias:</label>
            <input type="text" name="alias" id="alias">
            <input type="submit" value="Submit">
        </form>
        <?php echo $htmlComp->table($dbconn, 'alias', 'persons'); ?>
    </body>
</html>
<script src="./js/index.js"></script>  
<script src="./js/ViewLayer1.js"></script> 
