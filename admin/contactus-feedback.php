<?php 
    session_start();
    if(!isset($_SESSION['login_admin'])){
        header('Location: login.php');
    }
?>
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
                    <h1 class="h3 mb-2 text-gray-800 my-4">Contact us messages</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">All queries from contact us form</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Id</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Phone No</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center" style="width:90px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        require('db/db.php');
                                        $res=mysqli_query($db,"SELECT * FROM `contact`");
                                        while ($row = mysqli_fetch_assoc($res)){ 
                                        $date = date_create($row['datetime']);
                                        $date =  date_format($date,"Y/M/d");

                                        ?>
                                            <tr>
                                            <td class="text-center"><?=$row['id']?></td>
                                            <td class="text-center"><?=$row['name']?></td>
                                            <td class="text-center"><?=$row['email']?></td>
                                            <td class="text-center"><?=$row['phone_no']?></td>
                                            <td class="text-center"><?=$date?></td>
                                            <td class="text-center"><a class="message" data-message="<?=$row['message']?>" data-toggle="tooltip" data-placement="top" title="View Message" ><i style="cursor:pointer;font-size:25px;" class="fa-solid fa-eye"></i></a></td>
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

    <!-- Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Contact us message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 id="message_modal"></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        $(document).ready(function() {
            $("body").tooltip({ selector: '[data-toggle=tooltip]' });
        });

        const select_box = document.querySelectorAll(".message");
        select_box.forEach(element => {
            element.addEventListener("click",async function(e){
                let message = this.getAttribute("data-message");
                document.getElementById("message_modal").innerText = message;
                $("#messageModal").modal()
            })
        });
    </script>
</body>

</html>