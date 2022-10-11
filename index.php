<!Doctype html>
  
<html>
    <head>
        <title>Foood</title>
        <link rel="stylesheet" href="./style/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="./js/index.js"></script>  
    </head>
      
    <body>        
        <?php
            include("databaseConnection.php");
            $htmlComp = new HTMLComponents;
        ?>

        <form action="insertFood.php" method="post">
            <label class="marginLeft" for="food">Food:</label>
            <input type="text" name="food" id="food">
            <label for="lastName">Rating:</label>
            <input type="number" inputmode="numeric" name="rating" id="rating" value="0" min="0" max="10">
            <input type="submit" value="Submit">
        </form>
        

        <nav> 
            <input class="wideInput marginLeft" type="text" id="sortValue" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByName()"/>
            <input class="tightInput" type="text" id="sortRating" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByRating()"/>
        </nav>
          
        <table class="table table-hover" id="foodTable">
            <thead id="tabletop">
                <tr>
                    <th scope="col">food</th>
                    <th scope="col">rating</th>
                </tr>
            </thead>
            <tbody id="tableContent">
                htmlComp->contentTable();
            </tbody>
        </table>

        <footer>
            No Copyright in jear of boom by nobody - No rights reserved!
        </footer>
    </body>
</html>