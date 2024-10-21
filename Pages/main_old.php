<!DOCTYPE html><html>
<head>
    <title>Preferix</title>
    <link rel='stylesheet' href='/style/style.css'>
</head>
<body>
    <h2 class='navigation' id='navigation'>
        <a class='Start text-decoration-none' id='navigation1'>Start</a>
        <a class='text-decoration-none'      id='navigation2'></a>                
        <a class='text-decoration-none'      id='navigation3'></a>
    </h2>
    <div id='content' style='width:100vw;margin:auto;'>
        <div id="userTable">
            <div class=''>
                <table class='table' id='oneTableHead'>
                    <thead id='tabletop'>
                        <tr>
                            <th scope='col'>
                                <a>Users</a>
                                <a>
                                    <input class="input marginLeft" type="text" id="sortValue" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByName()"/>
                                </a>
                            </th>
                        </tr>   
                    </thead>
                </table>
            </div>
            <div class='tableFixHead'>
                <table class='table tableFixHead table-hover' id='oneTable'>
                    <tbody id='tableContent'>
                        <?php 
                            foreach (DMLModules::getAliasTable() as $value)
                            {
                                echo 
                                "<tr>"
                                .   "<td class='$value[alias]'>{$value['alias']}</td>"
                                ."</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php echo (include_once("./Pages/modules/impressumFooter.php")) ?>
</body>
</html>