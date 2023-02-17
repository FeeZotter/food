# ToDo

### important
- User add 
    - dml test
    - module create
    - page create
    - index create
- user config
    - page create
    - User delete
        - dml create
        - module create
    - add preference
        - dml create
        - module create
    - delete preference
        - dml create
        - module create
    - delete category
        - dml create
        - module create
- Admin page
    - add Kategories
        - dml create
        - module create
    - secured add Keys
        - dml change
        - module change

### features
- change alias
- change key


# notes
var myList = [
  { "name": "abc", "age": 50 },
  { "age": "25", "hobby": "swimming" },
  { "name": "xyz", "hobby": "programming" }
];

// Builds the HTML Table out of myList.
function buildHtmlTable(selector) {
  var columns = addAllColumnHeaders(myList, selector);

  for (var i = 0; i < myList.length; i++) {
    var row$ = $('<tr/>');
    for (var colIndex = 0; colIndex < columns.length; colIndex++) {
      var cellValue = myList[i][columns[colIndex]];
      if (cellValue == null) cellValue = "";
      row$.append($('<td/>').html(cellValue));
    }
    $(selector).append(row$);
  }
}

// Adds a header row to the table and returns the set of columns.
// Need to do union of keys from all records as some records may not contain
// all records.
function addAllColumnHeaders(myList, selector) {
  var columnSet = [];
  var headerTr$ = $('<tr/>');

  for (var i = 0; i < myList.length; i++) {
    var rowHash = myList[i];
    for (var key in rowHash) {
      if ($.inArray(key, columnSet) == -1) {
        columnSet.push(key);
        headerTr$.append($('<th/>').html(key));
      }
    }
  }
  $(selector).append(headerTr$);

  return columnSet;
}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<body onLoad="buildHtmlTable('#excelDataTable')">
  <table id="excelDataTable" border="1">
  </table>
</body>

regex IPv4
^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)
