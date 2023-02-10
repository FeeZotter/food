//////////////////////////////
//        Searchbars        //
//////////////////////////////
var filter, table, tr, td, i, txtValue;

function searchByName() {
    filter = document.getElementById("sortValue").value.toUpperCase();
    table = document.getElementById("tableContent");
    tr = table.getElementsByTagName("tr");
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function searchByRating() {
    filter = document.getElementById("sortRating").value.toUpperCase();
    table = document.getElementById("tableContent");
    tr = table.getElementsByTagName("tr");
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase() == filter || filter == '') {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

//////////////////////////////
//        change data       //
//////////////////////////////