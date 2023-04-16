<?php
    session_start();
    if(isset($_POST['normal_appointment'])){
        require('./db/database.php');
        $res=mysqli_query($db,"SELECT id FROM `Users` WHERE Email='$_SESSION[login_user]';");
        $user_id = $res->fetch_row()[0];

        if(isset($_POST["file"])){
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
                mysqli_query($db,"INSERT INTO `appointments` (`user_id`, `message`,`appointment_time`,`appointment_date`,`file_name`) VALUES('$user_id','$_POST[appointment_message]','$_POST[appointment_time]','$_POST[appointment_date]','$file_name');");

                $message['status'] = 1;
                $message['message'] = "Appointment Booked Successfully";
                echo json_encode($message);
                exit();
            }
        }
        else{
            mysqli_query($db,"INSERT INTO `appointments` (`user_id`, `message`,`appointment_time`,`appointment_date`) VALUES('$user_id','$_POST[appointment_message]','$_POST[appointment_time]','$_POST[appointment_date]');");

            $message['status'] = 1;
            $message['message'] = "Appointment Booked Successfully";
            echo json_encode($message);
            exit();
        }
    }
    if(isset($_POST['package_id'])){
        require('./db/database.php');
        $res=mysqli_query($db,"SELECT id FROM `Users` WHERE Email='$_SESSION[login_user]';");
        $user_id = $res->fetch_row()[0];

        if(!empty($_POST["package_file"])){
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

                mysqli_query($db,"INSERT INTO `appointments` (`user_id`, `message`,`package_id`,`file_name`,`appointment_time`,`appointment_date`) VALUES('$user_id','$_POST[package_appointment_message]',$_POST[package_id],'$file_name','$_POST[appointment_time]','$_POST[appointment_date]');");

                $message['status'] = 1;
                $message['message'] = "Appointment Booked Successfully";
                echo json_encode($message);
                exit();
            }
        }
        else{
            mysqli_query($db,"INSERT INTO `appointments` (`user_id`, `message`,`package_id`,`appointment_time`,`appointment_date`) VALUES('$user_id','$_POST[package_appointment_message]','$_POST[package_id]','$_POST[appointment_time]','$_POST[appointment_date]');");

            $message['status'] = 1;
            $message['message'] = "Appointment Booked Successfully";
            echo json_encode($message);
            exit();
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
    if(isset($_POST['delete_appointment_id'])){
        require('./db/database.php');
        $res = mysqli_query($db,"DELETE FROM `appointments` WHERE `appointments`.`id` = '$_POST[delete_appointment_id]';");
        if($res){
            $message['status'] = 1;
            $message['message'] = "Your Appointment Deleted Successfully";
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

    if(isset($_POST['treatment'])){
        require('./db/database.php');
        $res=mysqli_query($db,"SELECT message FROM `treatments` WHERE Appointment_id='$_POST[appointment_id]';");
        if($res){
            $message['status'] = 1;
            $message['message'] = $treatment_message = $res->fetch_row()[0];
            echo json_encode($message);
            exit();
        } else{
            $message['status'] = 0;
            $message['message'] = "Something Went Wrong To Display Treatment Messsage";
            echo json_encode($message);
            exit();
        }

    }
?>
<?php 
    // Login functionality 
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

    // Sign up functionality 
    if(isset($_POST['susername'])){
        require('./db/database.php');
        $res=mysqli_query($db,"SELECT Email FROM `Users` WHERE Email='$_POST[sEmail]';");
        $email=mysqli_num_rows($res);
        
        $res=mysqli_query($db,"SELECT phone FROM `Users` WHERE phone='$_POST[sphone]';");
        $phone=mysqli_num_rows($res);

        $res=mysqli_query($db,"SELECT name FROM `Users` WHERE name='$_POST[susername]';");
        $username=mysqli_num_rows($res);

        if($email){
            $message['status'] = 0;
            $message['message'] = "User With This Email Already Exists!";
            echo json_encode($message);
            exit();
        }
        else if($phone){
            $message['status'] = 0;
            $message['message'] = "User With This Phone Number Already Exists!";
            echo json_encode($message);
            exit();
        }
        else if($username){
            $message['status'] = 0;
            $message['message'] = "User With This Username Already Exists!";
            echo json_encode($message);
            exit();
        }
        else{
            mysqli_query($db,"INSERT INTO `users` (`name`, `phone`, `email`, `password`) VALUES('$_POST[susername]','$_POST[sphone]','$_POST[sEmail]','$_POST[spassword]');");

            $message['status'] = 1;
            $message['message'] = "Sign Up Successfully Now You Can Log In!";
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
    <style>
        #home_header {
            width: 100%;
            height: 50vw;
        }
        /* #home_header{
            content: "";
            background:url("https://source.unsplash.com/1920x1080/?ayurveda,panchkarma") no-repeat ;
            position: absolute;
            top:0px;
            left:0px;
            height: 50vw;
            width:100%;
            z-index: -1;
            opacity: 0.6;
        } */
        .portfolio-item{
            box-shadow: 16px 17px 23px 5px black, 9px 9px 16px 4px black;
        }
        .team-images,#map{
            box-shadow: 16px 17px 23px 5px black, 9px 9px 16px 4px green;
        }
        .contact-input{
            box-shadow: 5px 11px 10px 5px black, inset 1px 1px 3px 3px #7d7a69;
        }
        input::-webkit-input-placeholder {
            color: yellow; /*Change the placeholder color*/
            opacity: 0.5; /*Change the opacity between 0 and 1*/
        }
        #submit_contact_button,.g-recaptcha{
            box-shadow: 5px 11px 10px 5px black, 6px 7px 7px 5px #7d7a69;
        }
        .password-eye{
            float: right;
            margin-right: 8px;
            margin-top: -25px;
            position: relative;
            /* z-index: 2; */
        }
    </style>
</head>
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
                <?php if(isset($_SESSION['login_user'])){?>
                
                <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle nav-item rounded bg-success" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Your Appointments</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li class="px-2" data-bs-toggle="modal" data-bs-target="#myNormalAppointmentsModal"><a class="dropdown-item" href="#!">Normal Appointments</a></li>
                            <li class="px-2" data-bs-toggle="modal" data-bs-target="#myPackageAppointmentsModal"><a class="dropdown-item" href="#!">Package Appointments</a></li>
                        </ul>
                    </li>
                </ul>
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
                            type="button">Register</button>
                    <?php }?>
                </li>
            </ul>               
            <form class="d-flex" role="search" style="position:absolute;right:0;">
                </form>

        </div>
    </div>
</nav>




<div class="modal fade" id="myNormalAppointmentsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-secondary" id="staticBackdropLabel">Your Normal Appointments</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php 
                    require('db/database.php');
                    $res=mysqli_query($db,"SELECT id FROM `Users` WHERE Email='$_SESSION[login_user]';");
                    $user=$res->fetch_row()[0];

                    $res=mysqli_query($db,"SELECT id,package_id,appointment_time,appointment_date,status,message FROM `appointments` WHERE user_id='$user' and package_id is NULL;");
                    $rowcount=mysqli_num_rows($res);
                    if($rowcount>0){ ?>
                    <div class="table-responsive">
                     <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">SrNo</th>
                                <th scope="col" class="text-center">Appointment Time</th>
                                <th scope="col" class="text-center">Appointment Date</th>
                                <th scope="col" class="text-center">Message</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                    <?php
                    $i = 0;
                    while ($row = mysqli_fetch_assoc($res)){ $i++;
                        if($row['status'] == 0){
                            $row['status'] = "<span class='btn btn-warning'>Pending</span>";
                        }
                        else if($row['status'] == 1){
                            $row['status'] = "<span class='btn btn-success'>Approved</span>";
                        }
                        else if ($row['status'] == 2){
                            $row['status'] = "<span class='btn btn-primary'>Completed</span>";
                        }
                        else {
                            $row['status'] = "<span class='btn btn-danger'>Declined</span>";
                        }
                    ?>
                        <tr>
                        <th scope="row"><?=$i;?></th>
                            <td class="text-center"><?=$row['appointment_time']?></td>
                            <td class="text-center"><?=date_format(date_create($row['appointment_date']),"d/M/Y")?></td>
                            <td class="text-center"><?=$row['message']?></td>
                            <td class="text-center"><?=$row['status']?></td>
                            <td class="text-center"><ul class="list-inline d-flex justify-content-center">
                                <i onclick="delete_appointment(this)" data-id="<?=$row['id'];?>" style="cursor:pointer;font-size:25px;" class="mx-2 fa-solid fa-trash delete_button"></i>
                            </ul></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                </table>
                </div>
            <?php } else {?>
                <div class="text-center">You Don't Have Any Appointments Yet! Book Your First Appointment Now</div>
            <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myPackageAppointmentsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-secondary" id="staticBackdropLabel">Your Package Appointments</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php 
                    require('db/database.php');
                    $res=mysqli_query($db,"SELECT id FROM `Users` WHERE Email='$_SESSION[login_user]';");
                    $user=$res->fetch_row()[0];

                    $res=mysqli_query($db,"SELECT id,package_id,appointment_time,appointment_date,message,status FROM `appointments` WHERE user_id='$user' and package_id is not NULL;");
                    $rowcount=mysqli_num_rows($res);
                    if($rowcount>0){ ?>
                    <div class="table-responsive">
                     <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">SrNo</th>
                                <th scope="col" class="text-center">Package Name</th>
                                <th scope="col" class="text-center">Appointment Time</th>
                                <th scope="col" class="text-center">Appointment Date</th>
                                <th scope="col" class="text-center">Message</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                    <?php
                    $i = 0;
                    while ($row = mysqli_fetch_assoc($res)){ $i++;
                        if($row['status'] == 0){
                            $row['status'] = "<button style='width:105px;' class='btn btn-warning'>Pending</button>";
                        }
                        else if($row['status'] == 1){
                            $row['status'] = "<button style='width:105px;' class='btn btn-success'>Approved</button>";
                        }
                        else if($row['status'] == 3){
                            $row['status'] = "<button style='width:105px;' class='btn btn-danger'>Declined</button>";
                        }
                        $res2=mysqli_query($db,"SELECT title FROM `packages` WHERE id='$row[package_id]';");
                        $package_name = $res2-> fetch_row();
                        $row['package_name'] = "Package (".$package_name[0].")";
                    ?>
                        <tr>
                        <th scope="row"><?=$i;?></th>
                        <td><?=$row['package_name']?></td>
                            <td class="text-center"><?=$row['appointment_time']?></td>
                            <td class="text-center"><?=date_format(date_create($row['appointment_date']),"d/M/Y")?></td>
                            <td class="text-center"><?=$row['message']?></td>
                            
                            <?php if($row['status'] == 2) {?>
                                <td class="text-center"><button class="btn btn-primary">Completed</button></td>
                                <td class="text-center"><a class="appointment_message" data-toggle="tooltip" data-placement="top" title="View Treatment" data-id="<?=$row['id']?>" ><i style="cursor:pointer;font-size:25px;color:black;" class="fa-solid fa-eye"></i></a></td>
                            <?php } else{?>
                            <td class="text-center"><?=$row['status']?></td>
                            <td><ul class="list-inline d-flex justify-content-center">
                                <a data-toggle="tooltip" data-placement="top" title="Delete Appointment"><i onclick="delete_appointment(this)" data-id="<?=$row['id'];?>" style="cursor:pointer;font-size:25px;" class="mx-2 fa-solid fa-trash delete_button"></i></a>
                            </ul></td>
                            <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                </table>
                </div>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Appointment Date</label>
                                    <input class="form-control" id="appointment_date" name="appointment_date" type="date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Appointment Time</label>
                                    <input class="form-control" id="appointment_time" name="appointment_time" type="time" required>
                                </div>
                            </div>
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
                    <form id="sign_up_form">
                        <div class="mb-3">
                            <label for="susername" class="form-label text-secondary">Username</label>
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
                            <img toggle="#spassword" src="./assets/img/eye-open.png" alt="" class="password-eye" style="width:25px;cursor:pointer;">
                        </div>
                        <div class="mb-3">
                            <label for="scpassword" class="form-label  text-secondary">Confirm Password</label>
                            <input name="scpassword" type="password" class="form-control" id="scpassword" required>
                            <img toggle="#scpassword" src="./assets/img/eye-open.png" alt="" class="password-eye" style="width:25px;cursor:pointer;">
                        </div>
                        <div>Already have an account <a href="#" data-bs-toggle="modal" data-bs-target="#Loginmodal">Login</a></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="sign_up_btn" class="btn btn-success">Sign Up</button>
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
                            <img toggle="#exampleInputPassword1" src="./assets/img/eye-open.png" alt="" class="password-eye" style="width:25px;cursor:pointer;">
                        </div>
                        <div>Dont have an account <a href="#" data-bs-toggle="modal" data-bs-target="#Signupmodal">Register</a></div>
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
                            <img class="img-fluid w-100" src="./admin/<?=$row['image_path']?>" alt="..." />
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
                                            <img class="card-img-top" src="./admin/<?=$row['image_path']?>" alt="Card image cap">
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
                                <button data-id="<?=$row['id']?>" data-image="./admin/<?=$row['image_path']?>" data-title="<?=$row['title']?>" data-desc="<?=$row['desc']?>" class="btn btn-success btn-xl text-uppercase book-packages" type="button">  
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
                            <img class="img-fluid w-100" src="./admin/<?=$row['image_path']?>" alt="..." />
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
                                            <img class="card-img-top" src="./admin/<?=$row['image_path']?>" alt="Card image cap">
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
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
    </section>
    <!-- About-->
    <section class="page-section py-4 bg-success bg-opacity-25" id="about">
        <div class="text-center my-3">
            <h2 class="section-heading text-uppercase">About Us</h2>
        </div>
        <div class="container-fluid px-5">
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="border-dark shadow-lg row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col-auto d-none d-lg-block">
                            <img src="./assets/img/ayurveda_about.jpeg" alt="" style="width:300px;height:200px;">
                        </div>
                        <div class="col p-4 d-flex flex-column position-static" data-aos="fade-right" data-aos-offset="250" data-aos-duration="700" data-aos-easing="ease-in-sine">
                            <strong class="d-inline-block mb-2 text-primary">About Ayurveda</strong>
                            <p class="card-text mb-auto">This is a wider card with supporting text below as a natural lead-in to additional content.
                            </p>
                            <a class="btn btn-success w-50" href="https://en.wikipedia.org/wiki/Ayurveda" target="_blank" class="stretched-link">Learn More</a>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="border-dark shadow-lg row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static" data-aos="fade-left" data-aos-offset="250" data-aos-duration="700" data-aos-easing="ease-in-sine">
                            <strong class="d-inline-block mb-2 text-success">About Doctor</strong>
                            <p class="mb-auto">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <svg class="bd-placeholder-img" width="300" height="200" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="true"><title>Placeholder</title><rect width="100%" height="100%" fill="green"></rect><text x="30%" y="50%" fill="#eceeef" dy=".3em">About Doctor</text></svg>
                        </div>
                    </div>
                </div>
            </div>
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
            <div id="map" class="mx-4 rounded" data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine">
                <iframe class="w-100 rounded" height="490" id="gmap_canvas"
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
                        <input class="form-control contact-input" id="contact_phone" type="number" placeholder="Your Phone *" name="contact_phone"/>
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
                            <form enctype="multipart/form-data" id="package_appointment_form">
                                <input type="hidden" id="package_id">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Appointment Date</label>
                                            <input class="form-control" id="package_appointment_date" name="appointment_date" type="date" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Appointment Time</label>
                                            <input class="form-control" id="package_appointment_time" name="appointment_time" type="time" required>
                                        </div>
                                    </div>
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


    <div class="modal fade" id="treatmentMessageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Your Treatments</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 id="message_modal"></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <button id="treatment_modal_toggler" data-bs-toggle="modal" data-bs-target="#treatmentMessageModal" class="d-none" type="button"></button>

<?php include './include/footer.php';?>
<script src="js/scripts.js"></script>
<script>
    $(document).ready(function() {
        // password eye toggle 
        $(".password-eye").click(function () {
            let src = this.getAttribute("src");
            if(src == "./assets/img/eye-open.png"){
                this.setAttribute("src","./assets/img/eye-close.png")
            }
            else{
                this.setAttribute("src","./assets/img/eye-open.png")
            }
            let input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
    });
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
            let appointment_date = document.getElementById("appointment_date").value;

            if(appointment_date == "" || appointment_date.length == 0){
                swal("Warning!","Please Select Appointment Date!","warning");
            }
            else if(appointment_time.value == ""){
                swal("Warning!","Please Select Appointment Time!","warning")
            }
            else if(appointment_message.value == ""){
                swal("Warning!","Please Select Message!","warning")
            }
            else{
                formData.append('normal_appointment',"normal_appointment_value")
                formData.append('appointment_date',appointment_date)
                formData.append('appointment_time',appointment_time.value)
                if(file.value != ""){
                    formData.append('file',file.value)
                }
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
            let formData = new FormData(package_appointment_form);
            let package_appointment_date = document.getElementById("package_appointment_date").value;

            if(package_appointment_date == "" || package_appointment_date.length == 0){
                swal("Warning!","Please Select Appointment Date!","warning");
            }
            else if(package_appointment_time.value == ""){
                swal("Warning!","Please Select Appointment Time!","warning");
            }
            else if(package_appointment_message.value == ""){
                swal("Warning!","Please Select Message!","warning")
            }
            else{
                if(package_file.value != ""){
                    formData.append('package_file',file.value)
                }
                formData.append('package_appointment_date',package_appointment_date)
                formData.append('package_appointment_time',package_appointment_time.value)
                formData.append('package_appointment_message',package_appointment_message.value)
                formData.append('package_id',package_id.value)
                let fetch_res = await fetch("index.php",{
                    method:"POST",
                    body:formData
                })
                let json_res = await fetch_res.json();
                if(json_res.status){
                    $(`#packages_appointment_modal`).modal('hide');
                    swal("Success!",json_res.message,"success").then(function(){
                        location.reload();
                    })
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
            else if(!isValidPhone(contact_phone.value)){
                swal("Warning!","Please Enter Valid Phone Number!","warning")
                sphone.focus();
            }

            else if(contact_email.value == ""){
                swal("Warning!","Please Enter Email!","warning")
                contact_email.focus();
            }

            else if(!validateEmail(contact_email.value)){
                swal("Warning!","Please Enter Valid Email!","warning")
                sEmail.focus();
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

        // Sign up functionality and validations 
        let sign_up_button = document.getElementById("sign_up_btn")
        sign_up_button.addEventListener("click",async function(e){
            // e.preventDefault();
            let sign_up_form = document.getElementById("sign_up_form")
            let formData = new FormData(sign_up_form);
            if(susername.value == ""){
                swal("Warning!","Please Enter Username!","warning")
                susername.focus();
            }
            if(susername.value.length < 3){
                swal("Warning!","Username Must Be At Least 4 Characters!","warning")
                susername.focus();
            }
            else if(sEmail.value == ""){
                swal("Warning!","Please Enter Email!","warning")
                sEmail.focus();
            }
            else if(!validateEmail(sEmail.value)){
                swal("Warning!","Please Enter Valid Email!","warning")
                sEmail.focus();
            }
            else if(sphone.value == ""){
                swal("Warning!","Please Enter Phone Number!","warning")
                sphone.focus();
            }
            else if(!isValidPhone(sphone.value)){
                swal("Warning!","Please Enter Valid Phone Number!","warning")
                sphone.focus();
            }
            else if(spassword.value == ""){
                swal("Warning!","Please Enter Password!","warning")
                spassword.focus();
            }
            else if(spassword.value.length<8){
                swal("Warning!","The Password Must Be at Least 8 Characters Long. Please Make Sure Your Password Meets This Requirement!","warning")
                spassword.focus();
            }
            else if(!checkPassword(spassword.value)){
                swal("Warning!","The Password Must Be at Least 8 Characters Long and Contain at Least One Lowercase Letter, One Uppercase Letter, One Digit, and One Special Character (!@#$%^&*). Please Make Sure Your Password Meets These Requirements!","warning")
                spassword.focus();
            }
            else if(spassword.value != scpassword.value){
                swal("Warning!","The Passwords Entered Do Not Match. Please Verify That You Have Entered the Same Password in Both Fields!","warning")
                spassword.focus();
            }
            else if(scpassword.value == ""){
                swal("Warning!","Please Enter Confirm Password!","warning")
                scpassword.focus();
            }
            else{
                formData.append('susername',susername.value)
                formData.append('sphone',sphone.value)
                formData.append('sEmail',sEmail.value)
                formData.append('spassword',spassword.value)
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
                    sign_up_form.reset();
                    login_button.click();
                }
                else{
                    swal("Error!",json_res.message,"error")
                }
            }
        })

    });
    function delete_appointment(element){
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then(async (willDelete) => {
            if (willDelete) {
                let formData = new FormData();
                let appointment_id = element.getAttribute("data-id")
                formData.append('delete_appointment_id',appointment_id)
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
                }
                else{
                    swal("Error!",json_res.message,"error")
                    document.getElementById("contactForm").reset();
                }
            }
        });
    }

    let view_treatment = document.querySelectorAll(".appointment_message")
    view_treatment.forEach(element => {
        element.addEventListener("click",async function(){
            let formData = new FormData();
            let id = this.getAttribute('data-id');
            formData.append('appointment_id',id)
            formData.append('treatment',id)
            let response = await fetch("index.php",{
                method:'post',
                body:formData
            })
            let json_res = await response.json();
            document.getElementById("message_modal").innerText = json_res.message;
            treatment_modal_toggler.click();
        })
    });

     // Phone Number Expression 
    function isValidPhone(p_number) {
        var phoneRe = /^[2-9]\d{2}[2-9]\d{2}\d{4}$/;
        var digits = p_number.replace(/\D/g, "");
        return phoneRe.test(digits);
    }

    // Email Address Expression
    const validateEmail = (email) => {
        return email.match(
            /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
    };

    // Password Expression 
    function checkPassword(password){
        let pattern = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
        return pattern.test(password);
    }

</script>
</body>