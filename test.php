<?php 
include("DMLModules.php");

echo '<!DOCTYPE>
<body>
    <head>
        <title>test</title>
        <style>
            .tableFixHead          { overflow: auto; height: 100px; }
.tableFixHead thead th { position: sticky; top: 0; z-index: 1; }

/* Just common table stuff. Really. */
table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }
th     { background:#eee; }
        </style>
    </head>
    <body>
        <form action="post">

        </form>
        <div class="tableFixHead">
  <table>
    <thead>
      <tr><th>TH 1</th><th>TH 2</th></tr>
    </thead>
    <tbody>
      <tr><td>A1</td><td>A2</td></tr>
      <tr><td>B1</td><td>B2</td></tr>
      <tr><td>C1</td><td>C2</td></tr>
      <tr><td>D1</td><td>D2</td></tr>
      <tr><td>E1</td><td>E2</td></tr>
    </tbody>
  </table>
</div>
    </body>
</body>';

?>