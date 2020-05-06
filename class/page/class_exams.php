<?php 
    include '../../config/config.php';
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
                    <a href="#" data-toggle="modal" data-target="#add_class_exam"
                        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i>Tools</a>
                </div>

                <!-- Content Row -->
                <div class="row">


                    <div class="col-xl-12 col-md-8 mb-1">
                        <!-- Custom Text Color Utilities -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    Exam Subject Perfomance Chart.
                                </h6>
                            </div>
                            <div class="card-body">
                                <canvas id="chart" height="60"></canvas>
                            </div>
                        </div>

                        <div class="card-shadow-mb-4"></div>
                    </div>

                    <div id="main_content" class="col-xl-8 col-md-8 mb-1">
                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-prima">All Results</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-primary"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Tools:</div>
                                        <a class="dropdown-item" href="" id="add_result">Add Results</a>
                                    </div>
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="add_result_content" class="col-xl-8 col-md-8 mb-1">
                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold">Add Results</h6>
                            </div>
                            <div class="card-body">
                                <form class="user" id="result_form">
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select name="class" class="form-control clid" id="class"
                                                onClick="getStudent(this.value);">
                                            </select>
                                        </div>

                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select name="class_exam_id" class="form-control class_exam_id"
                                                id="class_exam_id">
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
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

                                    <div class="btn-group">
                                        <button class="btn btn-primary" id="submit" name="submit"
                                            type="submit">Save</button>
                                        <button id="cancel_form" class="btn btn-warning"><i class="icon-cross"></i>
                                            Close</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
                <div class="row">

                    <div class="col-xl-8 col-md-8 mb-1">
                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold">Subject Performance</h6>
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

            <?php include '../../layouts/footer.php'; ?>
        </div>

        <?php include '../../layouts/utils/logout_modal.html';?>


        <script src="/dist/js/main.min.js"></script>
        <script src="/dist/js/classes/class_exam.js"> </script>


</body>

</html>