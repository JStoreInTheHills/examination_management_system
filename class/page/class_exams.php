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
    <title>Class || Exam Performance</title>

    <!-- Custom fonts for this template -->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->

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
                    <h1 class="h3 mb-0 text-gray-800"> Class Exam Performance </h1>
                    <a href="#" data-toggle="modal" data-target="#add_class_exam"
                        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i>Tools</a>
                </div>

                <!-- Content Row -->
                <div class="row">


                    <div class="col-xl-6 col-md-6 mb-3">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-condensed table-striped" id="class_exam_subject_table" width="100%"
                                        cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Subject Name</th>
                                                <th>Total Subject Score</th>
                                                <th>Average (1dp)</th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8 col-md-8 mb-2">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-condensed table-striped" id="class_exam_student_table" width="100%"
                                        cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Total Score</th>
                                                <th>MeanScore</th>
                                                <th>Grade</th>
                                                <th>Action</th>
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
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/classes/class_exam.js"> </script>


</body>

</html>