<?php 

include '../../config/config.php';
include "../../layouts/utils/redirect.php";

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500 || !isset($_SESSION['role_id'])){
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

        <?php include "./../../layouts/sidebar.php"; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include './../../layouts/topbar.php' ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800" id="heading"></h1>

                        <div class="dropdown">
                        	<div class="btn-group">
                        		<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm dropdown-toggle"
                                type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span><i class="fas fa-plus"> </i> Quick Add </span>
                            </button>

                            <button class="d-none d-sm-inline-block btn btn-sm btn-outline-primary" type="button"
                                data-toggle="modal" data-target="#edit_this_class">
                                <span>Edit this Stream </span>
                            </button>

                             <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-header">Tools:</div>
                                <div class="dropdown-divider"></div>

                                <a href="#" data-toggle="modal" data-target="#add_class_exam" class="dropdown-item">
                                    Add Class Exam</a>

                                <a href="#" data-toggle="modal" data-target="#add_subject_to_stream"
                                    class="dropdown-item">
                                    Add Subject To Stream</a>

                                <a href="/students/student" target="_blank" class="dropdown-item">
                                    Add Students To Stream</a>
                            </div>
                        	</div>
                          
                           

                        </div>

                    </div>

                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        <h5 class="h5 mb-0 " id="class_teacher"><span><i class="text-gray-800"> Stream Name :
                                    <a id="stream2_name" href=""></a> </i></span> </h1>

                            <h5 class="h5 mb-0 " id="creation_date"> Date Stream Was Created : <span><i
                                        class="text-gray-800" id="creationdate"></i></span> </h1>
                    </div>

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h5 class="h5 mb-0" id="class_teacher">Stream Teachers Name : <span><i><a
                                        id="classTeacher"></a></i></span> </h1>

                    </div>

                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index">Home</a></li>
                            <li class="breadcrumb-item"><a href="/class/class">Streams</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a id="bread_list"></a></li>
                        </ol>
                    </nav>

                    <div class="row">
                        <!-- Total Students -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs text-primary font-weight-bold text-uppercase mb-1">Total
                                                Students
                                            </div>
                                            <a class="h4 mb-0 font-weight-bold text-gray-800" href="#view_class_student"
                                                id="total_students_in_class"></a>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Exams Declared -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs text-primary font-weight-bold text-uppercase mb-1">Total
                                                Exams
                                            </div>
                                            <a class="h4 mb-0 font-weight-bold text-gray-800"
                                                id="total_exams_in_class"></a>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-edit fa-2x text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Subjects Declared -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs text-primary font-weight-bold text-uppercase mb-1">Total
                                                Subjects
                                            </div>
                                            <a class="h4 mb-0 font-weight-bold text-gray-800"
                                                id="total_subjects_in_class"></a>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-graduate fa-2x text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <nav class="mb-4">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#exams"
                                role="tab" aria-controls="exams" aria-selected="true"> <span><i
                                        class="fas fa-chalkboard "></i></span> Exams </a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#students"
                                role="tab" aria-controls="students" aria-selected="false"> <span><i
                                        class="fas fa-users"></i></span> All Students</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#subjects"
                                role="tab" aria-controls="nav-contact" aria-selected="false"> <span><i
                                        class="fas fa-address-book"></i></span> All Subjects and Teachers </a>
                        </div>
                    </nav>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="exams" role="tabpanel"
                                    aria-labelledby="nav-home-tab">

                                    <div class="card shadow mb-2">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Class Exam Charts</h6>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="exams_charts" height="60"></canvas>
                                        </div>
                                    </div>
                                    <div class="card shadow mb-2">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">All Class Exams</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="view_class_exams" width="100%"
                                                    cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Published At</th>
                                                            <th>Exam Name</th>
                                                            <th>Term Name</th>
                                                            <th>Exam Period</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="students" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <div class="card mb-4 shadow">
                                        <div class="card-header text-primary">
                                            <span><i class="fas fa-users"></i></span>
                                            Class Students
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="view_class_student" width="100%"
                                                    cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Student Name</th>
                                                            <th>Adm No</th>
                                                            <th>Reg Date</th>
                                                            <th>Gender</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="subjects" role="tabpanel"
                                    aria-labelledby="nav-contact-tab">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="view_class_subjects" width="100%"
                                                    cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Subject Name</th>
                                                            <th>Subject Code</th>
                                                            <th>Subject Teacher</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
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

    <!-- Exam Modal-->
    <div class="modal fade" id="add_class_exam" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exam_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="exam_modal">
                        <span><i class="fas fa-edit"></i></span> Add Exam To Class</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form id="view_class_form" class="user">

                        <input type="hidden" id="class_id_for_add_exam_modal" name="class_id_for_add_exam_modal">
                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <label class="text-primary" for="year_id">Choose academic year:</label>
                                <select style="width:100%" name="year_id" id="year_id" class="form-control">
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <label class="text-primary" for="term_id">Add Appropriate Term:</label>
                                <select name="term_id" id="term_id" class="form-control ">
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <label class="text-primary" for="exam_id">Choose an Exam:</label>
                                <select name="exam_id" id="exam_id" style="width:100%"  class="form-control "></select>
                            </div>
                        </div>

                        <div class="btn-group modal-footer">
                            <button class="btn btn-primary" type="submit">
                                Add
                            </button>
                        </div> 
                </div>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Subject Modal-->
    <div class="modal fade" id="add_subject_to_stream" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="add_subject_to_stream" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="add_subject_to_stream">
                        <span id="class_to_add_subject"></span></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form id="add_teacher_form" action="" method="post">
                        <div class="form-group">
                            <label class="text-primary" for="subject_id">Choose Subject to add Class:</label>
                            <select name="subject_id" id="subject_id" class="form-control"
                                onClick="getSubjectTeacher(this.value);">
                                <?php 
                                            $sql = "SELECT subject_id, SubjectName FROM tblsubjects";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                                            foreach($results as $result){
                                                ?>
                                <option class="form-control form-control-user"
                                    value="<?php echo htmlentities($result->subject_id); ?>">
                                    <?php echo htmlentities($result->SubjectName); ?>
                                </option>
                                <?php }
                                           
                                           ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="text-primary" for="subject_id">Assign Subject Teacher: </label>
                            <select name="teacher_id" id="teacher_id" class="form-control"></select>
                        </div>
                    </form>

                </div>

                <div class="modal-footer btn-group">
                    <button class="btn btn-dark" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" id="subject_add">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="edit_this_class" tabindex="-1" role="dialog" data-backdrop="static"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="exampleModalLongTitle">Edit this Stream</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="edit_this_class_form" method="post">
                        <div class="form-group">
                            <label for="class_name" class="text-primary">Stream Name: </label>
                            <input type="text" class="form-control" id="edit_class_name">
                        </div>
                        <div class="form-group">
                            <label for="class_name" class="text-primary">Stream Name Numerics: <i><span
                                        class="text-danger">(Class Code cannot be changed)</span></i> </label>
                            <input type="text" disabled class="form-control" id="edit_class_name_numeric">
                        </div>
                        <div class="form-group">
                            <label class="text-primary" for="edit_stream_id">Choose a Stream:</label>
                            <select name="edit_stream_id" id="edit_stream_id" class="form-control">
                                <option class="form-control form-control-user" value="">Select a stream</option>
                                <?php
                                $sql = "SELECT stream_id, name FROM stream";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                foreach($results as $result){
                                    ?>
                                <option class="form-control form-control-user"
                                    value="<?php echo htmlentities($result->stream_id); ?>">
                                    <?php echo htmlentities($result->name); ?>
                                </option>
                                <?php }

                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date" class="text-primary">Date of publishing</label>
                            <input type="date" data-toggle="datepicker" name="dob" id="edit_date" class="form-control"
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="text-primary" for="edit_teacher">Choose a class teacher:</label>
                            <select name="edit_teacher" id="edit_teacher" class="form-control">
                                <?php
                                $sql = "SELECT teacher_id, name FROM tblteachers ORDER BY name ASC";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                foreach($results as $result){
                                    ?>
                                <option class="form-control form-control-user"
                                    value="<?php echo htmlentities($result->teacher_id); ?>">
                                    <?php echo htmlentities($result->name); ?>
                                </option>
                                <?php }

                                ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="edit_class_form_submit">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/classes/view_class.js"></script>
    <script src="/dist/js/utils/utils.js"></script>
</body>


</html>
<?php } ?>