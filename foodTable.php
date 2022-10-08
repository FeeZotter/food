<?php
    include("databaseConnection.php");
    $tableContent = "";
    $tableContentArray = array();

    // Create connection
    $conn = new mysqli($conf_servername, 
                       $conf_username, 
                       $conf_password, 
                       $conf_dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT '$conf_tableId', 
                   '$conf_tableContent', 
                   '$conf_tableRating' 
            FROM $conf_tableName";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $tableContent = $tableContent. 
            "<tr 
                class='color" . $row["'$conf_tableRating'"]  . "'>"
                . "<td><b>"   . $row["'$conf_tableContent'"] . "</b</td>"
                . "<td><b>"   . $row["'$conf_tableRating'"]  . "</b></td>"
            ."</tr>";
        }
    } else {
        $tableContent = "0 results";
    }
    $conn->close();
?>