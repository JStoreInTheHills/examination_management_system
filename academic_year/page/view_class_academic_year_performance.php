<?php

include "../../layouts/utils/redirect.php";

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500 || !isset($_SESSION['role_id'])){
  redirectToHomePage();
  }else{
      $_SESSION['last_login_timestamp'] = time();
  ?>

<!DOCTYPE html>
<html lang="en">

    <?php include "../../_partials/css_files.php"; ?>


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

                <div class="d-sm-flex align-items-center justify-content-between">
                    <a class="btn btn-md text-primary mb-2" onclick="goBack()"> 
                        <i class="fas fa-arrow-left"></i> Back to previous page</a>
                    </div>

                    <!-- Page Heading -->
                    
                    <div class="d-sm-flex align-items-center justify-content-between mb-3">
                        <h1 class="h3 mb-0 text-gray-800">End Year Performance. </h1>
                    </div>

                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        <h1 id="class_name" class="h5 mb-0 text-gray-800"></h1>
                        <h1 id="heading" class="h5 mb-0 text-gray-800"></h1>
                    </div>

                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        <h5 id="class_creation_date" class="h5 mb-0 text-gray-800"></h5>
                        <h5 id="class_teachers_name" class="h5 mb-0 text-gray-800"></h5>
                    </div>
                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="/academic_year/year.php">Academic Year</a></li>
                            <li id="bread_list" class="breadcrumb-item"></li>
                            <li id="bread_list2" class="breadcrumb-item active" aria-current="page"></li>
                        </ol>
                    </nav>

                    <hr class="my-4">
                    <!-- start of row -->
                    <div class="row">

                        <div class="col-lg-8">
                            <div class="card mb-3 border-primary">
                                <div class="card-header text-primary font-weight-bold">
                                    All Exams for the Academic Period
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" width="100%" cellspacing="0" id="table">
                                            <thead>
                                                <tr>
                                                    <th>Date Created</th>
                                                     <th>Exam Name</th>
                                                     <th>Term Name</th>
                                                    <th>Status</th>
                                                    <th>Out Of</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!------------------------------------------------------------------------------------------------->

                        <div class="col-lg-12">
                            <div class="card shadow mb-3">
                                <div class="card-header text-primary font-weight-bold">
                                    End Year Result Students Table
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" width="100%" id="class_academic_table">
                                            <thead>
                                                <tr>
                                                    <th>Date Created</th>
                                                    <th>Student Name</th>
                                                    <th>Admission #</th>
                                                    <th>Status</th>
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

                <?php include '../../layouts/footer.php' ?>
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/utils/utils.js"></script>
    <script src="/dist/js/years/view_class_academic_year_performance.js"></script>
</body>

</html>

<?php }?>