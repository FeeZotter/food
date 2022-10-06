<!Doctype html>
  
<html>
    <head>
        <title>Food</title>
        <link rel="stylesheet" href="index.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="./index.js"></script>  
    </head>
      
    <body>        
        <?php
            include("foodTable.php");
        ?>

        <nav> 
            <input type="text" id="searchbar" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="search()"/>
        </nav>
          
        <table class="table table-hover" id="foodTable">
            <thead id="tabletop">
                <tr>
                    <th scope="col">food</th>
                    <th scope="col">rating</th>
                </tr>
            </thead>
            <tbody id="tableContent">
                <?=$tableContent?>
            </tbody>
        </table>

        <footer>
            Copyright {jear} by {name} - No rights reserved!
        </footer>
    </body>
</html>