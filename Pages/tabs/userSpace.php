<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/Session.php');
Session::innit();
if(Session::isLogin())
{
  echo "Logged in";
}
else
{
    echo '
        <h1>NOT LOGGED IN</h1>
        <button onclick="document.getElementById(\'loginTabBtn\').click();">Login or Regrister</button>
    ';
}
?>