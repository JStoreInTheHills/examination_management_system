<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/index.php">
        <div class="sidebar-brand-icon">
            <i class="fas  fa-user-graduate"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Munawarah</div>
    </a>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Navigation
    </div>


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="/academic_year/year.php" >
            <i class="fas fa-poll-h"></i>
            <span>Academic Year</span>
        </a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="/stream/stream.php">
            <i class="fas fa-book-reader"></i>
            <span>Classes</span>
        </a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClasses"
            aria-expanded="true" aria-controls="collapseClasses">
            <i class="fas fa-glasses"></i>
            <span>Streams</span>
        </a>
        <div id="collapseClasses" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Setup:</h6>
                <a class="collapse-item" href="/class/class.php"> Manage Streams</a>
                <a class="collapse-item" href="/class/page/add_subject_to_class.php"> Add Subject to Stream</a>
            </div>
        </div>
    </li>

       <!-- Nav Item - Pages Collapse Menu -->
       <li class="nav-item">
        <a class="nav-link collapsed" href="/subjects/subject.php">
            <i class="fas fa-street-view"></i>
            <span>Subjects</span>
        </a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="/students/student.php">
            <i class="fas fa-user-graduate"></i>
            <span>Students</span>
        </a>
    </li>

    <!-- Nav Item - Utilities Teachers Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="/teachers/teachers.php">
            <i class="fas fa-users"></i>
            <span>Teachers</span>
        </a>
      </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="/exam/exam.php">
            <i class="fas fa-user-edit"></i>
            <span>Exams</span>
        </a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="/results/results.php">
            <i class="fas fa-poll-h"></i>
            <span>Results</span>
        </a>
    </li>


    <!-- Nav Item - Utilities Reports Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="/reports/reports.php">
            <i class="fas fa-certificate"></i>
            <span>Reports</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Heading -->
    <div class="sidebar-heading">
        Settings and Preferences
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings"
            aria-expanded="true" aria-controls="collapseSettings">
            <i class="fas fa-toolbox"></i>
            <span>Setup</span>
        </a>
        <div id="collapseSettings" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Settings:</h6>
                <a class="collapse-item" href="/counties/counties.php">Counties</a>
                <a class="collapse-item" href="/admin/pages/new_user.php">Add System User</a>
                <a class="collapse-item">Grading <span style="color:blue">(Coming Soon)</span></a>
                <a class="collapse-item">Imports <span style="color:blue">(Coming Soon)</span></a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item">
        <a class="nav-link" href="/log_file.php">
            <i class="fas fa-address-book"></i>
            <span>Logs</span></a>
    </li>
</ul>
<!-- End of Sidebar -->
