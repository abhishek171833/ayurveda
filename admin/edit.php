<?php 
if(isset($_POST['package_name'])){
    require('db/db.php');
    if(!empty($_POST['package_id'])){
        $res = mysqli_query($db,"UPDATE `packages` SET `title` = '$_POST[package_name]', `desc` = '$_POST[package_description] ', `advantages` = '$_POST[package_advantages]' WHERE `packages`.`id` = $_POST[package_id];");
    }
    if($res){
        $message['message'] = "Package Edited Successfully";
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
        <?php include("./sidebar.php") ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include("./navbar.php") ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800 text-center my-4">Update Package</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="container">
                                <form id="package_edit_form">
                                    <?php 
                                    if(isset($_GET['id'])){
                                        require('db/db.php');
                                        $res=mysqli_query($db,"SELECT * FROM `packages` WHERE id='$_GET[id]';");
                                        $package=$res->fetch_row();
                                    }
                                    ?>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Package Name</label>
                                        <input type="text" class="form-control" id="package_name" value="<?php if(isset($package)){echo $package[1];}else{echo "";}?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Package Description</label>
                                        <textarea class="form-control" name="package_description" id="package_description" cols="30" rows="5"><?php if(isset($package)){echo $package[2];}else{echo "";}?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Package Advantages (add multiple advantages with comma seperated)</label>
                                        <textarea class="form-control" name="package_advantages" id="package_advantages" cols="30" rows="5"><?php if(isset($package)){echo $package[3];}else{echo "";}?></textarea>
                                    </div>
                                    <div class="text-center">
                                        <button id="edit_package_button" data-id="<?php if(isset($package)){echo $package[0];}else{echo "";}?>" type="submit" class="btn btn-primary">Update Package</button>
                                    </div>
                                </form>
                            </div>
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
        document.getElementById("edit_package_button").addEventListener("click",async function(e){
            e.preventDefault();
            let formData = new FormData();
            let id = this.getAttribute("data-id");
            if(package_name.value == ""){
                swal("Warning!","Please Enter Package Name!","warning")
                contact_name.focus();
            }
            else if(package_description.value == ""){
                swal("Warning!","Please Enter Phone Number!","warning")
                contact_phone.focus();
            }
            else if(package_advantages.value == ""){
                swal("Warning!","Please Enter Email!","warning")
                contact_email.focus();
            }
            else{
                formData.append('package_id',id)
                formData.append('package_name',package_name.value)
                formData.append('package_description',package_description.value)
                formData.append('package_advantages',package_advantages.value)
                let fetch_res = await fetch("edit.php",{
                    method:"POST",
                    body:formData
                })
                let json_res = await fetch_res.json();
                if(json_res.status){
                    swal("Success!",json_res.message,"success")
                    document.getElementById("package_edit_form").reset();
                    console.log("abhishek")
                    setTimeout(() => {
                        window.location.href = 'packages.php';
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