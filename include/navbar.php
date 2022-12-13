    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <img style="width:190px;cursor:pointer;" src="<?php echo'http://localhost/ayurveda/assets/img/navbar-logo.png'; ?>"/>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Treatment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#packages">Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Book Appointment</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <button id="login" data-bs-toggle="modal" data-bs-target="#Loginmodal"
                        class="mx-2 btn btn-outline-success" type="button">Login</button>
                    <button data-bs-toggle="modal" data-bs-target="#Signupmodal" class="mx-2 btn btn-outline-success"
                        type="button">Signup</button>
                </form>
            </div>
        </div>
    </nav>