<?php
// Include router class
include('./food/Route.php');

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
    include("./food/HTMLModules.php");
    $htmlComp = new HTMLModules();  
    echo $htmlComp->table('alias', 'persons');
});

//get preference table
Route::add('/get/([0-9]*)',function($preferenceID)
{
    include("./food/HTMLModules.php");
    $htmlComp = new HTMLModules();  
    echo $htmlComp->preferenceTable($preferenceID);
}, 'get');

//get person table
Route::add('/get/([a-z,0-9]*)',function($alias)
{
    include("./food/HTMLModules.php");
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

Route::add('/newKey/([0-9]*)',function($max_users)
{
    include('./food/HTMLModules.php');
    $htmlMod = new HTMLModules();
    echo $htmlMod->newKey($max_users);
});

//shortcut to preference ID by id
Route::add('/([0-9]*)',function($var1)
{
    include('./food/DirectLink.php');
    $preference = new DirectLink();
    echo $preference->PreferenceByID($var1);
});

//shortcut to person
Route::add('/([a-z,0-9]*)',function($var1)
{
    include('./food/DirectLink.php');
    $person = new DirectLink();
    echo $person->Person($var1);
});

//shortcut to preference ID by alias and category
Route::add('/([a-z,0-9]*)/([a-z,0-9]*)',function($alias, $category)
{
    include('./food/DirectLink.php');
    $preference = new DirectLink();
    echo $preference->Preference($alias, $category);
});

Route::run('/');
?>