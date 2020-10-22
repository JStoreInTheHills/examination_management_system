<?php 

    include '../../config/config.php';
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

    <title id="title"></title>

    <!-- Custom fonts for this template -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="/vendor/fontawesome-free/css/all.css" rel="stylesheet" type="text/css">
    <link href="/dist/css/main.min.css" rel="stylesheet" type="text/css">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include '../../layouts/topbar.php' ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        <h1 class="h3 mb-0 text-gray-800" id="heading">
                            <span><i class="fas fa-users"></i></span>
                        </h1>

                        <h1 class="h3 mb-0 text-gray-800" id="Subject_Taught">
                        </h1>


                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        
                        <h1 class="h6 mb-0 text-gray-800" id="SubjectCreationDate"></h1>

                        <h1 class="h5 mb-0 text-gray-800" id="status">
                        </h1>

                    </div>

                    <hr>

                    <nav aria-label="breadcrumb mb-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="" id="my_classes">My Classes </a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a id="active_class"></a></li>
                        </ol>
                    </nav>

                    <div id="toast"></div>

                    <div id="errror" class=""></div>
                    <hr>

                    <h2 class="m-0 text-gray-800 mb-3" id="class_teacher_modal_title"></h2>
                    <!-- start of row -->
                    <div class="row">

                        <div class="col-lg-12 mb-1">
                            <div id="add_result" class="card shadow mb-2">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary"> Add Result
                                    </h6>
                                </div>
                                <div class="card-body">
                                <form id="subject_teachers_form" method="post">
                                     
                                        <input id="class_id" name="class_id" type="hidden" >

                                        <input id="subject_id" name="subject_id" type="hidden" >

                                        <div class="row">

                                            <div class="form-group col-md-4">
                                                <label for="year_id" class="m-0 font-weight-bold text-primary"
                                                    id="year_label">Choose a
                                                    Year</label>
                                                <select name="year_id" id="year_id" class="form-control select">
                                                    <option readonly value="">Choose a year</option>
                                                <option readonly value="">Choose a year</option>    
                                                    <option readonly value="">Choose a year</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="term_id" class="m-0 font-weight-bold text-primary"
                                                    id="term_label">Choose a
                                                    Term</label>
                                                <select name="term_name" id="term_name" onclick="getExam(value)"
                                                    class="form-control select"></select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label class="m-0 font-weight-bold text-primary" id="exam_label"
                                                    for="exam_id">Choose an
                                                    Exam: </label>
                                                <select class="form-control select" name="exam_id" id="exam_id">
                                                </select>
                                                <small class="text-primary" id="exam_out_of_badge"></small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-8">
                                                <label class="m-0 font-weight-bold text-primary"
                                                    for="students_id">Choose a Student: </label>
                                                <select name="students_id" class="form-control" id="students_id">
                                                </select>
                                                <small class="text-muted">Check the Admission number inside the bracket
                                                    to choose the right student
                                                </small>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label class="m-0 font-weight-bold text-primary" for="marks"
                                                    id="label_for_marks">Enter
                                                    Subject Marks</label>
                                                <input type="text" class="form-control" id="marks" name="marks">
                                                <label for="marks" class="label_error text-danger"></label>
                                            </div>

                                        </div>

                                        <div class="btn-group">
                                            <button class="btn btn-primary btn-md" id="btnSubmit">
                                                Save
                                            </button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-1">
                            <div id="main_content" class="card shadow mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary"> <span><i
                                                class="fas fa-users"></i></span>
                                        Class Performance
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="teachers_subject_table" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Admin#</th>
                                                    <th>Exam Name</th>
                                                    <th>Publish Date</th>
                                                    <th>Subject Performance</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
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
    <?php include '../../layouts/utils/logout_modal.html'; ?>

    <div class="modal fade" id="edit_students_marks" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="class_teacher_modal" aria-hidden="true">

        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="class_teacher_modal">
                        <span><i class="fas fa-user"></i></span> Change Students Results</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_students_subject_results">
                        <div class="row">
                            <input type="hidden" id="edit_students_id" name="students_id">
                            <input type="hidden" id="edit_exam_id" name="edit_exam_id">
                            <input type="hidden" id="edit_result_id" name="edit_result_id">

                            <div class="form-group col-md-12">
                                <label class="text-primary" for="students_name">Student Name: </label>
                                <input disabled type="text" class="form-control" name="students_name"
                                    id="students_name">
                                </input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-primary" for="subject_id">Enter Marks</label>
                                <input name="students_marks" id="students_marks" class="form-control">
                                </input>
                            </div>

                        </div>

                    </form>

                </div>

                <div class="modal-footer btn-group">
                    <button class="btn btn-dark" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" id="edit_students_result_submit">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/utils/utils.js"></script>
    <script src="/dist/js/teachers/add_result.js"></script>
   
</body>

</html>

<?php } ?>