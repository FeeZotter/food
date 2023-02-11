<?php
// Include router class
include('./food/Route.php');
include('./food/HTML.php');

// Add base route (startpage)
Route::add('/',function()
{
    echo HTML::main();
}, 'get');

//only main table
Route::add('/get',function()
{
    echo HTML::returnTable('alias', 'persons');
}, 'get');

//get preference table
Route::add('/get/([0-9]*)',function($preferenceID)
{
    echo HTML::returnPreferenceTable($preferenceID);
}, 'get');

//get person table
Route::add('/get/([a-z,0-9]*)',function($alias)
{
    return HTML::returnCategoriesTable(HTML::getName($alias));
}, 'get');

//only main table data
Route::add('/g',function()
{
    echo HTML::getFrontPageData();
}, 'get');

//get preference table data
Route::add('/g/([0-9]*)',function($preferenceID)
{
    echo HTML::getPreferenceTableData($preferenceID);
}, 'get');

//get person table data
Route::add('/g/([a-z,0-9]*)',function($alias)
{
    echo HTML::returnCategoriesTable(HTML::getName($alias));
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
    echo HTML::login("", "");
}, 'get');

Route::add('/login',function()
{
    echo HTML::userMainPage($_REQUEST['inputName'], $_REQUEST['inputPassword']);
}, 'post');

Route::add('/login/table',function()
{
    echo HTML::onlyUserCategoyTable($_REQUEST['inputName'], $_REQUEST['inputPassword']);    
}, 'post' );

Route::add('/regrister',function()
{
    echo HTML::regristration();
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
    echo HTML::adminPage();
}, 'get');


//////////////////////////////////////
//////////////Shortcuts///////////////
//shortcut to preference ID by id
Route::add('/s/([0-9]*)',function($id)
{
    echo HTML::PreferenceByID($id);
}, 'get');

//shortcut to person
Route::add('/s/([a-z,0-9]*)',function($name)
{
    echo HTML::Person($name);
}, 'get');

//shortcut to preference ID by alias and category
Route::add('/s/([a-z,0-9]*)/([a-z,0-9]*)',function($alias, $category)
{
    echo HTML::Preference($alias, $category);
}, 'get');

////////////////
//start router//
Route::run('/');
?>