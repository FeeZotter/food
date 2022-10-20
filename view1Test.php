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
    </head>
    <body>
        <form action="view2Test.php" method="post">
            <label class="marginLeft" for="alias">Alias:</label>
            <input type="text" name="alias" id="alias">
            <input type="submit" value="Submit">
        </form>
        <?php echo $htmlComp->table($dbconn, 'alias', 'persons'); ?>
    </body>
</html>