<?php 
include "../layouts/utils/redirect.php";

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500){
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

    <title>Manage || Exams</title>

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
                    <h1 class="h3 mb-4 text-gray-800"> Manage Exams </h1>

                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Exams</li>
                        </ol>
                    </nav>


                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Use this window to manage all the exams in the school.</strong>
                        <hr>
                        <p class="mb-0">All Exams are attached with an out of associated attribute .</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card mb-4 shadow ">
                                <div class="card-header text-primary">
                                    All Examinations
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="exam_table" width="100%" cellspacing="0">
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

                        </div>

                        <div class="col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header text-primary">
                                    <span><i class="fas fa-edit"></i></span> Add Examination
                                </div>
                                <div class="card-body">
                                    <form for="exam_form" class="user">
                                        <label for="exam_name" class="text-primary">Enter exam Name: </label>
                                        <div class="form-group row">
                                            <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="text" id="exam_name" class="form-control"
                                                    placeholder="Enter exam name">
                                            </div>
                                        </div>
                                        <label for="exam_out_of" class="text-primary">Enter exam Out of: </label>
                                        <div class="form-group row">
                                            <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="text" id="exam_out_of" class="form-control"
                                                    placeholder="Enter exam out of marks">
                                            </div>
                                        </div>

                                        <div class="btn-group">
                                            <button class="btn btn-primary" name="submit" id="submit"
                                                type="submit">Save</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include "../layouts/footer.php";?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <?php require_once('../layouts/utils/logout_modal.html')?>

    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/exams/exam.js"></script>
    <script src="/dist/js/utils/utils.js"></script>
</body>

</html>

<?php } ?>