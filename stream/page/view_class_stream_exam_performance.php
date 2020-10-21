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
    <title id=class_stream_title></title>

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
                        <button id="print_overall_result" 
                                class="btn btn-sm btn-primary">
                                 <span><i class="fas fa-file-pdf"></i></span>
                            Print Overall Result
                        </button>
                    </div>

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h5 mb-0 ">Academic Year : <span id="class_creation_date" class="text-gray-800"></span>
                        </h1>
                        <h1 class="h5 mb-0 ">Term : <span id="class_exam_term" class="text-gray-800"></span>
                        </h1>
                    </div>

                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index">Home</a></li>
                            <li class="breadcrumb-item"><a href="/stream/stream">All Classes</a></li>
                            <li class="breadcrumb-item"><a id="nav_link"></a></li>
                            <li id="active_breadcrumb" class="breadcrumb-item active" aria-current="page"></li>
                        </ol>
                    </nav>

                     <!-- DataTales Example -->
                     <div id="class_main_content" class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <span><i class="fas fa-user-graduate"></i></span>
                                Students Performance 
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="class_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Position</th>
                                            <th>Students Name</th>
                                            <th>Roll ID</th>
                                            <th>Stream Name</th>
                                            <th>Published At</th>
                                            <th>Total Subjects Sat for</th>
                                            
                                            <th>Total Score</th>
                                            <th>Mean Score</th>
                                            <th id="MarksOutOf"></th>
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

            <?php require_once '../../layouts/footer.php' ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php require_once '../../layouts/utils/logout_modal.html' ?>

    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/utils/utils.js"></script>
    <script src="/dist/js/streams/view_class_stream_exam.js"></script>
</body>

</html>