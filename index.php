<?php
ini_set("allow_url_include", true);
//ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);
// Include router class
include_once('./Route.php');
include_once("./Session.php");
Session::innit();


// Add base route (startpage)
Route::add('/',function()
{
    include_once("./Pages/main.php");
}, 'get');

//======================================================================
// General Pages
//======================================================================

Route::add('/impressum',function()
{
    include_once("./Pages/impressum.php");
}, 'get');

Route::add('/api',function()
{
    include_once('./Pages/HTML.php');
    echo HTML::hints();
}, 'get');


//======================================================================
// User
//======================================================================
Route::add('/login',function()
{
    include_once("./Pages/login.php");
}, 'get');

Route::add('/login',function()
{
    if(isset($_REQUEST["userName"]))
        echo "userName";
    if(isset($_REQUEST['userPassword']))
        echo "password";
   
    echo Session::loginSession($_POST["userName"], $_POST['userPassword']);
   // echo HTML::userMainPage($_REQUEST['inputName'], $_REQUEST['inputPassword']);
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


//======================================================================
// SHORTCUTS
//======================================================================
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


//======================================================================
// Admin
//======================================================================
Route::add('/admin',function()
{
    include_once('./Pages/HTML.php');
    echo HTML::adminPage();
}, 'get');

Route::add('/newKey',function()
{
    include_once('./DBSrc/DMLModules.php');
    echo DMLModules::addNewKey($_REQUEST['inputKeyUses'], $_REQUEST['inputName'], $_REQUEST['inputPassword']);
},'post');


//======================================================================
// API
//======================================================================
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


//======================================================================
// FALLBACK & START ROUTER
//======================================================================

// redirect every failed thing to the start page
Route::add('/(.*)',function()
{
    include_once('./Pages/HTML.php');
    echo HTML::main();
}, 'get');

Route::run('/');
?>