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

                $alias = mysqli_real_escape_string($dbconn, $_REQUEST['alias']);
                $sql = "SELECT name WHERE alias=Fee FROM persons";
                $result = mysqli_query($dbconn, $sql);
                $sql = "SELECT categories_id WHERE persons_id=$result 
                        FROM cross_person_categories";
                $result = mysqli_query($dbconn, $sql);
                
                while($row = mysqli_fetch_assoc($result))
                {
                    $returnTable .=
                    "<tr>"
                        .   "<td><b>" . $row["alias"]          . "</b</td>"
                        .   "<td><b>" . $row["categories_id"]  . "</b></td>"
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
        <p>test2.php</p>
        <?php echo asdftable($dbconn); ?>
    </body>
</html>