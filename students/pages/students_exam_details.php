<?php 
include '../../config/config.php';
include "../layouts/utils/redirect.php";

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500){
    redirectToHomePage();
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

    <title id=title></title>

    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="/dist/css/main.min.css">

</head>

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
                    <div class="d-sm-flex align-items-center justify-content-between mb-3">
                        <h1 class="h3 mb-2 text-gray-800" id="page_title">
                        </h1>

                        <div class="btn-group">
                            <a id="print_results">
                            </a>
                        </div>
                    </div>

                    <!-- Total marks of the student for the exam -->
                    <div class="card shadow col-md-3 eq-card mb-2">
                        <div class="card-body mb-n3">
                            <div class="row items-align-baseline h-100">
                                <div class="col-md-12 my-1">
                                    <p class="mb-0"><strong class="mb-0 text-uppercase text-primary">Total Marks
                                        </strong></p>
                                    <h3 id="total_sum_of_marks"></h3>
                                </div>

                                <div class="col-md-12 border-top py-3">
                                    <p class="text-muted">This is the total marks of the student for this exam.</p>
                                </div> 
                                <!-- .col -->

                            </div>
                        </div> <!-- .card-body -->
                    </div> <!-- .card -->

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
                <!-- 
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="editStudentModalTitle"></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">
    <form id="edit_student_form" class="user">
    
    <input type="hidden" name="students_id" id="students_id">
    <div class="form-group row">
    <div class="col-sm-6 mb-3 mb-sm-0">
    <label class="text-primary" for="first_name">First Name</label>
    <input type="text" name="first_name" class="form-control" id="first_name"
    placeholder="Enter First Name">
    </div>
    <div class="col-sm-6">
    <label class="text-primary" for="rollid"> Second Name</label>
    <input type="text" class="form-control" name="second_name" id="second_name"
    placeholder="Enter Second Name">
    </div>
    </div>
    <div class="form-group row">
    <div class="col-sm-6 mb-3 mb-sm-0">
    <label class="text-primary" for="last_name">Last Name</label>
    <input type="text" name="last_name" class="form-control" id="last_name"
    placeholder="Enter Last Name">
    </div>
    <div class="col-sm-6">
    <label class="text-primary" for="rollid"> Admission Number</label>
    <input type="text" class="form-control" name="rollid" id="rollid"
    placeholder="Enter Admission Number">
    </div>
    </div>
    <div class="form-group row">
    <div class="col-sm-6">
    <label class="text-primary" for="telephone">Telephone Number</label>
    <input type="text" name="telephone_no" class="form-control" id="telephone"
    placeholer="Enter Phone Number">
    </div>
    
    <div class="col-sm-6">
    <label class="text-primary" for="gender">Choose Gender</label>
    <select name="gender" id="gender" class="form-control">
    <option value="Male">Male</option>
    <option value="Female">Female</option>
    </select>
    </div>
    </div>
    
    <div class="form-group row">
    <div class="col-md-6 mb-3">
    <label class="text-primary for=" classid">Choose a Class</label>
    <select style="width: 100%" name="classid" id="classid"
    class="form-control "></select>
    </div>
    <div class="col-sm-6">
    <label class="text-primary" for="date">Date Of Birth</label>
    <input type="text" data-toggle="datepicker" name="dob" id="date"
    class="form-control" autocomplete="off" placeholder="2002-04-09">
    </div>
    </div>
    <hr>
    <div class="btn-group">
    <button class="btn btn-primary" type="submit">Save</button>
    </div>
    </form>
    </div>
    </div>
    </div>
    </div>
    
    <div class="modal fade" id="moveToDifferentClass tabindex=" -1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true"">
    </div> -->
            </div>
            <!-- End of Main Content -->

            <?php include './../../layouts/footer.php' ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php include '../../layouts/utils/logout_modal.html'; ?>

    <script src="/dist/js/main.min.js"> </script>
    <script src="/dist/js/utils/utils.js">
    </script>
    <script src="/dist/js/students/students_exam_details.js"></script>
</body>

</html>
<?php } ?>