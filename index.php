<!Doctype html>
  
<html>
    

    <head>
        <title>Food</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="./index.js"></script>
    </head>
      
    <body>       
        
        <?php
            $servername = "localhost";
            $username = "testUser";
            $password = "123456";
            $dbname = "test";
            $tableContent = "";
            $tableContentArray = array();

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT ID_testFood, food, rating FROM testfood";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $tableContent = $tableContent. 
                "<tr>"
                    ."<td>".$row["ID_testFood"]."</td>"
                    ."<td>".$row["food"]."</td>"
                    ."<td>".$row["rating"]."</td>"
                ."</tr>";
            }
            } else {
                $tableContent = "0 results";
            }
            $conn->close();
        ?>


        <nav> 
            <input type="text" id="searchbar" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus/>
            <input type="submit" value="🔍"/>
        </nav>
          
        <table class="table table-hover">
            <thead id="tabletop">
                <tr>
                <th scope="col">#</th>
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