<?php include '../../config/config.php';

session_start();

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 900){
    header("Location: /login.php");
    exit;
}else{
      $_SESSION['last_login_timestamp'] = time();
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title id=title></title>

    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="/dist/css/main.min.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php  
            if(isset($_SESSION['role_id'])){
                include "../layouts/sidebar.php"; 
            }
         ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include './../../layouts/topbar.php' ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800" id="heading"> </h1>

                        <div class="btn-group">
                            <button class="btn btn-outline-primary btn-md" id="edit_students">
                            </button>

                            <?php
                                if(isset($_SESSION['role_id'])){
                                    echo  "<button class='btn btn-primary btn-md id='makeStudentInactive'>
                                                Make Student Inactive
                                          </button>";
                                }
                                
                            ?>
                        </div>
                        
                    </div>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Use this page to view name, admission number and class of the students.</strong>
                        <hr>
                            <p class="mb-0">Active students are denoted by <span class="badge badge-pill badge-success">Active</span> while In Active students are denoted by <span class="badge badge-pill badge-danger">Inactive</span> </p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <nav class="mb-4">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home" aria-selected="true"> <span><i class="fas fa-user-graduate"></i></span> Students Performance</a>
                            <!-- <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                role="tab" aria-controls="nav-profile" aria-selected="false"> <span><i class="fas fa-chalkboard"></i></span>  Exams</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                                role="tab" aria-controls="nav-contact" aria-selected="false"> <span><i class="fas fa-address-book"></i></span>  Contact</a>
                            -->
                        </div>
                    </nav>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    <!-- Area Chart -->
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary"><span><i class="fas fa-user-graduate"></i></span>  Students Performance Curve
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-area">
                                                <canvas id="myAreaChart"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bar Graph -->
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">
                                                <span><i class="fas fa-users"></i></span> Overall Exam Performance</h6>
                                        </div>
                                        <div class="card-body">
                                        <div class="table-responsive">
                                                <table class="table table-striped " id="overrall_exam_table" width="100%"
                                                    cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Exam Name</th>
                                                            <th>Total Marks</th>
                                                            <th>Grade</th>
                                                            <th>Year</th>
                                                        </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="mx font-weight-bold text-primary">Exams</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped " id="dataTable" width="100%"
                                                    cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>RollId</th>
                                                            <th>Reg Date</th>
                                                            <th>Class</th>
                                                            <th>Age</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                                    aria-labelledby="nav-contact-tab">...</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!--Students Details -->
                            <div class="card mb-2">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><span><i class="fas fa-user"></i></span>  Students Details</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li id="students_name" class="list-group-item">Name:</li>
                                        <li id="RollId" class="list-group-item">Admission Number:</li>
                                        <li id="age" class="list-group-item">Age:</li>
                                        <li id="Gender" class="list-group-item">Gender:</li>
                                        <li id="DOB" class="list-group-item">Date of Birth:</li>
                                        <li id="status" class="list-group-item">Status</li>
                                        <li id="RegDate" class="list-group-item">Date of Registration:</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Class Details</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li id="class_name" class="list-group-item">Class Name:</li>
                                        <li id="stream_name" class="list-group-item">Stream Name:</li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include './../../layouts/footer.php' ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php include '../../layouts/utils/logout_modal.html'; ?>

    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/students/student_details.js"></script>
    <!-- <script src="/src/js/demo/chart-bar-demo.js"></script> -->
    <script src="/dist/js/utils/utils.js"></script>
</body>

</html>
<?php } ?>