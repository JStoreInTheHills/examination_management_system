<?php

session_start();

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 900){
    header("Location: /login.php");
    exit;
  }else{
      $_SESSION['last_login_timestamp'] = time();
  ?>

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
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../vendor/fontawesome-free/css/all.css" rel="stylesheet" type="text/css">
    <link href="../dist/css/main.min.css" rel="stylesheet" type="text/css">

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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Manage All Classes</h1>
                    </div>

                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Classes</li>
                        </ol>
                    </nav>

                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Classes </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="all_classes"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#"> <i class="fas fa-book-reader fa-2x text-info-300"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- start of row -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card mb-4 shadow">
                                <div class="card-header">
                                    <span class="text-primary"> <i class="fas fa-book-reader"></i> All Classes</span>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="stream_table" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Class Name</th>
                                                    <th>Created At</th>
                                                    <th>Streams</th>
                                                    <th style="text-align:center">Action</th>
                                                </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!------------------------------------------------------------------------------------------------->
                        <div class="col-lg-4">
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <span class="text-primary"> <i class="fas fa-book-reader"></i> Add a Class</span>
                                </div>
                                <div class="card-body">
                                    <form id="stream_form" class="user">
                                        <div class="form-group row">
                                            <div class="col-sm-12 mb-3 mb-sm-0">
                                                <label for="stream_name">Enter Class Name</label>
                                                <input type="text" id="stream_name" autocomplete="off"
                                                    class="form-control" placeholder="Raudha, Thanawii">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="desc">Enter Brief Description <span
                                                    class="text-danger">(Optional) </span></label>
                                            <textarea id="desc" class="form-control"
                                                aria-label="With textarea"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-primary float-right" name="submit" type="submit">Save</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- endo of row -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php require_once '../layouts/footer.php' ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php require_once '../layouts/utils/logout_modal.html' ?>

    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/streams/stream.js"></script>

</body>

</html>

<?php } ?>