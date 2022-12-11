<?php
// Flag for successful insertion
$connect = false;
$twgloginmodal = 'false';
$logintrue = 'false';

if (isset($_POST['sname'])) {
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
<!DOCTYPE html>
<html lang="en">

<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="index-nav-slider.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img id="img" src="abhi.png" alt=""></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">packages</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">about doctor</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">about ayurveda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">book appointment</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <button id="login" data-bs-toggle="modal" data-bs-target="#Loginmodal" class="mx-2 btn btn-outline-success" type="button">Login</button>
          <button  data-bs-toggle="modal" data-bs-target="#Signupmodal" class="mx-2 btn btn-outline-success" type="button">Signup</button>
        </form>
      </div>
    </div>
  </nav>
  <?php
  if($connect){
    echo '<div id="signupalert" class="alert alert-'.$status.' alert-dismissible fade show m-0" role="alert">
          <strong class="text-secondary">'.$status. '!</strong>'.$msg.'.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  }
  ?>
  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="img1.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="img2.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="img3.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="img4.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="img5.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <footer>
    <div class="main-content">
      <div class="left box">
        <h2>About us</h2>
        <div class="content">
          <p>my name is gawas. yow how many hto hanwl nahjs hskskbhx ajhskk hhskxks. jbsj jhabsjb shbhsbk jsnjsnkl jnjnd
            hbsefc janwddkna jndjnaej janwjnd jwdnajwndw jwndkwndknw jawndjnwj.</p>
          <div class="social">
            <a href="https://facebook.com/coding.np"><span class="fab fa-facebook-f"></span></a>
            <a href="#"><span class="fa fa-map-marker-alt"></span></a>
            <a href="https://instagram.com/coding.np"><span class="fab fa-instagram"></span></a>
            <a href="https://youtube.com/c/codingnepal"><span class="fab fa-youtube"></span></a>
          </div>
        </div>
      </div>

      <div class="center box">
        <h2>Address</h2>
        <div class="content">
          <div class="place">
            <span class="fas fa-map-marker-alt"><a href="#"></a></span>
            <span class="text">Sidhivinayak Apartment, Shivajinagar,Kudal </span>
          </div>
          <div class="phone">
            <span class="fas fa-phone-alt"></span>
            <span class="text">+91-8254325805</span>
          </div>
          <div class="email">
            <span class="fas fa-envelope"></span>
            <span class="text">avirajgawas@gmail.com</span>
          </div>
        </div>
      </div>

      <div class="right box">
        <h2>Contact us</h2>
        <div class="content">
          <a class="avi">
            <span class="fa fa-envelope"> </span>
          </a>
  </footer>
  <!-- Modal -->
  <div class="modal fade modal-lg" id="Signupmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-secondary" id="staticBackdropLabel">Signup</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="./index.php" method="post">
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label  text-secondary">Name</label>
              <input required name="sname" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" minlength="3">
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label  text-secondary">Email address</label>
              <input required name="semail" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label  text-secondary">Phone</label>
              <input required name="sphone" type="phone" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" minlength="10">
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label  text-secondary">Password</label>
              <input required name="spassword" type="password" class="form-control" id="exampleInputPassword1" minlength="6">
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label  text-secondary">Confirm Password</label>
              <input required name="scpassword" type="password" class="form-control" id="exampleInputPassword1" minlength="6">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Signup</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="Loginmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-secondary" id="staticBackdropLabel">Login</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="./index.php" method="post">
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label  text-secondary">Email address</label>
              <input name="lemail" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label  text-secondary">Password</label>
              <input name="lpassword" type="password" class="form-control" id="exampleInputPassword1">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>


<script src="script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
  let twgloginmodal = <?= $twgloginmodal ?> 

  let logintrue = <?= $logintrue ?> 
  setTimeout(() => {
    $("#signupalert").display = "none";
  }, 2500);

  setTimeout(() => {
    if(twgloginmodal){
      login.click();
      twgloginmodal = 'false'
    }
  }, 3000);
  
  setTimeout(() => {
    if(logintrue){
      window.location.href = "login.php";
    }
  }, 3000);
});
</script>
</body>

</html>