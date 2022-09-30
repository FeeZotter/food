<!Doctype html>
  
<html>
    

    <head>
        <title>Aktuelle Artikel</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
      
    <body>
        <header>
            <img src="/Bilder/Banner/Start-Banner.jpg" alt="Banner" title="Homepage-Webhilfe" />
        </header>
          
        <nav> 
            
            <input type="text" id="searchbar" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus/>
            <input type="submit" value="🔍"/>
        </nav>

        
        <main>
            <div id="zeit">
                <?php // Ausgabe der aktuellen Serverzeit ?>
            </div>
            <p>...</p>
            <?php
            // Laden der aktuellen Artikel aus einer Datenbank und anzeigen
            ?>
        </main>
          
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">food</th>
                <th scope="col">rating</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $servername = "localhost";
                    $username = "testUser";
                    $password = "123456";
                    $dbname = "test";

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
                        echo "<tr>";
                        echo "<td>".$row["ID_testFood"]."</td>";
                        echo "<td>".$row["ID_testFood"]."</td>";
                        echo "<td>".$row["ID_testFood"]."</td>";
                        echo "</tr>";
                    }
                    } else {
                    echo "0 results";
                    }
                    $conn->close();
                ?>


                <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                </tr>
                <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                </tr>
                <tr>
                <th scope="row">3</th>
                <td colspan="2">Larry the Bird</td>
                </tr>
            </tbody>
        </table>

        <footer>
            Copyright {jear} by {name} - No rights reserved!
        </footer>

         
    </body>
</html>