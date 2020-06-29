<?php 
    include '../../config/config.php';

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
    <title id="page_title"></title>

    <!-- Custom fonts for this template -->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="/dist/css/main.min.css">

    <style>
        #add_result_content {
            display: none;
        }
    </style>
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
                    <button data-toggle="modal" data-target="#add_class_exam" class="btn btn-primary btn-sm"
                        id="add_result"><span><i class="fas fa-user-graduate"></i></span>
                        Add Results
                    </button>
                </div>

                <nav aria-label="breadcrumb mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="/class/class.php">Class</a></li>
                        <li class="breadcrumb-item"><a id="class_name" href="./view_class/"></a></li>

                        <li class="breadcrumb-item active" id="class_exam" aria-current="page"></li>
                    </ol>
                </nav>

                <!-- Content Row -->
                <div class="row">

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Average
                                            Performance</div>
                                        <div id="avg_performance" class="h5 mb-0 font-weight-bold text-gray-800">200
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-graduate fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-8 mb-1">
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
                    </div>
                </div>

                <div class="row">
                    <div id="main_content" class="col-xl-12 col-md-12 mb-1">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary"> <span><i
                                            class="fas fa-user-graduate"></i></span> All Results</h6>
                                <div class="dropdown no-arrow">

                                    <button class="btn btn-primary btn-sm" id="print_class_result">
                                        <span><i class="fas fa-print"></i></span>
                                        Print Result
                                    </button>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-condensed table-striped" id="class_exam_student_table"
                                        width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Adm#</th>
                                                <th>Total Score</th>
                                                <th>MeanScore</th>
                                                <th>Grade</th>
                                                <th>Subjects</th>
                                                <th>Approved</th>
                                                <th>Position</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">

                    <div class="col-xl-7 col-md-7 mb-1">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    Exam Subject Performance
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-condensed table-striped" id="class_exam_subject_table"
                                        width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
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
            <!-- /.container-fluid -->

            <?php include '../../layouts/footer.php'; ?>
        </div>

        <?php include '../../layouts/utils/logout_modal.html';?>

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
                                    <label for="class">Choose A Class:</label>
                                    <select name="class" class="form-control clid" id="class"
                                        onClick="getStudent(this.value);">
                                    </select>
                                </div>

                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="class_exam_id">Choose Exam:</label>
                                    <select name="class_exam_id" class="form-control class_exam_id" id="class_exam_id">
                                    </select>
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="studentid">Select Student: </label>
                                    <select name="studentid" class="form-control stid" id="studentid"
                                        onChange="getresult(this.value);">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <div id="reslt">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div id="subject" class="col-sm-4 mb-3 mb-sm-0">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button class="btn btn-primary" id="submit" name="submit"
                                        type="submit">Save</button>
                                    <button data-dismiss="modal" class="btn btn-warning"><i class="icon-cross"></i>
                                        Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="/dist/js/main.min.js"></script>
        <script src="/dist/js/classes/class_exam.js"> </script>


</body>

</html>

<?php } ?>