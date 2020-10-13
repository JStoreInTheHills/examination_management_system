<?php

session_start();

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500 || !isset($_SESSION['role_id'])){
    header("Location: /login.php");
    exit;
  }else{
      $_SESSION['last_login_timestamp'] = time();
  ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="academic_title"></title>

    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="/dist/css/main.min.css" rel="stylesheet">
</head>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include "../../layouts/sidebar.php"; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include '../../layouts/topbar.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">


                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 id="heading" class="h3 mb-0 text-gray-800"></h1>
                    </div>

                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="/academic_year/year.php">Academic Year</a></li>
                            <li id="bread_list" class="breadcrumb-item"></li>
                            <li id="bread_list2" class="breadcrumb-item active" aria-current="page"></li>
                        </ol>
                    </nav>

                    <!-- start of row -->
                    <div class="row">

                        <div class="col-lg-8">
                            <div class="card shadow mb-4">
                                <div class="card-header text-primary">
                                    All Exams for the Academic Period
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" width="100%" cellspacing="0" id="table">
                                            <thead>
                                                <tr>
                                                    <th>Exam Name</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!------------------------------------------------------------------------------------------------->

                        <div class="col-lg-8">
                            <div class="card shadow mb-4">
                                <div class="card-header text-primary">
                                    End Year Result Students Table
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="class_academic_table">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Admission #</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- endo of row -->


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/years/view_class_academic_year_performance.js"></script>
</body>

</html>

<?php }?>