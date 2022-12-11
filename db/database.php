<?php
    // Connection variables
    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "ayurveda";
  
    // Connecting to the database
    $con = mysqli_connect($server, $username, $password,$db);

  // Checking the connection to the database was successful or not
  if (!$con) {
    die("Connection of the database failed due to some error" . mysqli_connect_error());
  }
?>
