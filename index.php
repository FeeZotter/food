<?php
// Include router class
include('./food/Route.php');
include('./food/HTML.php');

// Add base route (startpage)
Route::add('/',function()
{
    $dl = new HTML();
    echo $dl->main();
}, 'get');

//only main table
Route::add('/get',function()
{
    $htmlComp = new HTML();  
    echo $htmlComp->returnTable('alias', 'persons');
}, 'get');

//get preference table
Route::add('/get/([0-9]*)',function($preferenceID)
{
    $htmlComp = new HTML();  
    echo $htmlComp->returnPreferenceTable($preferenceID);
}, 'get');

//get person table
Route::add('/get/([a-z,0-9]*)',function($alias)
{
    $htmlComp = new HTML();  
    $name = $htmlComp->getName($alias);
    return $htmlComp->returnCategoriesTable($name);
}, 'get');



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
Route::add('/newKey',function()
{
    echo HTML::newKey($_REQUEST['inputKeyUses'], $_REQUEST['inputName'], $_REQUEST['inputPassword']);
},'post');


//////////////////////////////////////
///////////user functions/////////////
Route::add('/login',function()
{
    echo 'not implemented';
}, 'get');

Route::add('/register',function()
{
    $htmlComp = new HTML();
    echo $htmlComp->regristration();
}, 'get');

Route::add('/regrister',function()
{
    print_r($_POST);
    HTML::addAccount($_REQUEST['account'], $_REQUEST['alias'], $_REQUEST['password'], $_REQUEST['key']);
}, 'post');

Route::add('/admin',function()
{
    $admin = new HTML();
    echo $admin->adminPage();
}, 'get');


//////////////////////////////////////
//////////////Shortcuts///////////////
//shortcut to preference ID by id
Route::add('/s/([0-9]*)',function($var1)
{
    $preference = new HTML();
    echo $preference->PreferenceByID($var1);
}, 'get');

//shortcut to person
Route::add('/s/([a-z,0-9]*)',function($var1)
{
    $person = new HTML();
    echo $person->Person($var1);
}, 'get');

//shortcut to preference ID by alias and category
Route::add('/s/([a-z,0-9]*)/([a-z,0-9]*)',function($alias, $category)
{
    $preference = new HTML();
    echo $preference->Preference($alias, $category);
}, 'get');

////////////////
//start router//
Route::run('/');
?>