var table = document.getElementById('table');
table.onclick = () => {
    //console.log(event.target);
    if(event.target.tagName == "TD")
    {
        console.log("clicked on table row with outerText: " + event.target.outerText);
       // window.location.href = "/food/ViewLayer2.php";
    }
}

/*
"<form action='$page' method='post'>
                        <label class='marginLeft' for='$identifier'>$identifier:</label>
                        <input type='text' name='$identifier' id='$identifier'>
                        <input type='submit' value='Submit'>
                    </form>"







*/