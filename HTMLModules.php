<?php
    class HTMLModules
    {
        function tableBody($dbconn, $table)
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
                        class='color" . $row[tableRating]  . "'>"
                        .   "<td><b>" . $row[tableContent] . "</b</td>"
                        .   "<td><b>" . $row[tableRating]  . "</b></td>"
                    ."</tr>";
                }
            } 
            else 
            {
                $returnTable = "0 results";
            }
            return $returnTable;
        }   

        function tableHead()
        {

        }

        function table()
        {
            # tablestart
            tableHead();
            tableBody();
            # tableend
        }

        function insertFood()
        {

        }

        function searchbar()
        {
           .
        }
    }
?>
