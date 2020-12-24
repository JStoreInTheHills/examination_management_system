<?php 
    include '../../config/config.php';
    include "../../layouts/utils/redirect.php";

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
                include "../../layouts/sidebar.php"; 
            }
         ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include './../../layouts/topbar.php' ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800" id="heading"> </h1>

                        <div class="btn-group">
                            <button class="btn btn-outline-primary btn-md" id="edit_students">
                            </button>

                            <?php
                                if(isset($_SESSION['role_id'])){
                                    echo  "<button class='btn btn-primary btn-md' id='makeStudentInactive'></button>";
                                }
                                
                            ?>
                        </div>

                    </div>

                    <div id="alert"></div>

                    <nav class="mb-3">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home" aria-selected="true"> <span><i
                                        class="fas fa-user-graduate"></i></span> Students Performance</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                role="tab" aria-controls="nav-profile" aria-selected="false"> <span><i
                                        class="fas fa-chalkboard"></i></span> Term Performance</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                                role="tab" aria-controls="nav-contact" aria-selected="false"> <span><i
                                        class="fas fa-address-book"></i></span> Year Performance</a>

                        </div>
                    </nav>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    <!-- Area Chart -->
                                    <div class="alert alert-info alert-dismissible fade show mb-1" role="alert">
                                        <strong>This chart shows the gradual performance of the student over a period of exams.</strong>
                                        <hr>
                                        <p class="mb-0">The y-axis holds the marks of the exams and the x-axis holds the exam. </p>
                                    </div>
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary"><span><i
                                                        class="fas fa-user-graduate"></i></span> Students Performance
                                                Curve
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-area">
                                                <canvas id="myAreaChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                        <p class="text-center">Overall Exam Performance</p>
                                    <hr>
                                    <div class="alert alert-info alert-dismissible fade show mb-1" role="alert">
                                        <strong>This table shows the exam performance of the student and the total marks obtained against an Academic year.</strong>
                                        <hr>
                                        <p class="mb-0">Click on an exam to view exam performance. </p>
                                    </div>
                                    <!-- Bar Graph -->
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">
                                                <span><i class="fas fa-users"></i></span> Overall Exam Performance</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped " id="overrall_exam_table"
                                                    width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Exam Name</th>
                                                            <th>Total Marks</th>
                                                            <th>Term</th>
                                                            <th>Year</th>
                                                        </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <strong>This table shows the term performance of the student.</strong>
                                        <hr>
                                        <p class="mb-0">It combines all the exams in the term. Click on a term to view students performance for that term.</p>
                                    </div>

                                    <div class="card shadow mb-4">
                                        <div
                                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="mx font-weight-bold text-primary">Term Performance</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped " id="term_performance_table"
                                                    width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Term</th>
                                                            <th>Academic Year</th>
                                                        </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                                    aria-labelledby="nav-contact-tab">...</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!--Students Details -->
                            <div class="card mb-2">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><span><i
                                                class="fas fa-user"></i></span> Students Details</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li id="students_name" class="list-group-item"></li>
                                        <li id="RollId" class="list-group-item"></li>
                                        <li id="age" class="list-group-item"></li>
                                        <li id="Gender" class="list-group-item"></li>
                                        <li id="DOB" class="list-group-item"></li>
                                        <li id="status" class="list-group-item"></li>
                                        <li id="RegDate" class="list-group-item"></li>
                                        <li id="TelNo" class="list-group-item"></li>

                                    </ul>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header d-sm-flex align-items-center justify-content-between  py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Class Details</h6>

                                    <?php
                                        if(isset($_SESSION['role_id'])){
                                            echo  "<button class='btn btn-sm btn-primary' id='moveStudentToDifferentClass'></button>";
                                        }
                                    ?>

                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li id="class_name" class="list-group-item"></li>
                                        <li id="stream_name" class="list-group-item"></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

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
                </div>
            </div>
            <!-- End of Main Content -->

            <?php include './../../layouts/footer.php' ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php include '../../layouts/utils/logout_modal.html'; ?>

    <script src="/dist/js/main.min.js"> </script> <script src="/dist/js/utils/utils.js">
                    </script>
                    <script src="/dist/js/students/student_details.js"></script>
</body>

</html>
<?php } ?>