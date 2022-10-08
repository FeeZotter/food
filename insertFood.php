<?php
    include("databaseConnection.php");
    // Create connection
    $conn = new mysqli($conf_servername, 
                       $conf_username, 
                       $conf_password, 
                       $conf_dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape user inputs for security
    $food = mysqli_real_escape_string($conn, $_REQUEST['food']);
    $rating = mysqli_real_escape_string($conn, $_REQUEST['rating']);

    //check if entry exists
    $sql = "SELECT '$conf_tableContent', 
                   '$conf_tableRating' 
            FROM $conf_tableName 
            WHERE $conf_tableContent='$food'";

    $result = $conn->query($sql);

    if(mysqli_num_rows($result) != 0)
    {
        while($row = $result->fetch_assoc()) {
            if($row["$conf_tableRating "] == $rating)
            {
                //add new food
                $sql = "UPDATE $conf_tableName 
                        SET $conf_tableRating  = '$rating' 
                        WHERE $tableContent = '$food'";

                // Attempt insert query execution
                if(mysqli_query($conn, $sql)){
                //   echo "Food added successfully.";
                    echo ("'$food' rating changed to '$rating'");
                } else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }
            }
        }
        echo "$food already exists";
    }
    else
    {
        //add new food
        $sql = "INSERT INTO $conf_tableName ($conf_tableContent, 
                                        $conf_tableRating ) 
                VALUES ('$food', 
                        '$rating')";

        // Attempt insert query execution
        if(mysqli_query($conn, $sql))
        {
            echo ("'$food' added successfully");
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }

    $conn->close();
?>
