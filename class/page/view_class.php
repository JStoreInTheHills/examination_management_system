<?php include '../../config/config.php';

session_start();

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 900){
    header("Location: /login.php");
    exit;
}else{
      $_SESSION['last_login_timestamp'] = time();
  ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title id="title"></title>

    <!-- Custom fonts for this template -->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="/dist/css/main.min.css">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include "./../../layouts/sidebar.php"; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <?php include './../../layouts/topbar.php' ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">


                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800" id="heading">Manage ~ </h1>
                    <div class="dropdown no-arrow">
                        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm dropdown-toggle"
                            type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <span> <i class="fas fa-plus"></i> </span> Quick Add
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <div class="dropdown-header">Tools:</div>
                            <div class="dropdown-divider"></div>

                            <a href="#" data-toggle="modal" data-target="#add_class_exam" class="dropdown-item">
                                <span><i class="fas fa-users"></i> </span> Add Class Exam</a>

                            <a href="./add_subject_to_class.php" target="_blank" class="dropdown-item">
                                <span><i class="fas fa-certificate"></i> </span> Add Subject To Class</a>

                            <a href="/students/student.php" target="_blank" class="dropdown-item">
                                <span><i class="fas fa-users"></i> </span> Add Students To Class</a>
                        </div>
                    </div>
                </div>

                <nav aria-label="breadcrumb mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="/class/class.php">Classes</a></li>
                        <li id="bread_list" class="breadcrumb-item active" aria-current="page"></li>
                    </ol>
                </nav>


                <div class="row">
                    <!-- Result Declared -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Result
                                            Declared(Students)
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="result_declared_count">
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-map fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Students -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Students
                                        </div>
                                        <a class="h5 mb-0 font-weight-bold text-gray-800" href="#view_class_student"
                                            id="total_students_in_class"></a>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Exams Declared -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Exams
                                        </div>
                                        <a class="h5 mb-0 font-weight-bold text-gray-800" id="total_exams_in_class"></a>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-edit fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subjects Declared -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Subjects
                                        </div>
                                        <a class="h5 mb-0 font-weight-bold text-gray-800"
                                            id="total_subjects_in_class"></a>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-graduate fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row">

                <div class="col-xl-8 col-md-7 mb-2">
                        <div class="card shadow mb-2">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">All Class Exams</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="view_class" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Exam Name</th>
                                                <th>Exam Period</th>
                                                <th>Published At</th>
                                                <th class="text-center sorting_disabled" aria-label="Actions">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Donut Chart -->
                    <div class="col-xl-4 col-md-5">
                        <div class="card shadow mb-2">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Female : Male ~ Students ratio</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-2">
                                    <canvas id="myPieChart" width="200" height="200"></canvas>
                                </div>
                                <hr>
                                <span class="text-primary">Shows ratio of female to male students</span>
                            </div>
                        </div>
                    </div>

                    <!-- Exam DataTales -->

                </div>

                <div class="row">

                    <!-- Student DataTales -->
                    <div class="col-xl-12 col-md-12 mb-4">
                        <div class="card mb-4 shadow">
                            <div class="card-header text-primary">
                                <span><i class="fas fa-users"></i></span>
                                Class Students
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="view_class_student" width="100%"
                                        cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>RollId</th>
                                                <th>Reg Date</th>
                                                <th>DOB</th>
                                                <th>Gender</th>
                                                <th>Status</th>
                                                <th class="text-center sorting_disabled" rowspan="1" colspan="1"
                                                    aria-label="Actions">Actions</th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subject DataTales -->
                    <div class="col-xl-8 col-md-7 mb-2">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="view_class_subjects" width="100%"
                                        cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Subject Name</th>
                                                <th>Subject Code</th>
                                                <th>Subject Teacher</th>
                                                <th>Status</th>
                                                <th class="text-center" aria-label="Actions">Actions</th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>


            </div>

            <?php include './../../layouts/footer.php' ?>

        </div>
        <!-- /.container-fluid -->
    </div>

    <?php include '../../layouts/utils/logout_modal.html'; ?>

    <!-- Exam Modal-->
    <div class="modal fade" id="add_class_exam" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exam_modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-gray-800" id="exam_modal">
                        <span><i class="fas fa-users"></i></span> Add Exam To Class</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form id="view_class_form" class="user">
                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <label for="exam_id">Choose an Exam:</label>
                                <select name="exam_id" id="exam_id" class="form-control ">
                                    <?php
                                                    $sql = "SELECT exam_id, exam_name from exam";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    if ($query->rowCount() > 0) {
                                                        foreach ($results as $result) {   ?>
                                    <option value="<?php echo htmlentities($result->exam_id); ?>">
                                        <?php echo htmlentities($result->exam_name); ?>
                                    </option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <label for="exam_id">Choose The Appropriate Exam Year:</label>
                                <select name="year_id" id="year_id" class="form-control ">
                                    <?php
                                                    $sql = "SELECT year_id, year_name from year";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    if ($query->rowCount() > 0) {
                                                        foreach ($results as $result) {   ?>
                                    <option value="<?php echo htmlentities($result->year_id); ?>">
                                        <?php echo htmlentities($result->year_name); ?>
                                    </option>
                                    <?php }
                                                    } ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" id="view_class_submit">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/classes/view_class.js"></script>
</body>

</html>

<?php } ?>