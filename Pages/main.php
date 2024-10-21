<?php 
include_once("./Session.php");

?>

<!DOCTYPE html><html>
<head>
    <title>Preferix</title>
    <link rel='stylesheet' href='/style/style.css'>
</head>
<body>
    <nav  aria-label="Path Navigation">
        <?php 
        if(!Session::isLogin())
        {
            echo '
                <a href="/login">Login</a>
                <a href="/regrister">Regrister</a>';
        } 
        ?>
        <a href="/impressum">Impressum</a>
        <a href="/api">API</a>
    </nav>
    <h2 class='navigation' id='navigation'>
        <a class='Start text-decoration-none' id='navigation1'>Start</a>
        <a class='text-decoration-none'      id='navigation2'></a>                
        <a class='text-decoration-none'      id='navigation3'></a>
    </h2>
    <table>
        <thead>
            <tr>
                <th>
                    <a>Users</a>
                    <a>
                        <input class="input marginLeft" type="text" id="sortValue" name="searchbar" tabindex="1" rows="1" minlength="2" autofocus onkeyup="searchByName()"/>
                    </a>
                </th>
            </tr>   
        </thead>
        <tbody>
            <?php 
                foreach (DMLModules::getAliasTable() as $value)
                {
                    echo 
                    "<tr>"
                    .   "<td>{$value['alias']}</td>"
                    ."</tr>";
                }
            ?>
        </tbody>
    </table>
<?php include_once("./Pages/modules/impressumFooter.php") ?>
</body>
</html>