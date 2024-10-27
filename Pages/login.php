<?php
include_once("./Session.php");
if (Session::isLogin()) {
    //reroute
   
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Preferix</title>
    <link rel='stylesheet' href='/food/style/style.css'>
    <link rel='stylesheet' href='/food/style/bootstrap-5.2.2-dist/css/bootstrap.min.css'>
</head>
<body>
    <nav  aria-label="Path Navigation">
        <a href="/">Main</a>
        <?php 
        if(!Session::isLogin())
        {
            echo '
                <a href="/regrister">Regrister</a>';
        } 
        ?>
        <a href="/impressum">Impressum</a>
        <a href="/api">API</a>
    </nav>
    <main>
        <form action="/login" method="post">
            <fieldset>
                <legend>Login<?php if(Session::isLogin()) echo(" to another account"); ?></legend>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <input type="submit" value="Login">
            </fieldset>
        </form>
    </main>
    <?php include_once("./Pages/modules/impressumFooter.php") ?>
</body>
</html>
<script src='food/js/login.js'></script>