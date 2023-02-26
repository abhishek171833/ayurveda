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
    if(isset($_POST['contact_name'])){
        require('./db/database.php');

        $res = mysqli_query($db,"INSERT INTO `contact` (`name`, `email`,`phone_no`,`message`) VALUES('$_POST[contact_name]','$_POST[contact_email]','$_POST[contact_phone]','$_POST[contact_message]');");

        if($res){
            $message['status'] = 1;
            $message['message'] = "Submit Your Contact Successfully";
            echo json_encode($message);
            exit();
        }
        else{
            $message['status'] = 0;
            $message['message'] = "Something Went Wrong";
            echo json_encode($message);
            exit();
        }
    }
?>
<?php 
    if(isset($_POST['lemail'])){
        require('./db/database.php');
        $res=mysqli_query($db,"SELECT * FROM `users` WHERE email='$_POST[lemail]' && password='$_POST[lpassword]';");
        $count=mysqli_num_rows($res);
        if($count){
            $_SESSION['login_user'] = $_POST['lemail'];
            $message['status'] = 1;
            $message['message'] = "You Logged In Successfully!";
            echo json_encode($message);
            exit();
        }
        else{
            $message['status'] = 0;
            $message['message'] = "Email Or Password Does Not Match!!";
            echo json_encode($message);
            exit();
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
        <script>
            $( function() {
                $("#appointment_time").datepicker({ minDate: 0});
            } );
            $( function() {
                $("#package_appointment_time").datepicker({ minDate: 0});
            } );
        </script>
    <style>
        #home_header {
            width: 100%;
            height: 50vw;
            background: url(assets/img/home.jpg);
            /* background-size: cover; */
            animation: slide 20s infinite; 
            /* background:red; */
        }
        @keyframes slide{
            10%{
                background:url(assets/img/contactus.png);
                /* background-size: cover; */
            }
            20%{
                background:url(assets/img/map-image.png);
                /* background-size: cover; */
            }
            30%{
                background:url(assets/img/header-bg.jpg);
                /* background-size: cover; */
            }
            40%{
                background:url(assets/img/contactus.png);
                /* background-size: cover; */
            }
            50%{
                background:url(assets/img/map-image.png);
                /* background-size: cover; */
            }
            60%{
                background:url(assets/img/contactus.png);
                /* background-size: cover; */
            }
            70%{
                background:url(assets/img/header-bg.jpg);
                /* background-size: cover; */
            }
            80%{
                background:url(assets/img/contactus.png);
                /* background-size: cover; */
            }
            90%{
                background:url(assets/img/header-bg.jpg);
                /* background-size: cover; */
            }
            100%{
                background:url(assets/img/contactus.png);
                /* background-size: cover; */
            }
        }
        .portfolio-item{
            box-shadow: 16px 17px 23px 5px black, 9px 9px 16px 4px green;
        }
        .about-us-shadow{
            box-shadow: 16px 17px 23px 5px black, 9px 9px 16px 4px green;
        }
        .team-images,#map{
            box-shadow: 16px 17px 23px 5px black, 9px 9px 16px 4px green;
        }
        .contact-input{
            box-shadow: 5px 11px 10px 5px black, inset 6px 7px 7px 5px #7d7a69;
        }
        input::-webkit-input-placeholder {
            color: yellow; /*Change the placeholder color*/
            opacity: 0.5; /*Change the opacity between 0 and 1*/
        }
        #submit_contact_button,.g-recaptcha{
            box-shadow: 5px 11px 10px 5px black, 6px 7px 7px 5px #7d7a69;
        }
    </style>
