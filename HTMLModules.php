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

        function tableWhere($dbconn, $select, $from, $where)
        {
            $dml = new DMLModules();
            $array = $dml->getTableWhere($dbconn, $select, $from, $where);
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

        public function table2($dbconn, $select, $select2, $from)
        {
            $dml = new DMLModules();
            $array = $dml->getTable($dbconn, "$select, $select2", $from);
            $returnTable = "";
            foreach ($array as $value)
            {
                $returnTable .=
                "<tr>"
                .   "<td>{$value[0]}</td>"
                .   "<td>{$value[1]}</td>"
                ."</tr>";
            }

            return '<table class="table table-hover" id="table">
                        <thead id="tabletop">
                            <tr>
                                <th scope="col">' . $select  . '</th>
                                <th scope="col">' . $select2 . '</th>
                            </tr>
                        </thead>
                        <tbody id="tableContent">' .
                            $returnTable .
                        '</tbody>
                    </table>';
        }

        public function table2Where($dbconn, $select, $select2, $from, $where)
        {
            $dml = new DMLModules();
            $array = $dml->getTableWhere($dbconn, "$select, $select2", $from, $where);
            $returnTable = "";
            
            foreach ($array as $value)
            {
                $returnTable .=
                "<tr>"
                .   "<td>{$value[$select]}</td>"
                .   "<td>{$value[$select2]}</td>"
                ."</tr>";
            }

            return '<table class="table table-hover" id="table">
                        <thead id="tabletop">
                            <tr>
                                <th scope="col">' . $select  . '</th>
                                <th scope="col">' . $select2 . '</th>
                            </tr>
                        </thead>
                        <tbody id="tableContent">' .
                            $returnTable .
                        '</tbody>
                    </table>';
        }
        
        public function toViewLayer2($page, $identifier)
        {
            return "<form action='$page' method='post'>
                        <label class='marginLeft' for='$identifier'>$identifier:</label>
                        <input type='text' name='$identifier' id='$identifier'>
                        <input type='submit' value='Submit'>
                    </form>";
        }

        function insert()
        {

        }

        function searchbar()
        {
           
        }
    }
?>
