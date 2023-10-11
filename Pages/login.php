<?php
include_once("./Session.php");
Session::innit();
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
    <div id='content' style='width:100vw;margin:auto;'>
        <form id='loginForm' method='post'>
            <div class='form-row'>
                <div class='form-group col-md-5'>
                    <label for='inputName'>Name</label>
                    <input type='text' class='form-control' value='' id='inputName' name='inputName' placeholder='Private name for login'>
                </div>
            </div>
            <div class='form-row'>
                <div class='form-group col-md-5'>
                    <label for='inputPassword'>Password</label>
                    <input type='password' class='form-control' value='' id='inputPassword' name='inputPassword' placeholder='Password'>
                </div>
            </div>
            <button type='submit' class='btn btn-primary'>Login</button>
        </form>
    </div>
    <?php (include_once("impressumText.php")) ?>
</body>
</html>
<script src='food/js/login.js'></script>