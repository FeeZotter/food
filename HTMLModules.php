<?php
    include('DMLModules.php');
    class HTMLModules
    {
        public function searchbarName()
        {
            return '<input class="wideInput marginLeft" type="text" id="sortValue" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByName()"/>';
        }

        public function searchbarNameRating()
        {
            return '<input class="wideInput marginLeft" type="text" id="sortValue" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByName()"/>
                    <input class="tightInput" type="text" id="sortRating" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByRating()"/>';
        }

        public function searchbarRating()
        {
            return '<input class="tightInput" type="text" id="sortRating" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByRating()"/>';
        }

        function table($dbconn, $select, $from)
        {
            $dml = new DMLModules();
            $array = $dml->getTable($dbconn, $select, $from);
            $returnTable = "";
            foreach ($array as $value)
            {
                $returnTable .=
                "<tr>"
                .   "<td class='$value'>{$value}</td>"
                ."</tr>";
            }

            return "<table class='table table-hover' id='table'>
                        <thead id='tabletop'>
                            <tr>
                                <th scope='col'>" . $select . '<a>' . $this->searchbarName() . '</a>' . '</th>
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
                                <th scope="col">' . $this->searchbarName() . '</th>
                            </tr>
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
                                <th scope="col">' . $this->searchbarName()  . '</th>
                                <th scope="col">' . $this->searchbarRating() . '</th>
                            </tr>
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
                .   "<td class='$value[$select2]'>{$value[$select]}</td>"
                .   "<td class='$value[$select2]'>{$value[$select2]}</td>"
                ."</tr>";
            }

            return "<table class='table table-hover' id='table'>
                        <thead id='tabletop'>
                            <tr>
                                <th scope='col'>" . $this->searchbarName()  . "</th>
                                <th scope='col'>" . $this->searchbarRating() . "</th>
                            </tr>
                            <tr>
                                <th scope='col'>" . $select  . "</th>
                                <th scope='col'>" . $select2 . "</th>
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



        public function navigationBar($navigationPoint)
        {
            return "<h1 class='navigation' id='navigation'>
                        <a class='Start' id='navigation1'>$navigationPoint</a>
                        <a class=''      id='navigation2'></a>                
                        <a class=''      id='navigation3'></a>
                    </h1>";
        }
    }
?>
