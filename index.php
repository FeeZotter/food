<?php
ini_set("allow_url_include", true);
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);
// Include router class
include_once('./Route.php');
include_once('./HTML.php');
include_once('./DBSrc/DMLModules.php');


// Add base route (startpage)
Route::add('/',function()
{
    echo HTML::main();
}, 'get');

Route::add('/impressum',function()
{
    include_once("./impressum.html");
}, 'get');

//////////////////////////////////////////////////
//////////////////TO REPLACE//////////////////////
//only main table (all persons)
Route::add('/get',function()
{
    echo HTML::returnTable('alias', 'persons');
}, 'get');

//get content table by preference ID
Route::add('/get/([0-9]*)',function($preferenceID)
{
    echo HTML::returnPreferenceTable($preferenceID);
}, 'get');

//get preference table by person name 
Route::add('/get/([a-z,0-9]*)',function($alias)
{
    return HTML::returnCategoriesTable(DMLModules::getName($alias));
}, 'get');

//////////////////////////////////////////////////
//////////////////not to replace//////////////////
//only main table data
Route::add('/g',function()
{
    echo json_encode(DMLModules::getTable('alias', 'persons'));
    
}, 'get');

//get preference table data
Route::add('/g/([0-9]*)',function($preferenceID)
{
    echo json_encode(DMLModules::getPreferenceTableData($preferenceID));
}, 'get');

//get person table data
Route::add('/g/([a-z,0-9]*)',function($alias)
{
    echo json_encode(DMLModules::getTableWhere("categories_id, cross_person_categories_id", "cross_person_categories", "persons_id='$alias'"));
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
    echo HTML::onlyUserCategoryTable($_REQUEST['inputName'], $_REQUEST['inputPassword']);    
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
    echo HTML::regristration();
}, 'get');

Route::add('/reg',function()
{
    HTML::addAccount($_REQUEST['inputName'], $_REQUEST['inputAlias'], $_REQUEST['inputPassword'], $_REQUEST['inputKey']);
}, 'post');

Route::add('/admin',function()
{
    echo HTML::adminPage();
}, 'get');

Route::add('/delcate',function()
{
    echo DMLModules::removeCategory($_REQUEST['inputName'], $_REQUEST['inputPassword'], $_REQUEST['inputCategory']);
}, 'post');

Route::add('/addcate',function()
{
    echo DMLModules::addCategory($_REQUEST['inputName'], $_REQUEST['inputPassword'], $_REQUEST['inputCategory']);
}, 'post');

Route::add('/addchangepref',function()
{
    //$user, $password, $category, $preference, $rating
    echo DMLModules::addChangePreference(   $_REQUEST['inputName'], 
                                            $_REQUEST['inputPassword'], 
                                            $_REQUEST['inputCategory'], 
                                            $_REQUEST['inputPreference'], 
                                            $_REQUEST['inputRating']);
}, 'post');

Route::add('/delpref',function()
{
    //$user, $password, $category, $preference, $rating
    echo DMLModules::deletePreference(  $_REQUEST['inputName'], 
                                        $_REQUEST['inputPassword'], 
                                        $_REQUEST['inputCategory'], 
                                        $_REQUEST['inputPreference']);
}, 'post');

Route::add('/hints',function()
{
    echo HTML::hints();
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





// redirect every failed thing to the start page
Route::add('/(*)',function()
{
    echo HTML::main();
}, 'get');

////////////////
//start router//
Route::run('/');
?>