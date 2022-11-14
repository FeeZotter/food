<?php
// Include router class
include('./food/Route.php');

// Add base route (startpage)
Route::add('/',function()
{
    include('./food/Pages.php');
    $dl = new Pages();
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
    $name = $htmlComp->getName($alias);
    return $htmlComp->categoriesTable($name);
});



/////////////////////////////////////
////////Post route example///////////
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



//////////////////////////////////////////////////
//////////////////Generate Keys///////////////////
Route::add('/newKey/([0-9]*)',function($max_users)
{
    include('./food/HTMLModules.php');
    $htmlMod = new HTMLModules();
    //echo $htmlMod->newKey($max_users);
    echo "depreciated";
});

Route::add('/newKey/([0-9]*)',function($max_users)
{
    include('./food/HTMLModules.php');
    $htmlMod = new HTMLModules();
    // echo $htmlMod->newKey($max_users);
    echo "depreciated";
});

Route::add('/newKey)',function()
{
    include('./food/HTMLModules.php');
    $htmlMod = new HTMLModules();
    echo $htmlMod->newKey($_REQUEST['inputKeyUses'], $_REQUEST['inputName'], $_REQUEST['inputPassword']);
}, 'post');


//////////////////////////////////////
//////////////Shortcuts///////////////
//shortcut to preference ID by id
Route::add('/([0-9]*)',function($var1)
{
    include('./food/Pages.php');
    $preference = new Pages();
    echo $preference->PreferenceByID($var1);
});

//shortcut to person
Route::add('/([a-z,0-9]*)',function($var1)
{
    include('./food/Pages.php');
    $person = new Pages();
    echo $person->Person($var1);
});

//shortcut to preference ID by alias and category
Route::add('/([a-z,0-9]*)/([a-z,0-9]*)',function($alias, $category)
{
    include('./food/Pages.php');
    $preference = new Pages();
    echo $preference->Preference($alias, $category);
});

//////////////////////////////////////
///////////user functions/////////////

Route::add('./login',function()
{

}, 'get');

Route::add('./addAcc',function()
{
    print_r($_POST);
    include('./food/HTMLModules.php');
    $htmlComp = new HTMLModules();
    $htmlComp->addAccount($_REQUEST['account'], $_REQUEST['alias'], $_REQUEST['password'], $_REQUEST['key']);
}, 'post');




////////////////
//start router//
Route::run('/');
?>