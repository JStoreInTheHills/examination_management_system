<?php

include "../layouts/utils/redirect.php";

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500 || !isset($_SESSION['role_id'])){
  redirectToHomePage();
}else{
      $_SESSION['last_login_timestamp'] = time();
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="descriptio    n" content="">
    <meta name="author" content="">    

    <title>Manage || Streams</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../dist/css/main.min.css" rel="stylesheet">
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

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-2 text-gray-800"> <span><i class="fas fa-chalkboard-teacher"></i></span>
                            Manage All Streams </h1>
                        <div class="btn-group">
                            <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm dropdown-toggle"
                                type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span><i class="fas fa-plus"> </i> Quick Add </span>
                            </button>
                            <button class="btn btn-outline-primary btn-sm">
                                <span><i class="fas fa-file-pdf"></i></span> Print Report
                            </button>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-header">Tools:</div>
                                <div class="dropdown-divider"></div>
                                <a href="#" data-toggle="modal" data-target="#add_new_stream" class="dropdown-item">
                                    Add New Stream
                                </a>
                            </div>
                        </div>

                    </div>

                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Streams</li>
                        </ol>
                    </nav>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Manage your stream in the school.</strong>
                        <hr>
                        <p class="mb-0">Use the table below to view and modify the stream</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- DataTales Example -->
                    <div id="class_main_content" class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <span><i class="fas fa-chalkboard-teacher"></i></span>
                                All Streams</h6>
                            <div class="dropdown no-arrow">

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="class_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Created At</th>
                                            <th>Stream Name</th>
                                            <th>Class Teacher</th>
                                            <th>Class Name</th>
                                            <th>Subjects</th>
                                            <th>Exams</th>
                                            <th>Students</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include '../layouts/footer.php'; ?>

        </div>
        <!-- End of Content Wrapper -->

        <!-- New Class Modal-->
        <div class="modal fade" id="add_new_stream" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="new_class_modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" id="new_class_modal">
                            <span><i class="fas fa-chalkboard"></i></span> Add a new Stream</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                    </div>

                    <div class="modal-body">

                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong>Use this form to add a new stream and assign a class teacher to the stream.</strong>
                            <hr>
                            <p class="mb-0">Field with the * mark are required</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <hr>
                        <form id="class_form" class="user">
                                <div class="form-group">
                                    <label class="text-primary">Stream Name*</label>
                                    <input type="text" id="ClassName" class="form-control" name="ClassName"
                                        placeholder="E.g 'Raudha' , 'Thanawii' ">
                                </div>

                                <div class="form-group">
                                    <label class="text-primary">Stream Unique Code*</label>
                                    <input type="text" id="ClassNameNumeric" class="form-control"
                                        name="ClassNameNumeric" placeholder="E.g '0CRB', 'OCRG'">
                                </div>

                                <div class="form-group">
                                    <label class="text-primary">Choose a Class*</label>
                                    <select style="width:100%" name="stream_id" id="stream_id" class="form-control">
                                        
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="text-primary">Assign Class Teacher</label>
                                    <select style="width:100%" name="teachers_id" id="teachers_id" class="form-control">          
                                    </select>
                                </div>

                            <div class="btn-group">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>

                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- End of Page Wrapper -->

    <?php include '../layouts/utils/logout_modal.html'; ?>

    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/utils/utils.js"></script>
    <script src="/dist/js/classes/class.js"></script>

</body>

</html>

<?php } ?>