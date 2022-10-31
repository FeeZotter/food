<?php
    include('DMLModules.php');
    class HTMLModules
    {
        public function searchbarName()
        {
            return '<input class="input marginLeft" type="text" id="sortValue" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByName()"/>';
        }

        public function searchbarNameRating()
        {
            return '<input class="input marginLeft" type="text" id="sortValue" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByName()"/>
                    <input class="input" type="text" id="sortRating" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByRating()"/>';
        }

        public function searchbarRating()
        {
            return '<input class="input" type="text" id="sortRating" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByRating()"/>';
        }

        function table($select, $from)
        {
            $dml = new DMLModules();
            $array = $dml->getTable($select, $from);
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
                                <th scope='col'><a>" . ucfirst($select) . '</a><a>' . $this->searchbarName() . '</a>' . '</th>
                            </tr>
                        </thead>
                        <tbody id="tableContent">' .
                            $returnTable .
                        '</tbody>
                    </table>';
        }

        function tableWhere($select, $from, $where)
        {
            $dml = new DMLModules();
            $array = $dml->getTableWhere($select, $from, $where);
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
                                <th scope="col"><a>' . ucfirst($select) . '</a><a>'. $this->searchbarName() . '</a></th>
                            </tr>
                        </thead>
                        <tbody id="tableContent">' .
                            $returnTable .
                        '</tbody>
                    </table>';
        }

        function dataTableWhere($select, $from, $where)
        {
            $dml = new DMLModules();
            return $dml->getTableWhere($select, $from, $where); //Structure (nested array) = array(array['value1', 'value2'], array['value1', 'value2'], array['value1', 'value2'])
        }

        public function table2($select, $select2, $from)
        {
            $dml = new DMLModules();
            $array = $dml->getTable("$select, $select2", $from);
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
                                <th scope="col">' . ucfirst($select)  . '</a><a>'. $this->searchbarName() . '</a></th>
                                <th scope="col">' . ucfirst($select2) . '</a><a>'. $this->searchbarNameRating() . '</a></th>
                            </tr>
                        </thead>
                        <tbody id="tableContent">' .
                            $returnTable .
                        '</tbody>
                    </table>';
        }

        public function preferenceTable($categoryID)
        {
            $dml = new DMLModules();
            $array = $dml->getTableWhere("preference, rating", 'preferences', "cross_person_categories_id='$categoryID'");
            $returnTable = "";
            
            foreach ($array as $value)
            {
                $returnTable .=
                "<tr>"
                .   "<td class='color" . $value['rating'] . "'>" . ucfirst($value['preference']) . "</td>"
                .   "<td class='color" . $value['rating'] . "'>" . ucfirst($value['rating'])    . "</td>"
                ."</tr>";
            }

            return "<table class='table table-hover' id='table'>
                        <thead id='tabletop'>
                            <tr>
                                <th scope='col'>" . 'Preference'       . '</a><a>'. $this->searchbarName() . "</a></th>
                                <th scope='col'>" . 'Rating' . '</a><a>'. $this->searchbarRating() . "</a></th>
                            </tr>
                        </thead>
                        <tbody id='tableContent'>" .
                            $returnTable .
                        "</tbody>
                    </table>";
        }

        public function categoriesTable($personID)
        {
            $dml = new DMLModules();
            $array = $dml->getTableWhere("categories_id, cross_person_categories_id", "cross_person_categories", "persons_id='$personID'");
            $returnTable = "";
            
            foreach ($array as $value)
            {
                $returnTable .=
                "<tr>"
                .   "<td class='" . $value["cross_person_categories_id"] . "' id='" . $value['categories_id'] . "'>" . ucfirst($value['categories_id']) . "</td>"
                ."</tr>";
            }

            return "<table class='table table-hover' id='table'>
            <thead id='tabletop'>
            <tr>
                                <th scope='col'>" . 'Preference'  . '</a><a>'. $this->searchbarName() . "</a></th>
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

        public function navigationBar($navigationPoint1, $navigationPoint2, $navigationPoint3)
        {
            return "<h1 class='navigation' id='navigation'>
                        <a class='Start' id='navigation1'>" . ucfirst($navigationPoint1) . "</a>
                        <a class=''      id='navigation2'>" . ucfirst($navigationPoint2) . "</a>                
                        <a class=''      id='navigation3'>" . ucfirst($navigationPoint3) . "</a>
                    </h1>";
        }
        
        function getByRequest($select, $from, $where)
        {
            $dml = new DMLModules();
            $result = $dml->getTableWhere($select, 
            $from, 
                                          "$where='$_REQUEST[$where]'");

            return $result[0][$select];
        }

        public function personTable($select, $from, $where, $person)
        {
            $dml = new DMLModules();
            $result = $dml->getTableWhere($select, 
                                          $from, 
                                          "$where='$person'");

            return $result[0][$select];
        }

        public function getFirstMatchValue($select, $from, $where)
        {
            $dml = new DMLModules();
            return implode($dml->getFirstMatchValue($select, $from, $where));
        }
    }
?>
