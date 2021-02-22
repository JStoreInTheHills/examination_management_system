<?php

include "../../layouts/utils/redirect.php";

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500 || !isset($_SESSION['role_id'])){
  redirectToHomePage();
}else{
      $_SESSION['last_login_timestamp'] = time();
?>
<!DOCTYPE html>
<html lang="en">

    <?php include "../../_partials/css_files.php";?>

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

                    <div class="d-sm-flex align-items-center justify-content-between">
                    <a class="btn btn-md text-primary mb-2" onclick="goBack()"> 
                        <i class="fas fa-arrow-left"></i> Back to previous page</a>
                    </div>
                    
                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        
                        <form id="edit_year_form" style="width:50%;">
                            <input type="hidden" name="year_id" id="year_id">
                              <input style="border-width:0px; border:none; font-size: 1.5em; background-color:#f8f9fc" class="form-control text-gray-800 edit_school_input" type="text" name="heading"  id="heading">
                        </form>

                        <div class="btn-group">
                            <button id="edit_academic_year" class="btn btn-sm btn-outline-danger"></button>
                        </div>
                    </div>

                    <div class="d-sm-flex align-items-center justify-content-between mb-3">
                        <h1 id="creation_date" class="h5 mb-0 text-gray-600"> </h1>
                        <h1 id="status" class="h5 mb-0"></h1>
                     </div>

                     <hr class="my-2">

                    <span id="alert"></span>

                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index">Home</a></li>
                            <li class="breadcrumb-item"><a href="/academic_year/year">Academic Year</a></li>
                            <li id="bread_list" class="breadcrumb-item active" aria-current="page"></li>
                        </ol>
                    </nav>

                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-primary  h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Exams This Year</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"
                                                id="all_exams_this_year"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#"> <i class="fas fa-book-reader fa-2x text-info-300"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-primary  h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Students Registered This Year</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"
                                                id="all_students_registered_this_year"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#"> <i class="fas fa-users fa-2x text-info-300"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    


                    <nav class="mb-4">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home" aria-selected="true"> <span><i
                                        class="fas fa-chalkboard "></i></span> Academic Year Terms</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                role="tab" aria-controls="nav-profile" aria-selected="false"> <span><i
                                        class="fas fa-book-reader"></i></span> End Year Performance</a>
                        </div>
                    </nav>

                    <!-- start of row -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    <div class="card shadow mb-4">
                                        <div class="card-header text-primary font-weight-bold">
                                            Academic Year Terms
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped" width="100%" cellspacing="0"
                                                    id="term_year_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Date Added</th>
                                                            <th>Term Name</th>
                                                            <th>Created By</th>
                                                            <th>Status</th>
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
                                                            <th>Date Created</th>
                                                            <th>Stream Name</th>
                                                            <th>Stream Code</th>
                                                            <th>Class Teacher</th>
                                                            <th>Class</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <!------------------------------------------------------------------------------------------------->
                        <div class="col-lg-4">
                            <div class="card shadow mb-4">
                                <div class="card-header text-primary font-weight-bold">
                                    Add Terms to Academic Year
                                </div>
                                <div class="card-body">
                                <span id="card_alert"></span>
                                    <form id="year_form" class="user">
                                        <div class="form-group row">
                                            <div class="col-md-12 mb-3 mb-sm-0">
                                                <label class="text-primary" for="term_name">Choose Term Name:</label>
                                                <select class="form-control" name="term_name" id="term_name">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="btn-group float-right">
                                            <button class="btn btn-primary" name="submit" type="submit" id="form_submit">Save</button>
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
            <?php include '../../layouts/footer.php' ?>
        </div>
        <!-- End of Content Wrapper -->
        <?php include '../../layouts/utils/logout_modal.html' ?>
    </div>
    <!-- End of Page Wrapper -->


    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/utils/utils.js"></script>
    <script src="/dist/js/years/view_academic_year.js"></script>
</body>

</html>

<?php }?>