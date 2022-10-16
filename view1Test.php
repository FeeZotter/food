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

                $sql = "SELECT alias
                        FROM persons";
                $result = mysqli_query($dbconn ,$sql);
            
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $returnTable .=
                        "<tr>"
                            .   "<td>" . $row["alias"] . "</td>"
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
            function FunctionName()
            {
                $return = "asdf";
                return $return;
            }
        ?>
        <title>title</title>
    </head>
    <body>
        <form action="view2Test.php" method="post">
            <label class="marginLeft" for="alias">Alias:</label>
            <input type="text" name="alias" id="alias">
            <input type="submit" value="Submit">
        </form>
        <p>test2.php</p>
        <?php echo asdftable($dbconn); ?>
    </body>
</html>