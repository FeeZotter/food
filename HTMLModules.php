<?php
    class HTMLModules
    {
        function contentTable($servername, $username, $password, $dbname)
        {
            $dbconn = new DBConnection($servername, $username, $password, $dbname);
            $contentTableResult = $dbconn->query("SELECT * FROM " . $tableName);
            if ($contentTableResult->num_rows > 0) 
            {
                // output data of each row
                while($row = $contentTableResult->fetch_assoc()) 
                {
                    $contentTable = $contentTable. 
                    "<tr 
                        class='color" . $row[$this->tableRating]  . "'>"
                        . "<td><b>"   . $row[$this->tableContent] . "</b</td>"
                        . "<td><b>"   . $row[$this->tableRating]  . "</b></td>"
                    ."</tr>";
                }
            } 
            else 
            {
                $contentTable = "0 results";
            }
            return $contentTable;
        }   
    }
?>
