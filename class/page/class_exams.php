<?php

include '../../config/config.php';
include "../../layouts/utils/redirect.php";

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500 || !isset($_SESSION['role_id'])){
    redirectToHomePage();
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
    <title id="page_title"></title>

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
                    <h1 class="h3 mb-0 text-gray-800" id="heading"> </h1>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button data-toggle="modal" data-target="#add_class_exam" class="btn btn-outline-primary btn-xs"
                            id="add_result"><span><i class="fas fa-user-graduate"></i></span>
                            Add Results
                        </button>
                        <button class="btn btn-primary btn-xs" id="print_class_result">
                            <span><i class="fas fa-print"></i></span>
                            Print Class Exam Results
                        </button>
                        <button class="btn btn-outline-primary btn-xs" id="print_subject_results">
                            <span><i class="fas fa-file-pdf"></i></span>
                            Print Subject Results
                        </button>
                    </div>

                </div>

                <div class="d-sm-flex align-items-center justify-content-between mb-2">
                    <h4 class="h5 mb-0 ">Total Result Declared: <span>
                            <i class="text-gray-800" id="total_students_sat_for_exam"></i>
                        </span>
                    </h4>
                    <h4 class="h2 mb-0 text-success" id="exam_flag"> </h4>
                </div>
                <div class="d-sm-flex align-items-center justify-content-between mb-2">
                    <h4 class="h5 mb-0 ">Best Performed Subject: <span><i id="best_performed_subject"
                                class="text-gray-800 "></i> ~ Subject Teacher: <a href=""><i
                                    id="subject_teacher"></i></a> </span>
                    </h4>
                    <h4 class="h5 mb-0 ">Best Performed Student:
                        <span><a href=""> <i id="best_performed_student"></i> </a></span>
                    </h4>
                </div>
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h4 class="h5 mb-0 ">Academic Year: <span><i id="academic_year" class="text-gray-800 "></i> </span>
                    </h4>

                </div>

                <hr>
                <div id="alert"></div>

                <nav aria-label="breadcrumb mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index">Home</a></li>
                        <li class="breadcrumb-item"><a href="/class/class">Stream</a></li>
                        <li class="breadcrumb-item"><a id="class_name_navbar_link" href=""></a></li>

                        <li class="breadcrumb-item active" id="class_exam_active" aria-current="page"></li>
                    </ol>
                </nav>
                <hr>
                <nav class="mb-4">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                            role="tab" aria-controls="nav-home" aria-selected="true"> <span><i
                                    class="fas fa-chalkboard "></i></span> Students Performance </a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                            role="tab" aria-controls="nav-profile" aria-selected="false"> <span><i
                                    class="fas fa-users"></i></span> Subject Performance</a>
                    </div>
                </nav>

                <!-- Content Row -->
                <div class="row">

                    <div class="col-lg-12 mb-4">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                aria-labelledby="nav-home-tab">

                                <div class="card mb-3">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary"> 
                                            <span><i class="fas fa-user-graduate"></i></span>
                                            Students Performance Chart</h6>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="students_chart" height="60"></canvas>
                                    </div>
                                </div>

                                <div class="card shadow ">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary"> <span><i
                                                    class="fas fa-user-graduate"></i></span> All Results</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-condensed table-striped"
                                                id="class_exam_student_table" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Position</th>
                                                        <th>Student Name</th>
                                                        <th>Adm#</th>
                                                        <th>Date Added</th>
                                                        <th>MeanScore</th>
                                                        <th>Grade</th>
                                                        <th>Subjects</th>
                                                        <th>Total Score</th>

                                                        <th>Action</th>
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
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">
                                            <span><i class="fas fa-chart-bar"></i></span>
                                            Exam Subject Perfomance Chart.
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="chart" height="60"></canvas>
                                    </div>
                                </div>
                                <div class="card shadow mb-4">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">
                                            Exam Subject Performance
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-condensed table-striped"
                                                id="class_exam_subject_table" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Subject Name</th>
                                                        <th>Subject Teacher</th>
                                                        <th>Total Score</th>
                                                        <th>Average(1dp)</th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="btn-group mb-4" role="group" aria-label="Basic example">
                    <button id="lock_exam" class="btn btn-md btn-outline-primary">Lock</button>
                    <button class="btn btn-md btn-primary">Lock and Print Exam Report</button>
                </div>
                <!-- /.container-fluid -->



            </div>
            <?php include '../../layouts/footer.php'; ?>

            <!-- Exam Modal-->
            <div class="modal fade" id="add_class_exam" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="exam_modal" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-primary" id="exam_modal">
                                <span><i class="fas fa-user-graduate"></i> Add Student Result</span></h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body">

                            <form class="user" id="result_form">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="class">Class To be Assign Result:</label>
                                        <select disabled name="class" class="form-control clid" id="class">
                                        </select>
                                    </div>

                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="class_exam_id">Result for this Exam:</label>
                                        <select disabled name="class_exam_id" class="form-control class_exam_id"
                                            id="class_exam_id">
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="studentid">Select Student: </label>
                                        <select name="studentid" class="form-control stid" id="studentid"
                                            onChange="getresult(this.value);">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div id="reslt">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div id="subject" class="col-sm-12 mb-2 mb-sm-0">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button class="btn btn-primary" id="submit" name="submit"
                                            type="submit">Save</button>
                                        <button data-dismiss="modal" class="btn btn-danger"><i class="icon-cross"></i>
                                            Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include '../../layouts/utils/logout_modal.html';?>

            <script src="/dist/js/main.min.js"></script>
            <script src="/dist/js/classes/class_exam.js"> </script>
            <script src="/dist/js/utils/utils.js"></script>

</body>

</html>

<?php } ?>