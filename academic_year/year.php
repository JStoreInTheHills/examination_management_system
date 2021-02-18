<?php

include "../layouts/utils/redirect.php";

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500 || !isset($_SESSION['role_id'])){
  redirectToHomePage();
  }else{
      $_SESSION['last_login_timestamp'] = time();
  ?>

<!DOCTYPE html>
<html lang="en">

<?php include "../_partials/css_files.php";?>

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
                    <div class="d-sm-flex align-items-center justify-content-between">
                    <a class="btn btn-md text-primary mb-2" onclick="goBack()"> <i class="fas fa-arrow-left"></i> Back
                        to previous page</a>
                    </div>
                    
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-3">
                        <h1 class="h3 mb-0 text-gray-800" id="year_heading"></h1>
                    </div>

                    <div id="alert"></div>

                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Academic Years</li>
                        </ol>
                    </nav>

                    <!-- start of row -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <span class="text-primary font-weight-bold"> <i class="fas fa-address-book"></i> All
                                        Academic Years (Academic Periods).</span>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" width="100%" cellspacing="0" id="year_table">
                                            <thead>
                                                <tr>

                                                    <th>Created At</th>
                                                    <th>Year Name</th>
                                                    <th>Year Status</th>
                                                    <th># of Terms</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!------------------------------------------------------------------------------------------------->
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <span class="text-primary font-weight-bold">Add an Academic Period (Academic Year).</span>
                                </div>
                                <div class="card-body">

                                    <div class="errors text-danger"><span></span></div>

                                    <form id="year_form" class="user">
                                        <div class="form-group row">
                                            <div class="col-md-12 mb-3 mb-sm-0">
                                                <label for="year_name" class="text-primary">Enter an Academic
                                                    Year</label>
                                                <input type="text" name="year_name" autocomplete="off"
                                                    class="form-control" id="year_name" placeholder="e.g 2020-2021">
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
    <script src="/dist/js/years/years.js"></script>
</body>

</html>

<?php }?>