<?php
ini_set("allow_url_include", true);
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);
// Include router class
include_once('./Route.php');


// Add base route (startpage)
Route::add('/',function()
{
    $test = $_SERVER["REQUEST_URI"];
    echo($test);
    $test = explode("/", $test);
    array_shift($test);
    array_shift($test);
    print_r($test);
    include_once('./Pages/HTML.php');
    echo HTML::main();
}, 'get');

Route::add('/food/impressum',function()
{
    include_once("./Pages/impressum.php");
}, 'get');

//////////////////////////////////////////////////
//////////////////TO REPLACE//////////////////////
//only main table (all persons)
Route::add('/get',function()
{
    include_once('./DBSrc/DMLModules.php');
    echo DMLModules::getAliasTable();
}, 'get');

//get content table by preference ID
Route::add('/get/([0-9]*)',function($preferenceID)
{
    include_once('./Pages/HTML.php');
    echo HTML::returnPreferenceTable($preferenceID);
}, 'get');

//get preference table by person name 
Route::add('/get/([a-z,0-9]*)',function($alias)
{
    include_once('./DBSrc/DMLModules.php');
    include_once('./Pages/HTML.php');
    return HTML::returnCategoriesTable(DMLModules::getName($alias));
}, 'get');

//////////////////////////////////////////////////
//////////////////not to replace//////////////////
//only main table data
Route::add('/g',function()
{
    //SELECT alias FROM persons -> prepare for jsonEncoding
    include_once('./DBSrc/DMLModules.php');
    echo json_encode(DMLModules::getAliasTable());
}, 'get');

//get preference table data
Route::add('/g/([0-9]*)',function($preferenceID)
{
    include_once('./DBSrc/DMLModules.php');
    echo json_encode(DMLModules::getPreferenceTableData($preferenceID));
}, 'get');

//get person table data
Route::add('/g/([a-z,0-9]*)',function($alias)
{
    include_once('./DBSrc/DMLModules.php');
    echo json_encode(DMLModules::getPersonCategoryTable(DMLModules::getName($alias)));
}, 'get');


//////////////////////////////////////////////////
//////////////////Generate Keys///////////////////
Route::add('/newKey',function()
{
    include_once('./Pages/HTML.php');
    echo HTML::newKey($_REQUEST['inputKeyUses'], $_REQUEST['inputName'], $_REQUEST['inputPassword']);
},'post');


//////////////////////////////////////////////////
/////////////////user functions///////////////////
Route::add('/login',function()
{
    include_once("./Pages/login.php");
}, 'get');

Route::add('/login',function()
{
    include_once('./Pages/HTML.php');
    echo HTML::userMainPage($_REQUEST['inputName'], $_REQUEST['inputPassword']);
}, 'post');

Route::add('/login/table',function()
{
    include_once('./Pages/HTML.php');
    echo HTML::onlyUserCategoryTable($_REQUEST['inputName'], $_REQUEST['inputPassword']);    
}, 'post' );

Route::add('/regrister',function()
{
    include_once('./Pages/HTML.php');
    echo HTML::regristration();
}, 'get');

Route::add('/regrister',function()
{
    include_once('./Pages/HTML.php');
    HTML::addAccount($_REQUEST['inputName'], $_REQUEST['inputAlias'], $_REQUEST['inputPassword'], $_REQUEST['inputKey']);
}, 'post');

Route::add('/reg',function()
{
    include_once('./Pages/HTML.php');
    echo HTML::regristration();
}, 'get');

Route::add('/reg',function()
{
    include_once('./Pages/HTML.php');
    HTML::addAccount($_REQUEST['inputName'], $_REQUEST['inputAlias'], $_REQUEST['inputPassword'], $_REQUEST['inputKey']);
}, 'post');

Route::add('/admin',function()
{
    include_once('./Pages/HTML.php');
    echo HTML::adminPage();
}, 'get');

Route::add('/delcate',function()
{
    include_once('./DBSrc/DMLModules.php');
    echo DMLModules::removeCategory($_REQUEST['inputName'], $_REQUEST['inputPassword'], $_REQUEST['inputCategory']);
}, 'post');

Route::add('/addcate',function()
{
    include_once('./DBSrc/DMLModules.php');
    echo DMLModules::addCategory($_REQUEST['inputName'], $_REQUEST['inputPassword'], $_REQUEST['inputCategory']);
}, 'post');

Route::add('/addchangepref',function()
{
    include_once('./DBSrc/DMLModules.php');
    //$user, $password, $category, $preference, $rating
    echo DMLModules::addChangePreference(   $_REQUEST['inputName'], 
                                            $_REQUEST['inputPassword'], 
                                            $_REQUEST['inputCategory'], 
                                            $_REQUEST['inputPreference'], 
                                            $_REQUEST['inputRating']);
}, 'post');

Route::add('/delpref',function()
{
    include_once('./DBSrc/DMLModules.php');
    //$user, $password, $category, $preference, $rating
    echo DMLModules::deletePreference(  $_REQUEST['inputName'], 
                                        $_REQUEST['inputPassword'], 
                                        $_REQUEST['inputCategory'], 
                                        $_REQUEST['inputPreference']);
}, 'post');

Route::add('/hints',function()
{
    include_once('./Pages/HTML.php');
    echo HTML::hints();
}, 'get');

//////////////////////////////////////
//////////////Shortcuts///////////////
//shortcut to preference ID by id
Route::add('/s/([0-9]*)',function($id)
{
    include_once('./Pages/HTML.php');
    echo HTML::PreferenceByID($id);
}, 'get');

//shortcut to person
Route::add('/s/([a-z,0-9]*)',function($name)
{
    include_once('./Pages/HTML.php');
    echo HTML::Person($name);
}, 'get');

//shortcut to preference ID by alias and category
Route::add('/s/([a-z,0-9]*)/([a-z,0-9]*)',function($alias, $category)
{
    include_once('./Pages/HTML.php');
    echo HTML::Preference($alias, $category);
}, 'get');





// redirect every failed thing to the start page
Route::add('/(.*)',function()
{
    include_once('./Pages/HTML.php');
    echo HTML::main();
}, 'get');

////////////////
//start router//
Route::run('/');
?>