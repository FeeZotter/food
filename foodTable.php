<?php
    include("databaseConnection.php");
    $tableContent = "";
    $tableContentArray = array();

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT $tableId, $tableContent, $tableRating FROM $tableName";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $tableContent = $tableContent. 
            "<tr 
                class='color" . $row["$tableRating"]  . "'>"
                . "<td><b>"   . $row["$tableContent"] . "</b</td>"
                . "<td><b>"   . $row["$tableRating"]  . "</b></td>"
            ."</tr>";
        }
    } else {
        $tableContent = "0 results";
    }
    $conn->close();
?>