<?php 
if(isset($_POST['desease_name'])){
    require('db/db.php');
    if(!empty($_POST['desease_id'])){
        $res = mysqli_query($db,"UPDATE `deseases` SET `title` = '$_POST[desease_name]', `description` = '$_POST[desease_description]'  WHERE `deseases`.`id` = $_POST[desease_id];");
        $message['message'] = "Desease Edited Successfully";
    }
    else{
        $res = mysqli_query($db,"INSERT INTO `deseases` (`title`, `description`, `image_path`) VALUES ('$_POST[desease_name]', '$_POST[desease_description]','image_path')");
        $message['message'] = "Desease Added Successfully";
    }
    if($res){
        $message['status'] = 1;
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

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Dashboard - Ayurveda</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3">Ayurveda Admin Panel</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="./packages.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Packages</span></a>
            </li>
            <hr class="sidebar-divider">

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="deseases.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Deseases</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Ayurveda Admin</span>
                                <img class="img-profile rounded-circle"
                                    src="img/admin.png">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800 text-center my-4"><?php if(isset($_GET["id"])){echo "Update Desease";}else{echo "Add Desease";}?></h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="container">
                                <form id="package_edit_form">
                                    <?php
                                    if(isset($_GET['id'])){
                                        require('db/db.php');
                                        $res=mysqli_query($db,"SELECT * FROM `deseases` WHERE id='$_GET[id]';");
                                        $desease=$res->fetch_row();
                                    }
                                    ?>
                                    <div class="mb-3">
                                        <label for="desease_name" class="form-label">Desease Name</label>
                                        <input type="text" class="form-control" id="desease_name" value="<?php if(isset($desease)){echo $desease[1];}else{echo "";}?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="desease_description" class="form-label">Desease Description</label>
                                        <textarea class="form-control" name="package_description" id="desease_description" cols="30" rows="5"><?php if(isset($desease)){echo $desease[2];}else{echo "";}?></textarea>
                                    </div>
                                    </div>
                                    <div class="text-center">
                                        <button id="edit_desease_button" data-id="<?php if(isset($desease)){echo $desease[0];}else{echo "";}?>" type="submit" class="btn btn-primary"><?php if(isset($_GET["id"])){echo "Update Desease";}else{echo "Add Desease";}?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <!-- /.container-fluid -->

                </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
     <script>
        document.getElementById("edit_desease_button").addEventListener("click",async function(e){
            e.preventDefault();
            let formData = new FormData();
            let id = this.getAttribute("data-id");
            if(desease_name.value == ""){
                swal("Warning!","Please Enter Desease Name!","warning")
                contact_name.focus();
            }
            else if(desease_description.value == ""){
                swal("Warning!","Please Enter Deasese Description Number!","warning")
                contact_phone.focus();
            }
            else{
                formData.append('desease_id',id)
                formData.append('desease_name',desease_name.value)
                formData.append('desease_description',desease_description.value)
                let fetch_res = await fetch("desease_edit.php",{
                    method:"POST",
                    body:formData
                })
                let json_res = await fetch_res.json();
                if(json_res.status){
                    swal("Success!",json_res.message,"success")
                    document.getElementById("package_edit_form").reset();
                    setTimeout(() => {
                        window.location.href = 'deseases.php';
                    }, 2000);
                }
                else{
                    swal("Error!",json_res.message,"error")
                    document.getElementById("package_edit_form").reset();
                }
            }
        })
    </script>

</body>

</html>