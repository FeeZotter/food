<?php
    class HTMLModules
    {
        function table($dbconn, $table)
        {
            $returnTable = "";
            $contentTableResult = $dbconn->query("SELECT * FROM " . $table);
            if ($contentTableResult->num_rows > 0) 
            {
                // output data of each row
                while($row = $contentTableResult->fetch_assoc()) 
                {
                    $returnTable = $returnTable . 
                    "<tr 
                        class='color" . $row["rating"]  . "'>"
                        .   "<td><b>" . $row["preference"] . "</b</td>"
                        .   "<td><b>" . $row["rating"]  . "</b></td>"
                    ."</tr>";
                }
            } 
            else 
            {
                $returnTable = "0 results";
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

        function insertFood()
        {

        }

        function searchbar()
        {
           
        }
    }
?>
