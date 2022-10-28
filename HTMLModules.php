<?php
    include('DMLModules.php');
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
                .   "<td id='$value[$select]' >{$value[$select]}</td>"
                .   "<td id='$value[$select2]'>{$value[$select2]}</td>"
                ."</tr>";
            }

            return "<table class='table table-hover' id='table'>
                        <thead id='tabletop'>
                            <tr>
                                <th scope='col' id='$select'>"  . $select   . "</th>
                                <th scope='col' id='$select2'>" . $select2  . "</th>
                            </tr>
                        </thead>
                        <tbody id='tableContent'>" .
                            $returnTable .
                        "</tbody>
                    </table>";
        }
        
        public function nextPage($page, $identifier)
        {
            return "<form action='$page' method='post'>
                        <label class='marginLeft' for='$identifier'>$identifier:</label>
                        <input type='text' name='$identifier' id='$identifier'>
                        <input type='submit' value='Submit'>
                    </form>";
        }

        function getByRequest($db, $select, $from, $where)
        {
            mysqli_real_escape_string($db, $_REQUEST[$where]);
            $dml = new DMLModules();
            $result = $dml->getTableWhere($db, 
                                          $select, 
                                          $from, 
                                          "$where='$_REQUEST[$where]'");

            return $result[0][$select];
        }

        public function personTable($db, $select, $from, $where, $person)
        {
            mysqli_real_escape_string($db, $person);
            $dml = new DMLModules();
            $result = $dml->getTableWhere($db, 
                                          $select, 
                                          $from, 
                                          "$where='$person'");

            return $result[0][$select];
        }

        public function getFirstMatchValue($db, $select, $from, $where)
        {
            $dml = new DMLModules();
            return implode($dml->getFirstMatchValue($db, $select, $from, $where));
        }
    }
?>
