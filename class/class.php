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
        #class_add_card{
            display: none;
        }
        #subject_add_card{
            display: none;
        }
    </style>
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <?php include "./../layouts/sidebar.php"; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <?php include './../layouts/topbar.php' ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800"> Manage Classes </h1>

                <!-- DataTales Example -->
                <div id="class_main_content" class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">All Classes</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Tools:</div>
                                <a class="dropdown-item" id="add_class" href="#">Add Class</a>
                                <a class="dropdown-item" id="add_subject_to_class" href="#">Add Subject to Class</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="class_table" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Class Name</th>
                                    <th>Code</th>
                                    <th>Stream</th>
                                    <th>Total Subjects</th>
                                    <th>Total Students</th>
                                    <th class="text-center sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 100px;">Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Class Name</th>
                                    <th>Code</th>
                                    <th>Stream</th>
                                    <th>Total Subjects</th>
                                    <th>Total Students</th>
                                    <th class="text-center sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 100px;">Actions</th>
                                </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>

                </div>

                <!-- Class Add Card -->
                <div id="class_add_card" class="card shadow mb-4 col-sm-offset-3">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add Class</h6>
                    </div>
                    <div class="card-body">
                        <form id="class_form" class="user">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" id="ClassName" class="form-control" name="ClassName" placeholder="Class Name" >
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" id="ClassNameNumeric" class="form-control" name="ClassNameNumeric" placeholder="Class Code" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select name="stream_id" id="stream_id" class="form-control">
                                        <?php
                                        include "../config/config.php";

                                        $sql = "SELECT stream_id, name from stream";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {   ?>
                                                <option value="<?php echo htmlentities($result->stream_id); ?>"><?php echo htmlentities($result->name); ?>&nbsp;</option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>

                            </div>

                            <div class="btn-group">
                                <button class="btn btn-primary" name="submit" type="submit">Save</button>
                                <button class="btn btn-danger" id="cancel_add_class" >Cancel</button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Class Add Card -->
                <div id="subject_add_card" class="card shadow mb-4 col-sm-offset-3">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add Subject</h6>
                    </div>
                    <div class="card-body">
                        <form id="subject_form_add" class="user">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" id="ClassName" class="form-control" name="ClassName" placeholder="Class Name" >
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" id="ClassNameNumeric" class="form-control" name="ClassNameNumeric" placeholder="Class Code" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select name="stream_id" id="stream_id" class="form-control">
                                        <?php
                                        include "../config/config.php";

                                        $sql = "SELECT stream_id, name from stream";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {   ?>
                                                <option value="<?php echo htmlentities($result->stream_id); ?>"><?php echo htmlentities($result->name); ?>&nbsp;</option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>

                            </div>

                            <div class="btn-group">
                                <button class="btn btn-primary"  name="submit" type="submit">Save</button>
                                <button class="btn btn-danger" id="cancel_add_subject" >Cancel</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Your Website 2019</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

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
<script src="/dist/js/classes/class.js"></script>

</body>

</html>
