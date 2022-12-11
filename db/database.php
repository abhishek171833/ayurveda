<?php
// Flag for successful insertion
    // Connection variables
    $server = "localhost";
    $username = "root";
    $password = "";
  
    // Connecting to the database
    $con = mysqli_connect($server, $username, $password);

  // Checking the connection to the database was successful or not
  if (!$con) {
    die("Connection of the database failed due to some error" . mysqli_connect_error());
  } else {
    // Getting the post variables
    $name = $_POST['sname'];
    $email = $_POST['semail'];
    $phone = $_POST['sphone'];
    $password = $_POST['spassword'];
    $cpassword = $_POST['scpassword'];

    if($password !=  $cpassword){
      $status = 'warning';
      $msg = "Passwords do not match";
      $connect = true;
    }
    else{

    $sql = "INSERT INTO `ayurveda`.`users` (`name`,`phone`,`email`,`password`,`datetime`) VALUES ( '$name','$email','$phone','$password','CURRENT_TIMESTAMP()');";

    if ($con->query($sql) == true) {
      // Flag for successfull insertion
      // echo "datebase record inserted";
      // die;
      $status = 'success';
      $connect = true;
      $msg = "Sign up successfully,Now you can login";
      $twgloginmodal = 'true';
    } else {
      print_r("<br> The failed at the client");
      echo "<br>";
      print_r(mysqli_error($con));
      echo "<br>";
    }

    // Closing the database connection
    $con->close();
  }
}
unset($_POST); 
}
else if (isset($_POST['lemail'])) {
    // Connection variables
    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "ayurveda";
  
    // Connecting to the database
    $con = mysqli_connect($server, $username, $password,$db);

  $email = $_POST['lemail'];
  $password = $_POST['lpassword'];
  
  $sql = "SELECT * FROM `users` WHERE name = '$email' AND password = '$password';";

  if ($con->query($sql) == true) {
    // Flag for successfull insertion
    // echo "datebase record inserted";
    // die;
    $status = 'success';
    $connect = true;
    $msg = "Login successfully";
    $logintrue = 'true';
  } else {
    print_r("<br> The failed at the client");
    echo "<br>";
    print_r(mysqli_error($con));
    echo "<br>";
  }
  unset($_POST); 
}
?>
