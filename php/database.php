<?php
    // SERVIDOR REMOTO
    // $servername = "projectdev.services";
    // $username = "theboss";
    // $password = "Manu!6273";
    // $dbname = "app_send";
    // $port = "39399";

    // SERVIDOR LOCAL
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "app_send";

    //$conn = new mysqli($servername, $username, $password, $dbname, $port);
    $conn = new mysqli($servername, $username, $password, $dbname);
        
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // $sql = "CREATE TABLE app_send_control(
    //         control INT(4)  PRIMARY KEY, 
    //         firstname VARCHAR(30) NOT NULL,
    //         lastname VARCHAR(30) NOT NULL,
    //         email VARCHAR(50)
    //         )";

    // if ($conn->query($sql) === TRUE) {
    //     echo "Table employees created successfully";
    // } else {
    //     echo "Error creating table: " . $conn->error;
    // }

    //$conn->close();
?>