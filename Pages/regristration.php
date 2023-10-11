<!DOCTYPE html>
<html>
<head>
    <title>Preferix</title>
    <link rel='stylesheet' href='/food/style/style.css'>
    <link rel='stylesheet' href='/food/style/bootstrap-5.2.2-dist/css/bootstrap.min.css'>
</head>
<body>
    <div id='content' style='width:100vw;margin:auto;'>
        <form id='regristerForm' method='post'>
            <div class='form-row'>
                <div class='form-group col-md-5'>
                    <label for='inputName'>Name</label>
                    <input type='text' class='form-control' id='inputName' name='inputName' placeholder='Private name for login'>
                </div>
            </div>
            <div class='form-row'>
                <div class='form-group col-md-5'>
                    <label for='inputPassword'>Password</label>
                    <input type='password' class='form-control' id='inputPassword' name='inputPassword' placeholder='Password'>
                </div>
            </div>
            <div class='form-row'>
                <div class='form-group col-md-5'>
                    <label for='inputAlias'>Name</label>
                    <input type='text' class='form-control' id='inputAlias' name='inputAlias' placeholder='Public name'>
                </div>
            </div>
            <div class='form-row'>
                <div class='form-group col-md-5'>
                    <label for='inputKey'>Key</label>
                    <input type='text' class='form-control' id='inputKey' name='inputKey' maxlength='32' placeholder='unlocks unlimited preferences'>
                </div>
            </div>
            <button type='submit' class='btn btn-primary'>Submit Regristration</button>
            <p>NOTE: There is <b>no email communication</b> that can help you, so its easy that the <b>password is lost</b></p>
        </form>
    </div>
    <?php (include_once("impressumText.php")) ?>
</body>
</html>
<script src='food/js/regrister.js'></script>