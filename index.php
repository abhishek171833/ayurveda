<?php
    session_start();
    if(isset($_POST['file'])){
        require('./db/database.php');
        $res=mysqli_query($db,"SELECT id FROM `Users` WHERE Email='$_SESSION[login_user]';");
        $user_id = $res->fetch_row()[0];

        if(isset($_FILES["file"])){
            $errors= array();
            $file_name = $_FILES['file']['name'];
            $file_size =$_FILES['file']['size'];
            $file_tmp =$_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];
            $file_ext=explode('.',$_FILES['file']['name']);
            
            $extensions= array("docx","xlsx","xls","doc","ppt","pptx","txt","pdf");
            
            if(in_array($file_ext[1],$extensions)=== false){
                $message['status'] = 0;
                $message['message']="File Type Not Allowed, Please choose Only Document or Pdf File";
                echo json_encode($message);
                exit();
            }
            if($file_size > 2097152){
                $errors[]='File size must be excately 2 MB';
                $message['status'] = 0;
                $message['message'] = "File Size Must Be Excately 2 MB";
                echo json_encode($message);
                exit();
            }
            else{
                $path = "./appointments/$user_id";
                if(!is_dir($path)){
                    mkdir($path, 0777, true);
                }
                move_uploaded_file($file_tmp,"appointments/$user_id/".$file_name);
                mysqli_query($db,"INSERT INTO `appointments` (`user_id`, `message`,`appointment_time`,`file_name`) VALUES('$user_id','$_POST[appointment_message]','$_POST[appointment_time]','$file_name');");

                $message['status'] = 1;
                $message['message'] = "Appointment Booked Successfully";
                echo json_encode($message);
                exit();
            }
        }
    }
    if(isset($_POST['package_id'])){
        require('./db/database.php');
        $res=mysqli_query($db,"SELECT id FROM `Users` WHERE Email='$_SESSION[login_user]';");
        $user_id = $res->fetch_row()[0];

        if(isset($_FILES["package_file"])){
            $errors= array();
            $file_name = $_FILES['package_file']['name'];
            $file_size =$_FILES['package_file']['size'];
            $file_tmp =$_FILES['package_file']['tmp_name'];
            $file_type=$_FILES['package_file']['type'];
            $file_ext=explode('.',$_FILES['package_file']['name']);
            
            $extensions= array("docx","xlsx","xls","doc","ppt","pptx","txt","pdf");
            
            if(in_array($file_ext[1],$extensions)=== false){
                $message['status'] = 0;
                $message['message']="File Type Not Allowed, Please choose Only Document or Pdf File";
                echo json_encode($message);
                exit();
            }
            if($file_size > 2097152){
                $errors[]='File size must be excately 2 MB';
                $message['status'] = 0;
                $message['message'] = "File Size Must Be Excately 2 MB";
                echo json_encode($message);
                exit();
            }
            else{
                $path = "./appointments/$user_id";
                if(!is_dir($path)){
                    mkdir($path, 0777, true);
                }
                move_uploaded_file($file_tmp,"appointments/$user_id/".$file_name);

                mysqli_query($db,"INSERT INTO `appointments` (`user_id`, `message`,`appointment_time`,`package_id`,`file_name`) VALUES('$user_id','$_POST[package_appointment_message]','$_POST[package_appointment_time]',$_POST[package_id],'$file_name');");

                $message['status'] = 1;
                $message['message'] = "Appointment Booked Successfully";
                echo json_encode($message);
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Ayurveda - Secure Your Health</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
        <script>
            $( function() {
                $("#appointment_time").datepicker({ minDate: 0});
            } );
            $( function() {
                $("#package_appointment_time").datepicker({ minDate: 0});
            } );
        </script>
    <style>
        @media (min-width: 990px) {}
    </style>
</head>
<?php 
    if(isset($_POST['lemail'])){
        require('./db/database.php');
        $res=mysqli_query($db,"SELECT * FROM `users` WHERE email='$_POST[lemail]' && password='$_POST[lpassword]';");
        $count=mysqli_num_rows($res);
        if($count):
            $_SESSION['login_user'] = $_POST['lemail'];
            ?>
            <script>
                setTimeout(() => {  
                    swal("Success!", "You Logged In Successfully!", "success")
                }, 1000);
            </script>
            
            <?php else:?>
            <script>
                setTimeout(() => {
                    swal("Error!", "Email Or Password Does Not Match!", "error");
                }, 1000);
            </script>
        <?php  endif;
    }
?>
<?php
    if(isset($_POST['susername'])){
        require('./db/database.php');
        $res=mysqli_query($db,"SELECT Email FROM `Users` WHERE Email='$_POST[sEmail]';");
        $email=mysqli_num_rows($res);
        
        $res=mysqli_query($db,"SELECT phone FROM `Users` WHERE phone='$_POST[sphone]';");
        $phone=mysqli_num_rows($res);

        if($_POST['spassword'] != $_POST['scpassword']):?>
            <script>
                setTimeout(() => {
                    swal("Warning!", "Password And Confirm Password Does Not Match!", "warning");
                }, 1000);
            </script>

        <?php 

        elseif ($email): ?>
            <script>
                setTimeout(() => {
                    swal("Warning!", "User With This Email Already Exists!", "warning");
                }, 1000);
            </script>
        <?php 


        elseif($phone): ?>
            <script>
                setTimeout(() => {
                    swal("Warning!", "User With This Phone Number Already Exists!", "warning");
                }, 1000);
            </script>

        <?php else:
                // $hash = password_hash($_POST['spassword'],PASSWORD_DEFAULT);
                mysqli_query($db,"INSERT INTO `users` (`name`, `phone`, `email`, `password`) VALUES('$_POST[susername]','$_POST[sphone]','$_POST[sEmail]','$_POST[susername]');");?>
                <script>
                    setTimeout(() => {
                        swal("Success!", "Sign Up Successfully Now You Can Log In!", "success");
                    }, 1000);
                </script>
            <?php
            endif;
        }
    ?>
<body id="page-top">
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="#page-top"><img src="assets/img/navbar-logo.png" alt="..." /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class="collapse navbar-collapse flex justify-content-center" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase py-4 py-lg-0">
                <li class="nav-item rounded bg-success"><a class="nav-link text-white" href="#deseases">Deseases</a></li>
                <li class="nav-item rounded bg-success"><a class="nav-link text-white" href="#packages">Panchkarma</a></li>
                <li class="nav-item rounded bg-success"><a class="nav-link text-white" href="#about">About</a></li>
                <li class="nav-item rounded bg-success"><a class="nav-link text-white" href="#contact">Contact</a></li>
                <li class="nav-item rounded bg-success"><a class="nav-link text-white" type="button" id="book_appoinement">Book Appointment</a></li>
                <li>
                <?php 
                    if(isset($_SESSION['login_user'])){
                        ?>
                        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li class="px-2"><a class="dropdown-item" href="#!">Welcome <b><?=$_SESSION['login_user']?></b></a></li>
                                    <li class="px-2"><a class="dropdown-item" href="./include/logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php } else{ 
                        ?>
                        <button id="login" data-bs-toggle="modal" data-bs-target="#Loginmodal"
                            class="mx-2 btn btn-success" type="button">Login</button>
                        <button data-bs-toggle="modal" data-bs-target="#Signupmodal" class="mx-2 btn btn-success"
                            type="button">Signup</button>
                    <?php }?>
                </li>
            </ul>               
            <form class="d-flex" role="search" style="position:absolute;right:0;">
                </form>

        </div>
    </div>
</nav>
    <!--Book Appointment Modal -->
    <div class="modal fade" id="AppointmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Book Appointment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="normal_appoinement_form">
                        <div class="mb-3">
                            <label for="name" class="form-label">Appointment Time</label>
                            <input class="form-control" id="appointment_time" name="appointment_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Message</label>
                            <textarea name="appointment_message" type="text" class="form-control" id="appointment_message"
                                aria-describedby="emailHelp" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload Your Documents</label>
                            <input name="file" type="file" class="form-control" id="file" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" multiple required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="book_appoinement_btn" class="btn btn-success">Book Appointment</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Signupmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-secondary" id="staticBackdropLabel">Sign Up</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./index.php" method="post">
                        <div class="mb-3">
                            <label for="susername" class="form-label  text-secondary">Username</label>
                            <input name="susername" type="text" class="form-control" id="susername"
                                aria-describedby="usernameHelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="sEmail" class="form-label  text-secondary">Email address</label>
                            <input name="sEmail" type="email" class="form-control" id="sEmail"
                                aria-describedby="emailHelp" required>
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="sphone" class="form-label  text-secondary">Phone Number</label>
                            <input name="sphone" type="number" class="form-control" id="sphone"
                                aria-describedby="emailHelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="spassword" class="form-label  text-secondary">Password</label>
                            <input name="spassword" type="password" class="form-control" id="spassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="scpassword" class="form-label  text-secondary">Confirm Password</label>
                            <input name="scpassword" type="password" class="form-control" id="scpassword" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Sign Up</button>
                </div>
                </form>
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
                            <input name="lemail" type="email" class="form-control" id="exampleInputEmail"
                                aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label  text-secondary">Password</label>
                            <input name="lpassword" type="password" class="form-control" id="exampleInputPassword1">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Login</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Masthead-->
    <header class="masthead" id="home_header">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="./assets/img/home.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                <img src="./assets/img/home.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                <img src="./assets/img/home.jpg" class="d-block w-100" alt="...">
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
    </header>
    </div>
    </section>
    <!-- Panchakarma Grid-->
    <section class="page-section bg-light" id="packages"
        style="background-color:#4fd64e45 !important">
        <div class="container-fluid">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Panchkarma</h2>
                <h3 class="section-subheading text-muted">Our Top 5 Panchkarma Packages.</h3>
            </div>
            <div class="row">

                <?php 
                    require('db/database.php');
                    $sql = "select * from packages;";
                    $query = mysqli_query($db, $sql);
                    while ($row = mysqli_fetch_assoc($query)){?>

                <div class="<?php if($row['id'] == '5'){echo "col-md-12";}else{echo "col-md-6";} ?> mb-5">
                    <!-- Packages item 1-->
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#packages<?=$row['id']?>">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid w-100" src="<?=$row['image_path']?>" alt="..." />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading"><?= $row['title'] ?></div>
                            <div class="portfolio-caption-subheading text-muted"></div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="packages<?=$row['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Book Appointment</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="card">
                                            <img class="card-img-top" src="<?=$row['image_path']?>" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title"><?=$row['title']?></h5>
                                                <p class="card-text"><?=$row['desc']?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <h3>ADVANTAGE OF <?=$row['title']?></h3>
                                        <ol>
                                            <?php $advantages = (explode(",",$row['advantages']));
                                            foreach ($advantages as $value) { ?>
                                            <li><?=$value?></li>
                                            <?php }
                                            ?>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button data-id="<?=$row['id']?>" data-image="<?=$row['image_path']?>" date-title="<?=$row['title']?>" data-desc="<?=$row['desc']?>" class="btn btn-success btn-xl text-uppercase book-packages" type="button">  
                                    <a class="text-light text-decoration-none book_appointment_packages">BOOK APPOINTMENT</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php }?>

            </div>
        </div>
    </section>
    <section class="page-section bg-dark" id="deseases" style="padding-bottom:45px;">
        <div class="container-fluid">
            <div class="text-center">
                <h2 class="section-heading text-uppercase text-light">Deseases</h2>
                <h3 class="section-subheading text-muted">Desease.</h3>
            </div>
            <div class="row">

                <?php 
                    require('db/database.php');
                    $sql = "select * from deseases;";
                    $query = mysqli_query($db, $sql);
                    while ($row = mysqli_fetch_assoc($query)){?>

                <div class="col-md-4 mb-5">
                    <!-- Packages item 1-->
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#deseases<?=$row['id']?>">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid w-100" src="<?=$row['image_path']?>" alt="..." />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading"><?= $row['title'] ?></div>
                            <div class="portfolio-caption-subheading text-muted"></div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-modal modal fade" id="deseases<?=$row['id']?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content p-2">
                            <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg"
                                    alt="Close modal" /></div>
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-12">
                                        <div class="modal-body row">
                                            <!--Packages details-->
                                            <h2 class="text-uppercase mb-5"><?=$row['title']?></h2>
                                            <div class="col-md-6">
                                                <img style="height:50% !important;" class="img-fluid d-block mx-auto" src="<?=$row['image_path']?>" alt="..." />
                                                <p><?=$row['description']?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <h3>ADVANTAGE OF <?=$row['title']?></h3>
                                                <ol>
                                                    <?php $advantages = (explode(",",$row['description']));
                                                    foreach ($advantages as $value) { ?>
                                                    <li><?=$value?></li>
                                                    <?php }
                                                    ?>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
    </section>
    <!-- About-->
    <section class="page-section py-2" id="about">
        <div class="text-center my-5">
            <h2 class="section-heading text-uppercase">About Us</h2>
        </div>
        <div class="container-fluid px-5">
            <ul class="timeline row">
                <div class="col-md-6">
                    <h4 class="text-center">About Ayurveda</h4>
                    <div class="col my-4">
                        <p>Health is a state of physical, mental and social well-being, not just the
                            absence of disease
                            or infirmity. Good health helps people live a full life. Read more.
                            View original
                            The word health refers to a state of complete emotional and physical well-being. Healthcare
                            exists to help people maintain this optimal state of health.
                            According to the Centers for Disease Control and Prevention (CDC), healthcare costs in the
                            United States were $3.5 trillion in 2017.
                            However, despite this expenditure, people in the U.S. have a lower life expectancy than
                            people in other developed countries. This is due to a variety of factors, including access
                            to healthcare and lifestyle choices.
                            Good health is central to handling stress and living a longer, more active life. In this
                            article, we explain the meaning of good health, the types of health a person needs to
                            consider, and how to preserve good health.
                            In 1948, the World Health Organization (WHO) defined health with a phrase that modern
                            authorities still apply.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4 class="text-center">About Our Doctor</h4>
                    <p>Health is a state of physical, mental and social well-being, not just the
                        absence of disease
                        or infirmity. Good health helps people live a full life. Read more.
                        View original
                        The word health refers to a state of complete emotional and physical well-being. Healthcare
                        exists to help people maintain this optimal state of health.
                        According to the Centers for Disease Control and Prevention (CDC), healthcare costs in the
                        United States were $3.5 trillion in 2017.
                        However, despite this expenditure, people in the U.S. have a lower life expectancy than
                        people in other developed countries. This is due to a variety of factors, including access
                        to healthcare and lifestyle choices.
                        Good health is central to handling stress and living a longer, more active life. In this
                        article, we explain the meaning of good health, the types of health a person needs to
                        consider, and how to preserve good health.
                        In 1948, the World Health Organization (WHO) defined health with a phrase that modern
                        authorities still apply.</p>
                </div>
            </ul>
        </div>
    </section>
    <!-- Team-->
    <section class="page-section bg-light py-4" id="team">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Our Amazing Team</h2>
                <h3 class="section-subheading text-muted mb-4">Our Team</h3>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="team-member">
                        <img class="mx-auto rounded-circle" src="assets/img/team/1.jpg" alt="..." />
                        <h4>Parveen Anand</h4>
                        <p class="text-muted">Doctor</p>
                        <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Parveen Anand Twitter Profile"><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Parveen Anand Facebook Profile"><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"
                            aria-label="Parveen Anand Instagram Profile"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="team-member">
                        <img class="mx-auto rounded-circle" src="assets/img/team/2.jpg" alt="..." />
                        <h4>Diana Petersen</h4>
                        <p class="text-muted">Doctor</p>
                        <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Diana Petersen Twitter Profile"><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"
                            aria-label="Diana Petersen Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"
                            aria-label="Diana Petersen Instagram Profile"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="team-member">
                        <img class="mx-auto rounded-circle" src="assets/img/team/2.jpg" alt="..." />
                        <h4>Diana Petersen</h4>
                        <p class="text-muted">Doctor</p>
                        <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Diana Petersen Twitter Profile"><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"
                            aria-label="Diana Petersen Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"
                            aria-label="Diana Petersen Instagram Profile"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <p class="large text-muted">Our Team</p>
                </div>
            </div> -->
        </div>
    </section>
    <section class="page-section row p-4" id="contact">
        <div class="col-md-6 my-4">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Our Store</h2>
                <h3 class="my-3 text-light">Lorem ipsum dolor sit amet consectetur.</h3>
            </div>
            <div id="map" class="mx-4">
                <iframe class="w-100" height="490" id="gmap_canvas"
                    src="https://maps.google.com/maps?q=kudal%20bus%20stand&t=&z=15&ie=UTF8&iwloc=&output=embed"
                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                </iframe>
            </div>
        </div>
        <div class="col-md-6 my-4">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Send Inquiry</h2>
                <h3 class="my-3 text-light">Lorem ipsum dolor sit amet consectetur.</h3>
            </div>
            <form id="contactForm" class="mx-4">
                <div class="row align-items-stretch mb-3">
                    <div class="form-group">
                        <!-- Name input-->
                        <input class="form-control" id="name" type="text" placeholder="Your Name *"
                            data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                    </div>
                    <div class="form-group">
                        <!-- Email address input-->
                        <input class="form-control" id="email" type="email" placeholder="Your Email *"
                            data-sb-validations="required,email" />
                        <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                        <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                    </div>
                    <div class="form-group">
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Select Desease</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>

                    <div class="form-group mb-md-0">
                        <!-- Phone number input-->
                        <input class="form-control" id="phone" type="tel" placeholder="Your Phone *"
                            data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="phone:required">A phone number is required.
                        </div>
                    </div>
                    <div class="form-group form-group-textarea mb-md-0 my-4">
                        <!-- Message input-->
                        <textarea class="form-control" id="message" placeholder="Your Message *"
                            data-sb-validations="required"></textarea>
                        <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.
                        </div>
                    </div>
                </div>
                <!-- Submit Button-->
                <div class="text-center"><button class="btn btn-success btn-xl text-uppercase" id="submitButton"
                        type="submit">Send Message</button></div>
            </form>
        </div>
    </section>

    <div class="modal fade" id="packages_appointment_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Book Appointment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card">
                                <img class="card-img-top" id="package_image" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title" id="package_title"></h5>
                                    <p class="card-text" id="package_desc"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <form enctype="multipart/form-data" id="package_appoinement_form">
                                <input type="hidden" id="package_id">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Appointment Time</label>
                                    <input class="form-control" id="package_appointment_time" name="package_appointment_time" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Message</label>
                                    <textarea name="package_appointment_message" type="text" class="form-control" id="package_appointment_message"
                                        aria-describedby="emailHelp" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="file" class="form-label">Upload Your Documents</label>
                                    <input name="package_file" type="file" class="form-control" id="package_file" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" multiple required>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="package_book_appoinement_btn" class="btn btn-success">Book Appointment</button>
                </div>
            </div>
        </div>
    </div>
    <button id="appointment_modal_toggler" data-bs-toggle="modal" data-bs-target="#packages_appointment_modal" class="d-none" type="button"></button>
<?php include './include/footer.php';?>
<script src="js/scripts.js"></script>
<script>
     document.addEventListener("DOMContentLoaded", () => {
         let session_user = <?php if(isset($_SESSION['login_user'])){echo json_encode($_SESSION['login_user']);}else{ echo json_encode("No user");}?>;
        let package_button = document.querySelectorAll(".book-packages")
        package_button.forEach(element => {
            element.addEventListener("click",function(){
                let id = this.getAttribute('data-id')
                let title = this.getAttribute('data-title')
                let desc = this.getAttribute('data-desc')
                let image = this.getAttribute('data-image')
                if(session_user == "No user"){
                    swal("Warning!", "Please Login To Continue!", "warning")
                }
                else{
                    let package_modal = document.getElementById("packages"+id)
                    $(`#packages${id}`).modal('hide');
                    package_id.value = id;
                    package_title.innerText = title;
                    package_desc.innerText = desc; 
                    package_image.setAttribute("src",image)
                    appointment_modal_toggler.click();
                    
                }
            })
        });
        
        let book_appoinement = document.getElementById("book_appoinement")
        book_appoinement.addEventListener("click",function(e){
            if(session_user == "No user"){
                swal("Warning!", "Please Login To Book Appointment!", "warning")
            }
            else{
                book_appoinement.setAttribute("data-bs-toggle","modal")
                book_appoinement.setAttribute("href","#AppointmentModal")
                book_appoinement.setAttribute("data-bs-target","#AppointmentModal")
                book_appoinement.click();
            }
        })

        let book_appoinement_btn = document.getElementById("book_appoinement_btn")
        book_appoinement_btn.addEventListener("click",async function(){
            let formData = new FormData(normal_appoinement_form);
            if(appointment_time.value == ""){
                swal("Warning!","Please Select Appointment Time!","warning")
            }
            else if(file.value == ""){
                swal("Warning!","Please Select File!","warning")
            }
            else if(appointment_message.value == ""){
                swal("Warning!","Please Select Message!","warning")
            }
            else{
                formData.append('appointment_time',appointment_time.value)
                formData.append('file',file.value)
                formData.append('appointment_message',appointment_message.value)
                let fetch_res = await fetch("index.php",{
                    method:"POST",
                    body:formData
                })
                let json_res = await fetch_res.json();
                if(json_res.status){
                    swal("Success!",json_res.message,"success")
                }
                else{
                    swal("Error!",json_res.message,"error")
                }
            }
        })

        let package_book_appoinement_btn = document.getElementById("package_book_appoinement_btn")
        package_book_appoinement_btn.addEventListener("click",async function(){
            let formData = new FormData(package_appoinement_form);
            if(package_appointment_time.value == ""){
                swal("Warning!","Please Select Appointment Time!","warning")
            }
            else if(package_file.value == ""){
                swal("Warning!","Please Select File!","warning")
            }
            else if(package_appointment_message.value == ""){
                swal("Warning!","Please Select Message!","warning")
            }
            else{
                formData.append('package_appointment_time',appointment_time.value)
                formData.append('package_file',file.value)
                formData.append('package_appointment_message',appointment_message.value)
                formData.append('package_id',package_id.value)
                let fetch_res = await fetch("index.php",{
                    method:"POST",
                    body:formData
                })
                let json_res = await fetch_res.json();
                if(json_res.status){
                    swal("Success!",json_res.message,"success")
                    $(`#packages_appointment_modal`).modal('hide');
                }
                else{
                    swal("Error!",json_res.message,"error")
                }
            }
        })
    });
</script>
</body>