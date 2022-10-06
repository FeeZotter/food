<?php
    $servername = "localhost";
    $username = "testUser";
    $password = "123456";
    $dbname = "test";
    $tableContent = "";
    $tableContentArray = array();

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT ID_testFood, food, rating FROM testfood";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $tableContent = $tableContent. 
        "<tr 
            class='rating" . $row["rating"]      . "'>"
                  . "<td>" . $row["ID_testFood"] . "</td>"
                  . "<td>" . $row["food"]        . "</td>"
                  . "<td>" . $row["rating"]      . "</td>"
        ."</tr>";
    }
    } else {
        $tableContent = "0 results";
    }
    $conn->close();
?>