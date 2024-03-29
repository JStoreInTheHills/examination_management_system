<?php 
session_start();

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500 || !isset($_SESSION['role_id'])){
  header("Location: /login");
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

    <title>Manage || Subjects</title>

    <!-- Custom fonts for this template -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../vendor/fontawesome-free/css/all.css" rel="stylesheet" type="text/css">
    <link href="../dist/css/main.min.css" rel="stylesheet" type="text/css">

<style>
  
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800" id="heading">
                        <span><i class="fas fa-chalkboard"></i></span> Manage Subjects </h1>
                        <div class="btn-group">
                            <button class="btn btn-primary btn-xs" id="print_subjects">
                                <span><i class="fas fa-file-pdf"></i></span>
                                Print Report 
                            </button>
                        </div>
                       
                       
                    </div>

                    <nav aria-label="breadcrumb mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Subjects</li>
                    </ol>
                </nav>

                    <!-- start of row -->
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="m-0 card-header text-primary">
                                    <span><i class="fas fa-chalkboard"></i></span>  All Subjects

                                   
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="subject_table" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Subject Name</th>
                                                    <th>Subject Code</th>
                                                    <th>Subject Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!------------------------------------------------------------------------------------------------->
                        <div class="col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header text-primary">
                                    <span><i class="fas fa-plus"></i></span> New Subject
                                </div>
                                <div class="card-body">
                                    <form id="subject_form" class="user">
                                        <div class="form-group row">
                                            <div class="col-sm-12 mb-3 mb-sm-3">
                                            <label class="text-primary" for="subject_name">Enter Subject Name:</label>
                                                <input type="text" id="subject_name" class="form-control"
                                                    placeholder="Enter Subject Name e.g. English, Kiswahili" autocomplete="off">
                                            </div>
                                            <div class="col-sm-12 mb-3 mb-sm-3">
                                            <label class="text-primary" for="subject_name">Arabic Subject Name: <span><i class="text-danger">(Optional)</i></span></label>
                                                <input type="text" id="ar_subject_name" class="form-control"
                                                    placeholder="Enter Subject Name In Arabic E.g Al Quran" autocomplete="off">
                                            </div>
                                            <div class="col-sm-12 mb-3 mb-sm-0">
                                            <label class="text-primary" for="subject_code">Enter Subject Code:</label>
                                                <input type="text" id="subject_code" class="form-control"
                                                    placeholder="Enter Subject Code e.g. ENG, KIS" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="btn-group">
                                            <button class="btn btn-primary" name="submit" type="submit">Save</button>

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

           <?php include '../layouts/footer.php'; ?>
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

  <?php include '../layouts/utils/logout_modal.html'; ?>

    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/subjects/subject.js"></script>
    <script src="/dist/js/utils/utils.js"></script>
</body>

</html>

<?php } ?>