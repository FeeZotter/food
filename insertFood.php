<?php
    include("databaseConnection.php");
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape user inputs for security
    $food = mysqli_real_escape_string($conn, $_REQUEST['food']);
    $rating = mysqli_real_escape_string($conn, $_REQUEST['rating']);

    //check if entry exists
    $sql = "SELECT food, rating FROM testfood WHERE food='$food'";

    $result = $conn->query($sql);

    if(mysqli_num_rows($conn->query($result)) != 0)
    {
        while($row = $result->fetch_assoc()) {
            if($row["rating"] == $rating)
            {
                //add new food
                $sql = "UPDATE testfood SET rating = '$rating' WHERE food = '$food'";

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
        $sql = "INSERT INTO testfood (food, rating) VALUES ('$food', '$rating')";

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