</head>
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
    <div class="container-fluid">
        <a class="navbar-brand" href="#page-top"><img src="assets/img/navbar-logo.png" alt="..." /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class="collapse navbar-collapse flex justify-content-end" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase py-4 py-lg-0">
                <li class="nav-item rounded bg-success"><a class="nav-link text-white" href="#deseases">Deseases</a></li>
                <li class="nav-item rounded bg-success"><a class="nav-link text-white" href="#packages">Panchkarma</a></li>
                <li class="nav-item rounded bg-success"><a class="nav-link text-white" href="#about">About</a></li>
                <li class="nav-item rounded bg-success"><a class="nav-link text-white" href="#contact">Contact</a></li>
                <li class="nav-item rounded bg-success"><a class="nav-link text-white" type="button" id="book_appoinement">Book Appointment</a></li>
                <li>
                <?php if(isset($_SESSION['login_user'])){?>
                <li data-bs-toggle="modal" data-bs-target="#myAppointmentsModal" class="nav-item rounded bg-success"><a class="nav-link text-white" type="button">Your Appointments</a></li>
                <li>
                <?php } ?>
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




<div class="modal fade" id="myAppointmentsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-secondary" id="staticBackdropLabel">Your Appointments</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php 
                    require('db/database.php');
                    $res=mysqli_query($db,"SELECT id FROM `Users` WHERE Email='$_SESSION[login_user]';");
                    $user=$res->fetch_row()[0];

                    $res=mysqli_query($db,"SELECT package_id,appointment_time,message FROM `appointments` WHERE user_id='$user';");
                    $rowcount=mysqli_num_rows($res);
                    if($rowcount>0){ ?>
                     <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">SrNo</th>
                                <th scope="col">Appointment Type</th>
                                <th scope="col">Appointment Time</th>
                                <th scope="col">Message</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                    <?php
                    $i = 0;
                    while ($row = mysqli_fetch_assoc($res)){ $i++;
                    if(!$row['package_id'] == NULL){
                        $res=mysqli_query($db,"SELECT title FROM `packages` WHERE id='$row[package_id]';");
                        $package_name = $res -> fetch_row();
                        $row['package_id'] = $package_name[0];
                    }
                    else{
                        $row['package_id'] = "Normal Appointment";
                    }
                    ?>
                        <tr>
                        <th scope="row"><?=$i;?></th>
                            <td><?=$row['package_id']?></td>
                            <td><?=$row['appointment_time']?></td>
                            <td><?=$row['message']?></td>
                            <td><ul class="list-inline d-flex justify-content-between">
                                <li>
                                    <a href="add-book.php?book=test&amp;author=test&amp;edition=1st&amp;quantity=2&amp;department=" data-toggle="tooltip" data-placement="left" title="" class="btn btn-success btn-sm rounded-0" type="button" data-original-title="Edit" data-bs-original-title="Edit" aria-label="Edit"><svg class="svg-inline--fa fa-pen-to-square" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M490.3 40.4C512.2 62.27 512.2 97.73 490.3 119.6L460.3 149.7L362.3 51.72L392.4 21.66C414.3-.2135 449.7-.2135 471.6 21.66L490.3 40.4zM172.4 241.7L339.7 74.34L437.7 172.3L270.3 339.6C264.2 345.8 256.7 350.4 248.4 353.2L159.6 382.8C150.1 385.6 141.5 383.4 135 376.1C128.6 370.5 126.4 361 129.2 352.4L158.8 263.6C161.6 255.3 166.2 247.8 172.4 241.7V241.7zM192 63.1C209.7 63.1 224 78.33 224 95.1C224 113.7 209.7 127.1 192 127.1H96C78.33 127.1 64 142.3 64 159.1V416C64 433.7 78.33 448 96 448H352C369.7 448 384 433.7 384 416V319.1C384 302.3 398.3 287.1 416 287.1C433.7 287.1 448 302.3 448 319.1V416C448 469 405 512 352 512H96C42.98 512 0 469 0 416V159.1C0 106.1 42.98 63.1 96 63.1H192z"></path></svg><!-- <i class="fa fa-edit"></i> Font Awesome fontawesome.com --></a>
                                </li>
                                <li>
                                    <button data-id="7" data-toggle="tooltip" data-placement="left" title="" class="btn btn-danger btn-sm rounded-0 delete_button" type="button" data-original-title="Delete" data-bs-original-title="Delete" aria-label="Delete"><svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128H416L394.8 466.1z"></path></svg><!-- <i class="fa fa-trash"></i> Font Awesome fontawesome.com --></button>
                                </li>
                                </ul></td>
                            </tr>
                    </tbody>
                    <?php } ?>
                </table>
            <?php } else {?>
                <div class="text-center">You Don't Have Any Appointments Yet! Book Your First Appointment Now</div>
            <?php } ?>
            </div>
        </div>
    </div>
