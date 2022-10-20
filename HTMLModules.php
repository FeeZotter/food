<?php
    class HTMLModules
    {
        function table($dbconn, $select, $from)
        {
            $dml = new DMLModules();
            $array = $dml->getTable($dbconn, $select, $from);
            $returnTable = "";
            foreach ($array as $value)
            {
                $returnTable .=
                "<tr>"
                .   "<td>{$value}</td>"
                ."</tr>";
            }

            return '<table class="table table-hover" id="table">
                        <thead id="tabletop">
                            <tr>
                                <th scope="col">' . $select . '</th>
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
