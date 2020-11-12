<?php 
include "../../layouts/utils/redirect.php";

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500 || !isset($_SESSION['role_id'])){
  redirectToHomePage();
}else{
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title id="page_title"></title>

    <!-- Custom fonts for this template -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../../vendor/fontawesome-free/css/all.css" rel="stylesheet" type="text/css">
    <link href="../../dist/css/main.min.css" rel="stylesheet" type="text/css">


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
                        <h1 class="h3 mb-4 text-gray-800" id="page_heading"></h1>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button class="btn btn-outline-primary" id="editExamStatusButton"></button>
                            <button class="btn btn-primary" id="editExamDetails"></button>
                        </div>

                    </div>
                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index">Home</a></li>
                            <li class="breadcrumb-item"><a href="/exam/exam">All Exams</a></li>
                            <li class="breadcrumb-item active" id="exam_nav_label" aria-current="page"></li>
                        </ol>
                    </nav>
                    <span id="alert"></span>

                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Exam Out Of</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="exam_out_of"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a id="editMarksOutOf"><i class="fas fa-edit fa-2x text-primary"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- <div class="col-lg-12">
                            <div class="card mb-4 shadow ">
                                <div class="card-header text-primary">
                                    All Examinations
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Publish Date</th>
                                                    <th>Exam Name</th>
                                                    <th>Out of</th>
                                                    <th>Created By</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div> -->
                    </div>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include "../../layouts/footer.php";?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" id="exampleModalCenterTitle"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit_exam_form" action="" method="POST">
                            <input type="hidden" name="exam_id_edit" id="exam_id_edit">
                            
                            <label for="exam_name" class="text-primary">Enter exam Name: </label>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input type="text" id="exam_name" class="form-control" name="exam_name">
                                </div>
                            </div>
                            <label for="exam_out_of" class="text-primary">Enter Exam Out Of: </label>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input type="text" id="exam_out_of_edit" class="form-control" name="exam_out_of_edit">
                                </div>
                            </div>
                            <label for="exam_out_of" class="text-primary">Enter Exam Out Of: </label>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <select name="r_style" id="r_style" style="width:100%" class="form-control"></select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End of Page Wrapper -->
    <?php require_once('../../layouts/utils/logout_modal.html')?>

    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/utils/utils.js"></script>
    <script src="/dist/js/exams/exam_view.js"></script>
</body>

</html>

<?php } ?>