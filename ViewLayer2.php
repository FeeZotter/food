<!DOCTYPE html>
<html>
    <head>
        <?php
            include("HTMLModules.php");
            include("DMLModules.php");
            include("DBConnection.php");
            include("preferencesDB.php");
            include("serverconfig.php");
            $htmlComp = new HTMLModules();
            $db = new DBConnection($servername, $username, $password, $dbname);
            $dbconn = $db->getConnection();

    
            function layer2Table($dbconn)
            {
                $dml = new DMLModules();
//$sql = "SELECT name FROM persons WHERE alias='$alias'";
                $returnTable = "";

                $alias = mysqli_real_escape_string($dbconn, $_REQUEST['alias']);
                $result = $dml->getTableWhere($dbconn, 'name', "persons", "alias='$alias'");
                $sql = "SELECT categories_id FROM cross_person_categories WHERE persons_id='" . $result['name'] . "'";

                $result = mysqli_query($dbconn, $sql);
                
                while($row = mysqli_fetch_assoc($result))
                {
                    $returnTable .=
                    "<tr>"
                        .   "<td><b>" . $row['categories_id'] . "</b</td>"
                    ."</tr>";
                }
                
                return '<table class="table table-hover" id="foodTable">
                            <thead id="tabletop">
                                <tr>
                                    <th scope="col">' . $alias . '</th>
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
        <?php echo layer2Table($dbconn); ?>
    </body>
</html>