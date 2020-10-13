<?php

include "../../layouts/utils/redirect.php";

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
    <meta name="description" content="">
    <meta name="author" content="">

    <title id=year_title></title>

    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="../../dist/css/main.min.css" rel="stylesheet">

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
                        <h1 id="heading" class="h3 mb-0 text-gray-800"> </h1>
                    </div>

                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index">Home</a></li>
                            <li class="breadcrumb-item"><a href="/academic_year/year">Academic Year</a></li>
                            <li class="breadcrumb-item"><a id="bread_list_year" href=""></a></li>
                            <li id="bread_list_term" class="breadcrumb-item active" aria-current="page"></li>
                        </ol>
                    </nav>

                    <nav class="mb-4">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home" aria-selected="true">
                                <span><i class="fas fa-chalkboard "></i></span> Academic Year Terms
                            </a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                role="tab" aria-controls="nav-profile" aria-selected="false">
                                <span><i class="fas fa-book-reader"></i></span> End Year Performance
                            </a>
                        </div>
                    </nav>

                    <!-- start of row -->
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    <div class="card shadow mb-4">
                                        <div class="card-header text-primary">
                                            All Classes
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped" width="100%" cellspacing="0"
                                                    id="term_year_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Class Name</th>
                                                            <th>Class Code</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <div class="card shadow mb-4">
                                        <div class="card-header text-primary">
                                            End Year Stream Performance
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped" width="100%" cellspacing="0"
                                                    id="class_end_year_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Stream Name</th>
                                                            <th>Stream Code</th>
                                                            <th>Class</th>
                                                            <th>Total Marks</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->
                <?php include '../../layouts/footer.php' ?>
            </div>
            <!-- End of Content Wrapper -->
            <?php include '../../layouts/utils/logout_modal.html' ?>
        </div>
        <!-- End of Page Wrapper -->


        <script src="/../dist/js/main.min.js"></script>
        <script src="/../dist/js/years/view_academic_year_term_performance.js"></script>
</body>

</html>

<?php }?>