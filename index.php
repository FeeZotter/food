<?php
// Include router class
include('./food/Route.php');
include('./food/HTML.php');

// Add base route (startpage)
Route::add('/',function()
{
    $html = new HTML();
    echo $html->main();
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
    $htmlComp = new HTML();
    echo $htmlComp->login("", "");
}, 'get');

Route::add('/login',function()
{
    $htmlComp = new HTML();
    echo $htmlComp->userMainPage($_REQUEST['inputName'], $_REQUEST['inputPassword']);
}, 'post');

Route::add('/login/table',function()
{
    $htmlComp = new HTML();
    echo $htmlComp->onlyUserCategoyTable($_REQUEST['inputName'], $_REQUEST['inputPassword']);    
}, 'post' );

Route::add('/regrister',function()
{
    $htmlComp = new HTML();
    echo $htmlComp->regristration();
}, 'get');

Route::add('/regrister',function()
{
    HTML::addAccount($_REQUEST['inputName'], $_REQUEST['inputAlias'], $_REQUEST['inputPassword'], $_REQUEST['inputKey']);
}, 'post');

Route::add('/reg',function()
{
    $htmlComp = new HTML();
    echo $htmlComp->regristration();
}, 'get');

Route::add('/reg',function()
{
    HTML::addAccount($_REQUEST['inputName'], $_REQUEST['inputAlias'], $_REQUEST['inputPassword'], $_REQUEST['inputKey']);
}, 'post');

Route::add('/admin',function()
{
    $admin = new HTML();
    echo $admin->adminPage();
}, 'get');


//////////////////////////////////////
//////////////Shortcuts///////////////
//shortcut to preference ID by id
Route::add('/s/([0-9]*)',function($id)
{
    $preference = new HTML();
    echo $preference->PreferenceByID($id);
}, 'get');

//shortcut to person
Route::add('/s/([a-z,0-9]*)',function($name)
{
    $person = new HTML();
    echo $person->Person($name);
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