$("#keyForm").submit(function(e) 
{

    var form = $(this);
    var actionUrl = form.attr('action');

    e.preventDefault(); // avoid to execute the actual submit of the form.

});
async function getKeys(form, actionUrl)
{
    $.ajax(
        {
            type: "POST",
            url: actionUrl,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {
                data = data.split('|');
                // Find a <table> element with id="myTable":
                var keyTable = document.getElementById("keyTable");
    
                // Create an empty <tr> element and add it to the 1st position of the table:
                var row = keyTable.insertRow();
    
                // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
                var keys = row.insertCell(0);
                var uses = row.insertCell(1);
    
                // Add some text to the new cells:
                keys.innerHTML = data[0];
                uses.innerHTML = data[1]; 
            }
        }); 
}
if(false)
{
    if(!preg_match("/[a-z]/i", $accountname)){
        $echo += "You need at least 1 alphabet letter in your Account name. ";
    }

    if(strlen($accountname) > 32)
    {
        $echo += "A maximum of 32 Letters are allowed for the Account name. ";
    }

    if(strlen($accountname) < 5)
    {
        $echo += "You need at least 5 Letters for the Account name. ";
    }

    //check alias
    if(!preg_match("/[a-z]/i", $alias)){
        $echo = "You need at least 1 alphabet letter in your public alias. ";
    }

    if(strlen($alias) > 32)
    {
        $echo += "A maximum of 32 Letters are allowed for the public alias. ";
    }

    if(strlen($alias) < 5)
    {
        $echo += "You need at least 5 Letters for the public alias. ";
    }

    //check Key
    if($key != "")
    {
        trim($key, " \n\r\t\v\x00");
        if (strlen($key) != 32) {
            $echo += "The key needs a lenght of 32. ";
        }
        if (!preg_match("#^[a-zA-Z0-9]+$#", $key)) {
            $echo += 'The key has illegal Letters. ';
        } 
    }
}