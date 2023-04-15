<?php
  if(isset($_POST['status'])){
    require('./db/db.php');
    $res=mysqli_query($db,"UPDATE `appointments` SET `status` = '$_POST[status]' WHERE `appointments`.`id` = $_POST[id];");
    
    if($res){
        $message['status'] = 1;
        $message['message'] = "Appointment Status Changed Successfully";
        echo json_encode($message);
        exit();
    }
    else{
        $message['status'] = 0;
        $message['message'] = "Something went wrong";
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
    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
                <div class="container-fluid" id="content_container">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800 my-4">Normal Appointments</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">All Normal Appointments</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>User</th>
                                            <th>Appointment Message</th>
                                            <th>Appointment Time</th>
                                            <th>Appointment Date</th>
                                            <th>Attachments</th>
                                            <th style="width:90px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        require('db/db.php');
                                        $res=mysqli_query($db,"SELECT * FROM `appointments` where package_id is NULL");
                                        while ($row = mysqli_fetch_assoc($res)){ 
                                        $date = date_create($row['appointment_time']);
                                        $date =  date_format($date,"d/M/Y");

                                        $res2=mysqli_query($db,"SELECT name FROM `Users` WHERE id='$row[user_id]';");
                                        $user=$res2->fetch_row()[0];
                                        if($row['file_name'] != NULL){
                                            $res3=mysqli_query($db,"SELECT id FROM `Users` WHERE id='$row[user_id]';");
                                            $user_file = $res3->fetch_row()[0];
                                            $file = "<a href='../appointments/$user_file/$row[file_name]' download='$row[file_name]'><i style='font-size:25px;cursor:pointer;' class='fa-solid fa-download'></i></a>";
                                        }
                                        else{
                                            $file = "No Attachments";
                                        }
                                        ?>
                                            <tr>
                                            <td><?=$row['id']?></td>
                                            <td><?=$user?></td>
                                            <td><?=$row['message']?></td>
                                            <td><?=$row['appointment_time']?></td>
                                            <td><?=$date?></td>
                                            <td class="text-center"><?=$file?></td>
                                            <td> <select class="form-control normal_appointment_action" data-id="<?=$row['id']?>">
                                                <option <?php if($row['status'] == 0 ) echo "selected";?> value="0">Pending</option>
                                                <option <?php if($row['status'] == 1 ) echo "selected";?> value="1">Approve</option>
                                                <option <?php if($row['status'] == 2 ) echo "selected";?> value="2">Complete</option>
                                                <option <?php if($row['status'] == 3 ) echo "selected";?> value="3">Decline</option>
                                            </select></td>
                                        </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>
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
        const select_box = document.querySelectorAll(".normal_appointment_action");
        select_box.forEach(element => {
            element.addEventListener("change",async function(e){
                let formData = new FormData();
                let status = this.value
                let id = this.getAttribute("data-id");
                formData.append("status",status)
                formData.append("id",id)
                let response = await fetch("normalAppointments.php",{
                    method:'post',
                    body:formData
                })
                let json_res = await response.json();
                if(json_res.status){
                    swal('Success!',json_res.message,'success').then(function(){
                        location.reload();
                    })
                }
                else{
                    swal('Error!',json_res.message,'error')
                }
            })
        });
    </script>
</body>

</html>