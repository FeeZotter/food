<?php
include_once('DMLModules.php');
function returnTable($select, $from)
{
    $array = DMLModules::getTable($select, $from);
    $returnTable = "";
    foreach ($array as $value)
    {
        $returnTable .=
        "<tr>"
        .   "<td class='$value'>{$value}</td>"
        ."</tr>";
    }
    return self::tableOne($select, $returnTable);
}

?>