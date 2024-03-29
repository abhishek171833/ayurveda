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
                        <li class="nav-item rounded bg-success"><a class="nav-link text-white" href="#Appointment"  data-bs-toggle="modal" data-bs-target="#Appointment">Book Appointment</a></li>
                    </ul>               
                    <form class="d-flex" role="search" style="position:absolute;right:0;">
                    <?php 
                    // session_start();
                    if(isset($_SESSION['login_user'])){?>
                        <a href="./include/logout.php" class="mx-2 btn btn-success" type="button">Logout</a>
                    <?php } else{ ?>
                        <button id="login" data-bs-toggle="modal" data-bs-target="#Loginmodal"
                            class="mx-2 btn btn-success" type="button">Login</button>
                        <button data-bs-toggle="modal" data-bs-target="#Signupmodal" class="mx-2 btn btn-success"
                            type="button">Signup</button>
                    <?php }?>
                     </form>

                </div>
            </div>
        </nav>