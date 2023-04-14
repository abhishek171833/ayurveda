<?php 
if(isset($_POST['desease_name'])){
    require('db/db.php');
    if(isset($_POST["image_file_input"])){
        $file_name = $_FILES['image_file_input']['name'];
        $file_size =$_FILES['image_file_input']['size'];
        $file_tmp =$_FILES['image_file_input']['tmp_name'];
        $file_type=$_FILES['image_file_input']['type'];
        
        $path = "./assets/img/deseases";
        if(!is_dir($path)){
            mkdir($path, 0777, true);
        }
        move_uploaded_file($file_tmp,"assets/img/deseases/".$file_name);
        $file_path_name = "assets/img/deseases/".$file_name;

        if(!empty($_POST['desease_id'])){
            $res = mysqli_query($db,"UPDATE `deseases` SET `image_path` = '$file_path_name'  WHERE `deseases`.`id` = $_POST[desease_id];");
        }
    }
    if(!empty($_POST['desease_id'])){
        $res = mysqli_query($db,"UPDATE `deseases` SET `title` = '$_POST[desease_name]', `description` = '$_POST[desease_description]'  WHERE `deseases`.`id` = $_POST[desease_id];");
        $message['message'] = "Desease Edited Successfully";
    }
    else{
        if(isset($_POST["image_file_input"])){
            $res = mysqli_query($db,"INSERT INTO `deseases` (`title`, `description`,`image_path`) VALUES ('$_POST[desease_name]', '$_POST[desease_description]','$file_path_name')");
        }
        else{
            $res = mysqli_query($db,"INSERT INTO `deseases` (`title`, `description`,`image_path`) VALUES ('$_POST[desease_name]', '$_POST[desease_description]','assets/img/home.jpg')");
        }
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
                    <h1 class="h3 mb-2 text-gray-800 text-center my-4"><?php if(isset($_GET["id"])){echo "Update Desease";}else{echo "Add Desease";}?></h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="container">
                                <form id="package_edit_form" enctype="multipart/form-data">
                                    <?php
                                    if(isset($_GET['id'])){
                                        require('db/db.php');
                                        $res=mysqli_query($db,"SELECT * FROM `deseases` WHERE id='$_GET[id]';");
                                        $desease=$res->fetch_row();
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="desease_name" class="form-label">Desease Name</label> 
                                            <input type="text" class="form-control" id="desease_name" value="<?php if(isset($desease)){echo $desease[1];}else{echo "";}?>">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="formFile" class="form-label">Desease Image File</label>
                                            <input class="form-control" type="file" id="image_file_input" style="height:unset;"  accept="image/*" name="image_file_input">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="desease_description" class="form-label">Desease Description</label>
                                            <textarea class="form-control" name="package_description" id="desease_description" cols="30" rows="4"><?php if(isset($desease)){echo $desease[2];}else{echo "";}?></textarea>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <img id="desease_img" src="<?php if(isset($desease)){echo $desease[3];}else{echo "../assets/img/home.jpg";}?>" alt="abhishek" style="width:250px;">
                                        </div>
                                        <div class="text-center col-md-12 mt-3">
                                            <button id="edit_desease_button" data-id="<?php if(isset($desease)){echo $desease[0];}else{echo "";}?>" type="submit" class="btn btn-primary"><?php if(isset($_GET["id"])){echo "Update Desease";}else{echo "Add Desease";}?></button>
                                        </div>
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
        $('document').ready(function () {
            $("#image_file_input").change(function () {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#desease_img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });

        document.getElementById("edit_desease_button").addEventListener("click",async function(e){
            e.preventDefault();
            let formData = new FormData(package_edit_form);
            let id = this.getAttribute("data-id");
            if(desease_name.value == ""){
                swal("Warning!","Please Enter Desease Name!","warning")
            }
            else if(desease_description.value == ""){
                swal("Warning!","Please Enter Deasese Description Number!","warning")
            }
            else{
                formData.append('desease_id',id)
                formData.append('desease_name',desease_name.value)
                formData.append('desease_description',desease_description.value)

                if(image_file_input.value != ""){
                    formData.append('image_file_input',image_file_input.value)
                }
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