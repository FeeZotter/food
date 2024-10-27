<!DOCTYPE html>
<head>
    <title>Preferix - TabTest</title>
    <link rel='stylesheet' href='style\tabs.css'>
    <link rel='stylesheet' href='style\style.css'>
</head>
<body>
     <!-- Tab links -->
    <div class="tab">
        <button class="tablinks" id="homeTabBtn"            onclick="openTab(event, 'Home')"            >Home</button>
        <button class="tablinks" id="preferenceListTabBtn"  onclick="openTab(event, 'preferenceList')"  >PreferenceList</button>
        <button class="tablinks" id="preferencesTabBtn"     onclick="openTab(event, 'preferences')"     >Preferences</button>
        <button class="tablinks" id="loginTabBtn"           onclick="openTab(event, 'login')"           >Login</button>
        <button class="tablinks" id="userSpaceTabBtn"       onclick="openTab(event, 'userSpace')"       >User Space</button>
        <button class="tablinks" id="impressumTabBtn"       onclick="openTab(event, 'impressum')"       >Impressum</button>
        <button class="tablinks" id="apiTabBtn"             onclick="openTab(event, 'api')"             >API documentation</button>
    </div>

    <!-- Tab content -->
    <div id="Home" class="tabcontent">
        <?php include_once("Pages/tabs/home.php") ?>
    </div>

    <div id="preferenceList" class="tabcontent">
        <h3>PreferenceList</h3>
    </div>

    <div id="preferences" class="tabcontent">
        <h3>preferences</h3>
    </div>

    <div id="login" class="tabcontent">
        <?php include_once("Pages/tabs/login.php") ?>
        <br>
        <?php include_once("Pages/tabs/regrister.php") ?>
    </div>

    <div id="userSpace" class="tabcontent">
        <h1>NOT LOGGED IN</h1>
        <button onclick="document.getElementById('loginTabBtn').click();">Login or Regrister</button>
    </div>

    <div id="impressum" class="tabcontent">
        <h3>impressum</h3>
    </div> 

    <div id="api" class="tabcontent">
        <h3>API STUFF</h3>
    </div> 

    

</body>
<script src='/js/tabs.js'></script>

<?php ?>