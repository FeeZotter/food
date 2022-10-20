<!DOCTYPE html>
<html>
    <head>
        <?php
            include("HTMLModules.php");
            include("DBConnection.php");
            include("preferencesDB.php");
            include("serverconfig.php");
            $htmlComp = new HTMLModules();
            $db = new DBConnection($servername, $username, $password, $dbname);
            $dbconn = $db->getConnection();

            function asdftable($dbconn)
            {
                $returnTable = "";

                $sql = "SELECT preferences.preference, preferences.rating
                        FROM preferences
                        INNER JOIN cross_person_categories 
                        ON preferences.cross_person_categories_id=cross_person_categories.cross_person_categories_id";
                $result = mysqli_query($dbconn ,$sql);
            
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $returnTable .=
                        "<tr 
                            class='color" . $row["rating"]  . "'>"
                            .   "<td><b>" . $row["preference"] . "</b</td>"
                            .   "<td><b>" . $row["rating"]  . "</b></td>"
                        ."</tr>";
                    }
                
                return '<table class="table table-hover" id="foodTable">
                            <thead id="tabletop">
                                <tr>
                                    <th scope="col">food</th> <th scope="col">rating</th>
                                </tr>
                            </thead>
                            <tbody id="tableContent">' .
                                $returnTable .
                            '</tbody>
                        </table>';
            }
        ?>
        <title>title</title>
    </head>
    <body>
        <p>test2.php</p>
        <?php echo asdftable($dbconn); ?>
    </body>
</html>