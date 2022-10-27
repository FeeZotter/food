function httpGetAsync(theUrl, callback)
{
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
            callback(xmlHttp.responseText);
    }
    xmlHttp.open("GET", theUrl, true); // true for asynchronous 
    xmlHttp.send(null);
}

function get(url) {
    console.log(url)
    fetch(url).then(function(response) {
        return response.json();
      }).then(function(data) {
        console.log(data);
      }).catch(function() {
        console.log("Booo");
      });
}

async function fetchAsync (url) {
    let response = await fetch(url);
    let data = await response.json();
    console.log(data);
    return data;
}

var HttpClient = function() {
    this.get = function(aUrl, aCallback) {
        var anHttpRequest = new XMLHttpRequest();
        anHttpRequest.onreadystatechange = function() { 
            if (anHttpRequest.readyState == 4 && anHttpRequest.status == 200)
                aCallback(anHttpRequest.responseText);
        }

        anHttpRequest.open( "GET", aUrl, true );            
        anHttpRequest.send( null );
    }
}

var table = document.getElementById('table');
table.onclick = () => {
    //console.log(event.target);
    if(event.target.tagName == "TD")
    {
        console.log("clicked on table row with outerText: " + event.target.outerText);
        var a = "";
    //    httpGetAsync("localhost/get/" + event.target.outerText, a);
   //     fetchAsync("http://localhost/get/" + event.target.outerText);
     //   fetchAsync("https://haveibeenpwned.com/api/v3/breaches");
        var client = new HttpClient();
        client.get('https://google.com', function(response) {
            console.log(response);
        });
        client.get('localhost/get/' + event.target.outerText, function(response) {
            console.log(response)
        });
       // window.location.href = "/food/ViewLayer2.php";
    }
}
