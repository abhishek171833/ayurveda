<style>
    .sidebar .nav-item .nav-link[data-toggle=collapse]::after {
        font-family: 'Font Awesome 5 Free';
    }
    #content_container{
        height:75vh;
        overflow-y:scroll;
    }
</style>
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

    <!-- Nav Item - Pages Collapse Menu -->

    <!-- Nav Item - Charts -->
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
    <hr class="sidebar-divider">


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-table"></i>
            <span>Appointments</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="./normalAppointments.php">Normal</a>
                <a class="collapse-item" href="./packageAppointments.php">Package</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <li class="nav-item">
        <a class="nav-link" href="contactus-feedback.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Contact Us Feedback</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>