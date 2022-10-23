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
        
        <form action='/food/insertFood.php' method='post'>
            <label class='marginLeft' for='preference'>preference:</label>
            <input type='text' name='preference' id='preference'>
            <label class='marginLeft' for='rating'>rating:</label>
            <input type='text' name='rating' id='rating'>
            <label class='marginLeft' for='cross_person_categories_id'>cross_person_categories_id:</label>
            <input type='text' name='cross_person_categories_id' id='cross_person_categories_id'>
            <input type='submit' value='Submit'>
        </form>
    </body>
</html>
<script src="./js/index.js"></script>  
<script src="./js/viewLayer1.js"></script> 
