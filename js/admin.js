//////////////////////////////
//        generateKeys      //
//////////////////////////////

async function getKey()
{
    var jqxhr = $.post('http://localhost/newKeys', function() {
        //nothing
    })
    .done(function(data) {
        keys = data.split('|');
        document.getElementById('Keys').innerHTML += ' {Key: ' + '' + ' , uses: ' + '' + ' } ';
    })
    .then(function() {
        createEvents();
    })
    .fail(function() {
        alert( 'request failed' );
    });
}


//////////////////////////////
//        copyOnClick       //
//////////////////////////////

function copyToClipboard(class_) 
{
    var copyText = document.getElementsByClassName(class_);
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices
    navigator.clipboard.writeText(copyText.value);
    console.log("Copied the text: " + copyText.value);
} 