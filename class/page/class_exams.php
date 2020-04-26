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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

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
                    <a href="#" data-toggle="modal" data-target="#add_class_exam" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add Class Exam</a>
                </div>


                <div class="row">

                            <div class="col-xl-8 col-lg-7">

                                <!-- Bar Chart -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Subject Performance</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-bar">
                                            <canvas id="myBarChart"></canvas>
                                        </div>
                                        <hr>
                                    </div>
                                </div>

                            </div>

                             <!-- Pie Chart -->
                            <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Dropdown Header:</div>
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <canvas id="myPieChart"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                    <span class="mr-2">
                                    <i class="fas fa-circle text-primary"></i> Direct
                                    </span>
                                    <span class="mr-2">
                                    <i class="fas fa-circle text-success"></i> Social
                                    </span>
                                    <span class="mr-2">
                                    <i class="fas fa-circle text-info"></i> Referral
                                    </span>
                                </div>
                                </div>
                            </div>
                            </div>
                                </div>
               
                <!-- End of Row -->

                  <!-- DataTales Example -->
                  <div id="main_content" class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">All Results</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Tools:</div>
                                    <a class="dropdown-item" id="add_result" href="#">Add Results</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="class_exam_result_table" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Admission #</th>
                                        <th>Class Name</th>
                                        <th>Marks</th>
                                        <th>Grade</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Admission #</th>
                                        <th>Class Name</th>
                                        <th>Marks</th>
                                        <th>Grade</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>

                                </table>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="add_class_exam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Exam To Class</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                            <form id="view_class_form" class="user">
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                            <select name="exam_id" id="exam_id" class="form-control ">
                                                <?php
                                                    $sql = "SELECT exam_id, exam_name from exam";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    if ($query->rowCount() > 0) {
                                                        foreach ($results as $result) {   ?>
                                                            <option class="form-control form-control-user" value="<?php echo htmlentities($result->exam_id); ?>">
                                                                <?php echo htmlentities($result->exam_name); ?>
                                                            </option>
                                                        <?php }
                                                    } ?>
                                            </select>
                                        </div>
                                    </div>
                            
                                <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                            <select name="year_id" id="year_id" class="form-control ">
                                                <?php
                                                    $sql = "SELECT year_id, year_name from year";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    if ($query->rowCount() > 0) {
                                                        foreach ($results as $result) {   ?>
                                                            <option class="form-control form-control-user" value="<?php echo htmlentities($result->year_id); ?>">
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
                    <button class="btn btn-primary" type="submit" id="view_class_submit" >Logout</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/dist/js/main.min.js"></script>
    <!-- Page level plugins -->
    <script src="/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
    <script src="/js/demo/chart-area-demo.js"></script>
    <script src="/js/demo/chart-bar-demo.js"></script>
    <script src="/js/demo/chart-pie-demo.js"></script>                                               

</body>
</html>