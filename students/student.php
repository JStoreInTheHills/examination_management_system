<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage || Classes</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../dist/css/main.min.css" rel="stylesheet">


    <style>
        #student_add_card{
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
                <h1 class="h3 mb-2 text-gray-800"> Manage Students </h1>
                    <p>All Students in the School with their age and date of registration. Students with Active Status are still ongoing.</p>
                <!-- DataTales Example -->
                <div id="main_content" class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">All Students</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Tools:</div>
                                    <a class="dropdown-item" id="add_student" href="#">Add Students</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Admission #</th>
                                        <th>Reg Date</th>
                                        <th>Class</th>
                                        <th>Age</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Admission #</th>
                                        <th>Reg Date</th>
                                        <th>Class</th>
                                        <th>Age</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>

                </div>

                <!-- Basic Card Example -->
                <div id="student_add_card" class="card shadow mb-4 col-sm-offset-3">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add Student</h6>
                    </div>
                    <div class="card-body">
                        <form id="form" class="user">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" name="fullanme" class="form-control" id="fullanme" placeholder="Full Name">
                                </div>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" maxlength="5" name="rollid"  id="rollid" placeholder="Admission Number">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="email" name="emailid"  id="email" class="form-control " placeholder="Email Address">
                                </div>
                                <div class="col-sm-6">
                                    <input type="radio"  name="gender"  id="gender" checked >Male
                                    <input type="radio"  name="gender"  id="gender" >Female

                                </div>                                            
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select name="id" id="classid" class="form-control ">
                                        <?php
                                            include './../config/config.php';
                                            $sql = "SELECT id, ClassName from tblclasses";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {   ?>
                                                    <option class="form-control form-control-user" value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->ClassName); ?>&nbsp;</option>
                                                <?php }
                                            } ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" data-toggle="datepicker"  name="dob" id="date" class="form-control" autocomplete="off">
                                </div>
                            </div>

                            <div class="btn-group">
                                <button class="btn btn-primary" name="submit" type="submit">Save</button>
                                <button class="btn btn-danger" id="cancel_add" >Cancel</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->


    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->


<script src="/dist/js/main.min.js"></script>
<script src="/dist/js/students/student.js"></script>
</body>

</html>
