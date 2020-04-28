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
    <title>Class || Details</title>

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
                <h1 class="h3 mb-0 text-gray-800">Manage Class</h1>
                <div class="dropdown no-arrow">
                    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     Tools
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a href="#" data-toggle="modal" data-target="#add_class_exam" class="dropdown-item"><i class="fas fa-download fa-sm text-black-50"></i> Add Class Exam</a>
                      <a href="#" data-toggle="modal" data-target="#add_class_exam" class="dropdown-item"><i class="fas fa-download fa-sm text-black-50"></i> Add Subject</a>
                      <a href="#" data-toggle="modal" data-target="#add_class_exam" class="dropdown-item"><i class="fas fa-download fa-sm text-black-50"></i> Add Student</a>
                    </div>
                  </div>
            </div>

                <!-- Exam DataTales -->
                <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="view_class" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Exam Name</th>
                                        <th>Exam Period</th>
                                        <th>Published At</th>
                                        <th>Created By</th>
                                        <th class="text-center sorting_disabled" aria-label="Actions">Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Exam Name</th>
                                        <th>Exam Period</th>
                                        <th>Published At</th>
                                        <th>Created By</th>
                                        <th class="text-center sorting_disabled" aria-label="Actions">Actions</th>
                                    </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                </div>
                </div>

                <!-- Student DataTales -->
                <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="view_class_student" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>RollId</th>
                                        <th>Reg Date</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th class="text-center sorting_disabled" rowspan="1" colspan="1" aria-label="Actions">Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>RollId</th>
                                        <th>Reg Date</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th class="text-center sorting_disabled" rowspan="1" colspan="1" aria-label="Actions">Actions</th>
                                    </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                 <!-- Student DataTales -->
                 <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="view_class_subjects" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Subject Name</th>
                                        <th>Subject Code</th>
                                        <th>Reg Date</th>
                                        <th>Status</th>
                                        <th class="text-center sorting_disabled" rowspan="1" colspan="1" aria-label="Actions">Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Subject Name</th>
                                        <th>Subject Code</th>
                                        <th>Reg Date</th>
                                        <th>Status</th>
                                        <th class="text-center sorting_disabled" rowspan="1" colspan="1" aria-label="Actions">Actions</th>
                                    </tr>
                                    </tfoot>

                                </table>
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
    <script src="/dist/js/classes/view_class.js"></script>
                                            
</body>
</html>