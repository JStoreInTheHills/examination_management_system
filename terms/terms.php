<?php

session_start();

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500 || !isset($_SESSION['role_id'])){
    header("Location: /login");
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

    <title>Manage || Academic Terms</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="../dist/css/main.min.css" rel="stylesheet">

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
                        <h1 class="h3 mb-0 text-gray-800">Manage Academic Terms</h1>
                    </div>

                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Academic Terms</li>
                        </ol>
                    </nav>

                    <!-- start of row -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                   <span class="text-primary"> <i class="fas fa-calendar"></i> All Academic Terms</span>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" width="100%" cellspacing="0" id="terms_table">
                                            <thead>
                                                <tr>
                                                    <th>Term Name</th>
                                                    <th>Created At</th>
                                                    <th>Created By</th>
                                                    <th>Action</th>
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
                                   <span class="text-primary" >Add Academic Terms</span> 
                                </div>
                                <div class="card-body">

                                <div class="errors text-danger"><span></span></div>

                                    <form id="term_form">

                                        <div class="form-group row">
                                            <div class="col-md-12 mb-3 mb-sm-0">
                                            <label for="term_name" class="text-primary">Enter Name of Term</label>
                                               <input type="text" autocomplete="off" class="form-control" 
                                                    id="term_name" name="term_name" placeholder="e.g First Term, Second Term">
                                                    <small id="emailHelp" class="form-text text-muted">Term name should be 4 charaters and above.</small>
                                            </div>
                                        </div>

                                        <div class="btn-group float-right">
                                            <button class="btn btn-primary" type="submit">Save</button>
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
            <?php include '../layouts/footer.php' ?>
        </div>
        <!-- End of Content Wrapper -->
        <?php include '../layouts/utils/logout_modal.html' ?>
    </div>
    <!-- End of Page Wrapper -->


    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/utils/utils.js"></script>
    <script src="/dist/js/terms/terms.js"></script>
</body>

</html>

<?php }?>