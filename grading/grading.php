<?php

session_start();

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1000){
  header("Location: /login");
  exit;
}else{
    $_SESSION['last_login_timestamp'] = time();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title id="title">Munawwar - Grading</title>

    <!-- Custom fonts for this template -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../vendor/fontawesome-free/css/all.css" rel="stylesheet" type="text/css">
    <link href="/dist/css/main.min.css" rel="stylesheet" type="text/css">

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
                    <h1 class="h3 mb-2 text-gray-800"> Grading System </h1>

                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a>Grading</a></li>
                        </ol>
                    </nav>

                    <hr>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Official Grading system used to grade students. </strong>
                        <hr>
                        <p class="mb-0">This is the standard grading system set by the Kenya Ministry Of Education and uses the Grade Point Average (GPA) grading system</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <!-- DataTales Example -->
                    <div id="main_content" class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fas text-primary fa-user"></i> Grading System.</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="result_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Grade</th>
                                            <th>Scale</th>
                                            <th>Scope</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>A</td>
                                            <td>96 - 100</td>
                                            <td>Excellent</td>
                                        </tr>
                                        <tr>
                                            <td>B</td>
                                            <td>86 - 95</td>
                                            <td>Very Good</td>
                                        </tr>
                                        <tr>
                                            <td>C</td>
                                            <td>70 - 85 </td>
                                            <td>Good</td>
                                        </tr>
                                        <tr>
                                            <td>D</td>
                                            <td>50 - 69</td>
                                            <td>Pass</td>
                                        </tr>
                                        <tr>
                                            <td>E</td>
                                            <td>00 - 49</td>
                                            <td>Fail</td>
                                        </tr>
                                        
                                    </tbody>

                                </table>
                            </div>
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

    <?php require_once('../layouts/utils/logout_modal.html')?>

    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/results/grading.js"></script>
    <script src="/dist/js/utils/utils.js"></script>
</body>

</html>
<?php } ?>