<?php
ini_set("allow_url_include", true);
//ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);
// Include router class
include_once('./Route.php');
include_once("./Session.php");
include_once("./UniversalLibrary.php");
Session::innit();

// Add base route (startpage)
Route::add('/',function()
{
    include_once("./Pages/main.php");
}, 'get');

Route::add('/test',function()
{
    include_once("./Pages/onePage.php");
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
    $filters = [
        'name' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => UniversalLibrary::getNameRegex(),
            ],
        ],
        'password' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => UniversalLibrary::getPassRegex(),
            ],
        ],
    ];

    $input = filter_input_array(INPUT_POST, $filters, true);

    if($input['name'] != null && $input['password'] != null)
    {
        Session::loginSession($input['name'], $input['password']);
    }
    else http_response_code(400);
}, 'post');

Route::add('/login/table',function()
{
    include_once('./Pages/HTML.php');
    echo HTML::onlyUserCategoryTable($_POST['inputName'], $_POST['inputPassword']);    
}, 'post' );

Route::add('/regrister',function()
{
    include_once('./Pages/HTML.php');
    echo HTML::regristration();
}, 'get');

Route::add('/regrister',function()
{
    include_once('./Pages/HTML.php');
    HTML::addAccount($_POST['inputName'], $_POST['inputAlias'], $_POST['inputPassword'], $_POST['inputKey']);
}, 'post');

Route::add('/reg',function()
{
    include_once('./Pages/HTML.php');
    echo HTML::regristration();
}, 'get');

Route::add('/reg',function()
{
    include_once('./Pages/HTML.php');
    HTML::addAccount($_POST['inputName'], $_POST['inputAlias'], $_POST['inputPassword'], $_POST['inputKey']);

    $filters = [
        'name' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => UniversalLibrary::getNameRegex(),
            ],
        ],
        'password' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => UniversalLibrary::getPassRegex(),
            ],
        ],
        'keyuses' => [
            'filter' => FILTER_VALIDATE_INT,
        ],
    ];

    $input = filter_input_array(INPUT_POST, $filters, true);

    if($input['name'] != null && $input['password'] != null && $input['keyuses'] != null)
    {
        include_once('./DBSrc/DMLModules.php');
        echo DMLModules::addNewKey($input['keyuses'] ,$input['name'], $input['password']);
    } 
    else http_response_code(400);

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

Route::add('/newkey',function()
{
    $filters = [
        'name' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => UniversalLibrary::getNameRegex(),
            ],
        ],
        'password' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => UniversalLibrary::getPassRegex(),
            ],
        ],
        'keyuses' => [
            'filter' => FILTER_VALIDATE_INT,
        ],
    ];

    $input = filter_input_array(INPUT_POST, $filters, true);

    if($input['name'] != null && $input['password'] != null && $input['keyuses'] != null)
    {
        include_once('./DBSrc/DMLModules.php');
        echo DMLModules::addNewKey($input['keyuses'] ,$input['name'], $input['password']);
    } 
    else http_response_code(400);
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
    $filters = [
        'category' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => UniversalLibrary::getCategoryRegex(),
            ],
        ],
    ];

    $input = filter_input_array(INPUT_POST, $filters, true);

    if($input['category'] != null)
    {
        include_once('./DBSrc/DMLModules.php');
        DMLModules::removeCategory($input['category']);
    } 
    else http_response_code(400);
}, 'post');

Route::add('/addcate',function()
{
    $filters = [
        'category' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => UniversalLibrary::getCategoryRegex(),
            ],
        ],
    ];

    $input = filter_input_array(INPUT_POST, $filters, true);

    if($input['category'] != null)
    {
        include_once('./DBSrc/DMLModules.php');
        DMLModules::addCategory($input['category']);
    } 
    else http_response_code(400);
}, 'post');

Route::add('/addchangepref',function()
{
    $filters = [
        'category' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => UniversalLibrary::getCategoryRegex(),
            ],
        ],
        'preference' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => UniversalLibrary::getPreferenceRegex(),
            ],
        ],
        'rating' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => [
                'min_range' => 0, 'max_range' => 10
            ],
        ],
    ];

    $input = filter_input_array(INPUT_POST, $filters, true);

    if($input['name'] != null && $input['password'] != null && $input['category'] != null && $input['preference'] != null && $input['rating'] != null)
    {
        include_once('./DBSrc/DMLModules.php');
        DMLModules::addChangePreference($input['category'], $input['preference'], $input['rating']);
    } 
    else http_response_code(400);
}, 'post');

Route::add('/delpref',function()
{
    include_once('./DBSrc/DMLModules.php');
    $filters = [
        'category' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => UniversalLibrary::getCategoryRegex(),
            ],
        ],
        'preference' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => UniversalLibrary::getPreferenceRegex(),
            ],
        ],
    ];

    $input = filter_input_array(INPUT_POST, $filters, true);

    if($input['category'] != null && $input['preference'] != null)
    {
        include_once('./DBSrc/DMLModules.php');
        DMLModules::deletePreference($input['category'], $input['preference']);
    } 
    else http_response_code(400);
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