</div>







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
                    <form method="post" id="login_form">
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="login_btn"type="button" class="btn btn-success">Login</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Masthead-->
    <header class="masthead" id="home_header">
            
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


                <div data-aos="<?php if($row['id'] == '5'){echo "fade-up";}else if(is_float($row['id']/2)){echo "fade-right";}else{echo "fade-left";} ?>" data-aos-offset="250" data-aos-duration="700" data-aos-easing="ease-in-sine" class="<?php if($row['id'] == '5'){echo "col-md-12";}else{echo "col-md-6";} ?> mb-5">
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
                                        <ul>
                                            <?php $advantages = (explode(",",$row['advantages']));
                                            foreach ($advantages as $value) { ?>
                                            <li style="word-wrap:break-word;"><?=$value?></li>
                                            <?php }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button data-id="<?=$row['id']?>" data-image="<?=$row['image_path']?>" data-title="<?=$row['title']?>" data-desc="<?=$row['desc']?>" class="btn btn-success btn-xl text-uppercase book-packages" type="button">  
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

                <div class="col-md-4 mb-5" data-aos="flip-left" data-aos-offset="250" data-aos-duration="700" data-aos-easing="ease-in-sine">
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

                <div class="modal fade" id="deseases<?=$row['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Desease Information</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body row">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="card">
                                            <img class="card-img-top" src="<?=$row['image_path']?>" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title"><?=$row['title']?></h5>
                                                <p class="card-text"><?=$row['description']?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <h3>Recommended pakcages for <?=$row['title']?></h3>
                                        <ol>
                                            <!-- <?php $advantages = (explode(",",$row['advantages']));
                                            foreach ($advantages as $value) { ?>
                                            <li><?=$value?></li>
                                            <?php } ?> -->
                                        </ol>
                                    </div>
                                </div>

                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <!-- <button class="btn btn-success btn-xl text-uppercase book-packages" type="button">  
                                    <a class="text-light text-decoration-none book_appointment_packages">BOOK APPOINTMENT</a>
                                </button> -->
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
                    <h4 class="text-center my-5" data-aos="fade-right" data-aos-offset="250" data-aos-duration="700" data-aos-easing="ease-in-sine">About Ayurveda</h4>
                        <p class="about-us-shadow p-4" data-aos="flip-left" data-aos-offset="250" data-aos-duration="700" data-aos-easing="ease-in-sine">Health is a state of physical, mental and social well-being, not just the
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
                            authorities still apply.
                        </p>
                </div>
                <div class="col-md-6">
                    <h4 class="text-center my-5" data-aos="fade-left" data-aos-offset="250" data-aos-duration="700" data-aos-easing="ease-in-sine">About Our Doctor</h4>
                    <p class="about-us-shadow p-4" data-aos="flip-right" data-aos-offset="250" data-aos-duration="700" data-aos-easing="ease-in-sine">Health is a state of physical, mental and social well-being, not just the
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
                        <img class="mx-auto rounded-circle team-images" src="assets/img/team/1.jpg" alt="..." data-aos="flip-right" data-aos-offset="250" data-aos-duration="700" data-aos-easing="ease-in-sine"/>
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
                        <img class="mx-auto rounded-circle team-images" src="assets/img/team/2.jpg" alt="..." data-aos="flip-right" data-aos-offset="250" data-aos-duration="700" data-aos-easing="ease-in-sine"/>
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
                        <img class="mx-auto rounded-circle team-images" src="assets/img/team/2.jpg" alt="..." data-aos="flip-right" data-aos-offset="250" data-aos-duration="700" data-aos-easing="ease-in-sine"/>
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
            <div id="map" class="mx-4" data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine">
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
            <form id="contactForm" class="mx-4" data-aos="fade-left" data-aos-offset="300" data-aos-easing="ease-in-sine">
                <div class="row align-items-stretch mb-3">
                    <div class="form-group col-md-6">
                        <input class="form-control contact-input" id="contact_name" type="text" placeholder="Your Name *" name="contact_name"/>
                    </div>
                    <div class="form-group mb-md-0 col-md-6">
                        <input class="form-control contact-input" id="contact_phone" type="tel" placeholder="Your Phone *" name="contact_phone"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control contact-input" id="contact_email" type="email" placeholder="Your Email *" name="contact_email"/>
                    </div>
                    <div class="form-group form-group-textarea mb-md-0">
                        <textarea class="form-control contact-input" id="contact_message" placeholder="Your Message *" name="contact_message"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <div class="g-recaptcha" data-sitekey="6LdSabQkAAAAABAlmMljni1wuC_rG-K56ocK12ka"></div>
                    </div>
                    <div class="col-md-12 text-center my-3">
                        <button class="btn btn-success btn-xl text-uppercase" id="submit_contact_button">Send Message</button>
                    </div>
                </div>
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
    AOS.init();
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
                    .then(()=>{
                        normal_appoinement_form.reset();
                        location.reload();
                    })
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
                formData.append('package_appointment_time',package_appointment_time.value)
                formData.append('package_file',file.value)
                formData.append('package_appointment_message',package_appointment_message.value)
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

        let contact_btn = document.getElementById("submit_contact_button")
        contact_btn.addEventListener("click",async function(e){
            e.preventDefault();
            let formData = new FormData(contactForm);
            let response = grecaptcha.getResponse() 
            if(contact_name.value == ""){
                swal("Warning!","Please Enter Name!","warning")
                contact_name.focus();
            }
            else if(contact_phone.value == ""){
                swal("Warning!","Please Enter Phone Number!","warning")
                contact_phone.focus();
            }
            else if(contact_email.value == ""){
                swal("Warning!","Please Enter Email!","warning")
                contact_email.focus();
            }
            else if(contact_message.value == ""){
                swal("Warning!","Please Enter Your Message!","warning")
                contact_phone.focus();
            }
            else if(response.length == 0){
                swal("Warning!","Please Fill The Captcha!","warning")
            } 
            else{
                formData.append('contact_name',contact_name.value)
                formData.append('contact_email',contact_email.value)
                formData.append('contact_phone',contact_phone.value)
                formData.append('contact_message',contact_message.value)
                let fetch_res = await fetch("index.php",{
                    method:"POST",
                    body:formData
                })
                let json_res = await fetch_res.json();
                if(json_res.status){
                    swal("Success!",json_res.message,"success")
                    document.getElementById("contactForm").reset();
                }
                else{
                    swal("Error!",json_res.message,"error")
                    document.getElementById("contactForm").reset();
                }
            }
        })

        let login_button = document.getElementById("login_btn")
        console.log(login_button);
        login_button.addEventListener("click",async function(e){
            // e.preventDefault();

            let formData = new FormData(login_form);
            if(exampleInputEmail.value == ""){
                swal("Warning!","Please Enter Email!","warning")
                contact_name.focus();
            }
            else if(exampleInputPassword1.value == ""){
                swal("Warning!","Please Enter Password!","warning")
                contact_email.focus();
            }
            else{
                formData.append('lemail',exampleInputEmail.value)
                formData.append('lpassword',exampleInputPassword1.value)
                let fetch_res = await fetch("index.php",{
                    method:"POST",
                    body:formData
                })
                let json_res = await fetch_res.json();
                if(json_res.status){
                    swal("Success!",json_res.message,"success").
                    then(()=>{
                        location.reload();
                    })
                    document.getElementById("contactForm").reset();
                }
                else{
                    swal("Error!",json_res.message,"error")
                    document.getElementById("contactForm").reset();
                }
            }
        })
    });
</script>
</body>