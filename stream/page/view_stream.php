<?php
    session_start();

    if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500 || !isset($_SESSION['role_id'])){
        header("Location: /login");
        exit;
    }else{
        $_SESSION['last_login_timestamp'] = time();
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id=stream_title></title>

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
                        <h1 class="h3 mb-0 text-gray-800" id="page_header">
                        </h1>
                        <div class="btn-group">
                            <button id="editClass" class="btn btn-md btn-primary" data-toggle="modal" data-target="#edit_class">
                               <span><i class="fas fa-edit"></i>  </span>  Edit this Class
                            </button>
                            <button class="btn btn-md btn-danger" id="editClassActive">
                               <span><i class="fas fa-trash"></i></span> 
                            </button>
                        </div>
                    </div>

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h5 mb-0 ">Class Description : <span id="class_description"
                                class="text-gray-800"></span></h1>
                        <h1 class="h5 mb-0 ">Date Created : <span id="class_creation_date" class="text-gray-800"></span>
                        </h1>
                    </div>



                    <div class="row">

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-bottom-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">All
                                                Students</div>
                                            <div class="h4 mb-0 font-weight-bold text-gray-800" id="all_students"></div>
                                        </div>
                                        <div class="col-auto">
                                            <span> <i class="fas fa-users fa-2x text-primary"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-bottom-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Assigned Subjects Teachers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="all_teachers"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="/teachers/teachers.php"> <i
                                                    class="fas fa-chalkboard fa-2x text-info-300"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-bottom-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Number of Streams
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="all_streams"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="/class/class.php"> <i
                                                    class="fas fa-door-open fa-2x text-primary-300"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Number of Exams
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="all_exams"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="/exams/exams.php"> <i
                                                    class="fas fa-edit fa-2x text-primary-300"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <nav aria-label="breadcrumb mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index">Home</a></li>
                            <li class="breadcrumb-item"><a href="/stream/stream">All Classes</a></li>
                            <li id="active_breadcrumb" class="breadcrumb-item active" aria-current="page"></li>
                        </ol>
                    </nav>

                    <div id="alert"></div>

                    <nav class="mb-4">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#subjects"
                                role="tab" aria-controls="exams" aria-selected="true"> <span><i
                                        class="fas fa-chalkboard "></i></span> Associated Streams </a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#exams"
                                role="tab" aria-controls="students" aria-selected="false"> <span><i
                                        class="fas fa-users"></i></span> Class Examination</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#students"
                                role="tab" aria-controls="nav-contact" aria-selected="false"> <span><i
                                        class="fas fa-address-book"></i></span> All Students in class </a>
                        </div>
                    </nav>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="subjects" role="tabpanel"
                                    aria-labelledby="nav-stream-tab">

                                    <div class="card shadow ">
                                        <div
                                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary"> <span><i
                                                        class="fas fa-door-open"></i></span> List of All Streams</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-condensed table-striped"
                                                    id="class_stream_table" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Date Created</th>
                                                            <th>Stream Name</th>
                                                            <th>Stream Code</th>
                                                            <th>Students</th>
                                                            <th>Subjects</th>
                                                            <th>Exams</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="exams" role="tabpanel" aria-labelledby="nav-exam-tab">
                                    <div class="card shadow mb-4">
                                        <div
                                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary"><span><i
                                                        class="fas fa-edit"></i></span>
                                                All Exams Assigned to Streams in this Class.
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-condensed table-striped" id="class_exam_table"
                                                    width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Last Entry Date</th>
                                                            <th>Exam Name</th>
                                                            <th>Term</th>
                                                            <th>Exam Sat by</th>
                                                            <th>Academic Year</th>
                                                        </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="nav-exam-tab">
                                    <div class="card shadow mb-4">
                                        <div
                                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary"><span><i
                                                        class="fas fa-edit"></i></span>
                                                All Students in this Class.
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-condensed table-striped"
                                                    id="class_student_table" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Student Name</th>
                                                            <th>Roll Id</th>
                                                            <th>Reg Date</th>
                                                            <th>Status</th>
                                                            <th>Date Of Birth</th>
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

                    <!-- Modal -->
                    <div class="modal fade" id="edit_class" tabindex="-1" role="dialog"
                        aria-labelledby="edit_classTitle" aria-hidden="true" data-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-primary" id="exampleModalLongTitle" ></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" id="edit_this_class_form" method="post">
                                        <div class="form-group">
                                            <label for="class_name" class="text-primary">Class Name: </label>
                                            <input type="text" class="form-control" id="edit_class_name">
                                            <small class="text-muted">Class name cannot be less than 3 letters</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-primary" for="desc">Enter Brief Description <span
                                                    class="text-danger">(Optional) </span></label>
                                            <textarea id="edit_class_desc" class="form-control"
                                                aria-label="With textarea" placeholder="Enter brief description of the class"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="edit_this_class_submit_btn" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php require_once '../../layouts/footer.php' ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php require_once '../../layouts/utils/logout_modal.html' ?>



    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/utils/utils.js"></script>
    <script src="/dist/js/streams/view_stream.js"></script>
</body>

</html>