<?php

include '../config/config.php';

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage || Results</title>

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../vendor/fontawesome-free/css/all.css" rel="stylesheet" type="text/css">
    <link href="/dist/css/main.min.css" rel="stylesheet" type="text/css">

    <style>
        #result_add_card{
            display: none;
        }
    </style>
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

   <?php include "../layouts/sidebar.php"; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <?php include '../layouts/topbar.php' ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">


                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800"> Manage Results </h1>
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
                                <table class="table table-bordered" id="result_table" width="100%" cellspacing="0">
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

                <!-- Basic Card Example -->
                <div id="result_add_card" class="card shadow mb-4 col-sm-offset-3">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add Student</h6>
                    </div>
                    <div class="card-body">
                        <form class="user" id="result_form">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                <select name="class" class="form-control clid" id="class" onChange="getStudent(this.value);" >
                                        <option value="">Select Class</option>
                                        <?php
                                        $sql = "SELECT id, s.name, c.ClassName 
                                                FROM tblclasses c LEFT JOIN stream s ON c.stream_id = s.stream_id";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {

                                            foreach ($results as $result) {   ?>

                                                <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->ClassName); ?>&nbsp; Stream-><?php echo htmlentities($result->name); ?></option>
                                                
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                <select name="studentid" class="form-control stid" id="studentid"  onChange="getresult(this.value);">
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
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                <div id="subject">
                                    </div>
                                </div>
                                
                            </div>

                            <div class="btn-group">
                                <button class="btn btn-primary" name="submit" type="submit">Save</button>
                                <button id="cancel_form" class="btn btn-warning"><i class="icon-cross"></i> Close</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
        <?php include '../layouts/footer.php'?>

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="../login.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<script src="/dist/js/main.min.js"></script>
<script src="/dist/js/result/result.js"></script>
</body>

</html>
