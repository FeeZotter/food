<?php
// Include router class
include('./Route.php');

// Add base route (startpage)
Route::add('/',function()
{
    include('./food/DirectLink.php');
    $dl = new DirectLink();
    echo $dl->main();
});

//only main table
Route::add('/get',function()
{
    include("./HTMLModules.php");
    $htmlComp = new HTMLModules();  

    echo $htmlComp->table('alias', 'persons');
});

//only preference table
Route::add('/get/([0-9]*)',function($var1)
{
    include("./HTMLModules.php");
    $htmlComp = new HTMLModules();  

    echo $htmlComp->preferenceTable($var1);
});

//only person table
Route::add('/get/([a-z,0-9]*)',function($alias)
{
    include("./HTMLModules.php");
    $htmlComp = new HTMLModules();  

    $name = $htmlComp->getFirstMatchValue('name', 'persons', "alias='$alias'");

    return $htmlComp->categoriesTable($name);
});

// Post route example
Route::add('/contact-form',function()
{
    echo '<form method="post"><input type="text" name="test" /><input type="submit" value="send" /></form>';
},'get');

// Post route example
Route::add('/contact-form',function()
{
    echo 'Hey! The form has been sent:<br/>';
    print_r($_POST);
},'post');

// Accept only numbers as parameter. Other characters will result in a 404 error
Route::add('/foo/([0-9]*)/bar',function($var1)
{
    echo $var1.' is a great number!';
});

Route::add('/phpmyadmin',function($var1)
{
    
});

//shortcut to preference ID
Route::add('/([0-9]*)',function($var1)
{
    include('./DirectLink.php');
    $preference = new DirectLink();
    echo $preference->Preference($var1);
});

//shortcut to person
Route::add('/([a-z,0-9]*)',function($var1)
{
    include('./DirectLink.php');
    $person = new DirectLink();
    echo $person->Person($var1);
});

Route::run('/');
?>