<?php 
include "../../layouts/utils/redirect.php";

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500){
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

        <?php  
    if(isset($_SESSION['role_id'])){
        include "../layouts/sidebar.php"; 
    }
    ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include './../../layouts/topbar.php' ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <a class="btn btn-md text-primary mb-2" onclick="goBack()"> <i class="fas fa-arrow-left"></i> Back to previous page</a>
                    <div class="d-sm-flex align-items-center justify-content-between mb-3">
                        <h1 class="h3 text-gray-800" id="page_title">
                        </h1>

                        <div class="btn-group">
                            <a class="btn btn-primary btn-md" id="print_results" target="_blank">
                            </a>
                        </div>
                    </div>

                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        <h5 class="h5 mb-2 text-gray-800" id="exam_name">
                        </h5>
                        <h5 class="h5 mb-2 text-gray-800" id="exam_out_of">
                        </h5>
                    </div>

                    <div class="row items-align-baseline">
                        <div class="col-md-12 col-lg-3">
                            <!-- Total marks of the student for the exam -->
                            <div class="card shadow eq-card mb-2 border-left-primary">
                                <div class="card-body mb-n3">
                                    <div class="row items-align-baseline h-100">
                                        <div class="col-md-12 my-1">
                                        <p class="text-muted">This is the total marks of the student for the exam.</p>
                                            <p class="mb-0"><strong class="mb-0 text-uppercase text-primary">Total Marks
                                                </strong></p>
                                            <h3 id="total_sum_of_marks"></h3>
                                        </div>
                                        <div class="col-md-6 border-top py-3">
                                            <p class="mb-1"><strong class="text-primary">Mean Score(Average)</strong></p>
                                            <h4 class="mb-0" id="average_marks"></h4>
                                            <p class="small text-muted mb-0"><span></span></p>
                                        </div> <!-- .col -->
                                        <div class="col-md-6 border-top py-3">
                                            <p class="mb-1"><strong class="text-primary">Total Percentage (%)</strong></p>
                                            <h4 class="mb-0" id="percentage_marks"></h4>
                                            <p class="small text-muted mb-0"><span></span></p>
                                        </div> 
                                       
                                    </div>
                                </div> <!-- .card-body -->
                            </div> 
                            <!-- .card -->
                        </div>
                        <div class="col-md-12 col-lg-3">
                            <!-- Position of the student in the exam -->
                            <div class="card shadow eq-card mb-2 border-left-primary">
                                <div class="card-body mb-n3">
                                    <div class="row items-align-baseline h-100">
                                        <div class="col-md-12 my-1">
                                        <p class="text-muted">This is the position of the student for the exam.</p>
                                            <p class="mb-0"><strong class="mb-0 text-uppercase text-primary">Students Position
                                                </strong></p>
                                            <h3 id="students_position"></h3>
                                        </div>
                                        <div class="col-md-12 border-top py-3">
                                            <p class="mb-1"><strong class="text-primary">Total Number of Students Sat for Exam.</strong></p>
                                            <h4 class="mb-0" id="total_number_of_students"></h4>
                                        </div> <!-- .col -->
                                    </div>
                                </div> <!-- .card-body -->
                            </div> 
                            <!-- .card -->
                        </div>

                        <!-- <div class="col-md-12 col-lg-3">
                            <div class="card shadow eq-card mb-2 border-left-primary">
                                <div class="card-body mb-n3">
                                <p class="text-muted">This is the percentage score for the.</p>

                                    <div class="">
                                    <canvas id="myDonught" ></canvas>
                                    </div>
                                </div> 
                            </div> 
                        </div> -->
                    </div>

                    <div class="alert alert-info alert-dismissible fade show mb-2" role="alert">
                        <strong>The chart below shows the students performance for all the subjects sat for this
                            exam.</strong>
                        <hr>
                        <p class="mb-0">The y-axis holds the marks of the subject and the x-axis holds the subject name.

                        </p>
                    </div>

                    <div class="card shadow chart-area mb-2">
                        <canvas id="myAreaChart"></canvas>
                    </div>


                    <div class="alert alert-warning alert-dismissible fade show mb-2" role="alert">
                        <strong>The table below shows the students subject performance, the subject teachers and the
                            marks attained for that subject. </strong>
                        <hr>
                        <p class="mb-0">The subjects have been ordered from the best performed to the least performed.

                        </p>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <span><i class="fas fa-users"></i></span> Overall Exam Performance</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="subject_performance" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Subject Name</th>
                                            <th>Subject Teacher</th>
                                            <th>Subject Marks</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include './../../layouts/footer.php' ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php include '../../layouts/utils/logout_modal.html'; ?>

    <script src="/dist/js/main.min.js"> </script>
    <script src="/dist/js/utils/utils.js"></script>
    <script src="/dist/js/students/students_exam_details.js"></script>
</body>

</html>
<?php } ?>