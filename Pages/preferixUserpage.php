
<!DOCTYPE html><html>
<head>
    <title>Preferix</title>
    <link rel='stylesheet' href='/food/style/style.css'>
    <link rel='stylesheet' href='/food/style/bootstrap-5.2.2-dist/css/bootstrap.min.css'>
</head>
<body>
    <div id='content' style='width:100vw;margin:auto;'>
        <h2 class='navigation' id='navigation'>
            <!--private static function navigationBar($navigationPoint1, $navigationPoint2, $navigationPoint3)-->
            <a class='Start text-decoration-none' id='navigation1'>" . ucfirst($navigationPoint1 . "") . "</a>
            <a class='text-decoration-none'       id='navigation2'>" . ucfirst($navigationPoint2 . "") . "</a>                
            <a class='text-decoration-none'       id='navigation3'>" . ucfirst($navigationPoint3 . "") . "</a>
        </h2>
        <div id="table">
            self::theadOne($header)
            self::tbody($table)
        </div>
    </div>
    <?php (include_once("impressumText.php")) ?>
</body>
</html>
<script src='food/js/index.js'></script>







public static function main()
{
    echo self::getHTML("", "", self::navigationBar('Start', null, null) . self::table('alias', 'persons'), self::script("index"));
}



    private static function table($select, $from)
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