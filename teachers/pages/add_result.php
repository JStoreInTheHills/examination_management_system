<?php 
    session_start();
    include '../../layouts/utils/redirect.php';

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

                    <a class="btn btn-md text-primary mb-2" onclick="goBack()"> <i class="fas fa-arrow-left"></i> Back
                        to previous page</a>

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        <h1 class="h3 mb-0 text-gray-800" id="heading"></h1>

                        <h1 class="h3 mb-0 text-gray-800" id="Subject_Taught"></h1>

                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between mb-2">

                        <h1 class="h6 mb-0 text-gray-800" id="SubjectCreationDate"></h1>

                        <h1 class="h5 mb-0 text-gray-800" id="status"></h1>

                    </div>
                    <hr>

                    <div class="alert alert-warning alert-dismissible fade show shadow border-0" role="alert">
                        <div class="align-items-center justify-content-between">

                            <p><strong>Use this button if you want to change Ownership of a subject to another teacher
                                    or in the case where a teacher is not available.
                                    Click on Transfer Ownership of Subject to transfer Ownership from one teacher to the
                                    other.</strong></p>
                            <button class="btn btn-md btn-primary" id="change_ownership">Transfer Ownership of Subject
                                to Another Teacher</button>
                        </div>

                    </div>

                    <hr>




                    <div id="errror" class=""></div>
                    <!-- <hr> -->

                    <div class="d-sm-flex align-items-center justify-content-between mb-1">
                        <h3 class="m-0 text-gray-800 mb-1" id="class_teacher_modal_title"></h3>
                    </div>
                    <div id="toast"></div>
                    <!-- start of row -->
                    <div class="row">

                        <div class="col-lg-12 mb-1">
                            <div id="add_result" class="card border-bottom-primary mb-2">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary"> Add Result
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form id="subject_teachers_form" method="post">

                                        <input id="class_id" name="class_id" type="hidden">

                                        <input id="subject_id" name="subject_id" type="hidden">

                                        <div class="row">

                                            <div class="form-group col-md-4">
                                                <label for="year_id" class="m-0 font-weight-bold text-primary"
                                                    id="year_label">Choose a
                                                    Year</label>
                                                <select name="year_id" id="year_id"
                                                    class="form-control select"></select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="term_id" class="m-0 font-weight-bold text-primary"
                                                    id="term_label">Choose a
                                                    Term</label>
                                                <select name="term_name" id="term_name"
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

                            <p class="text-center"> <strong> Student Subject Performance </strong></p>
                            <hr>

                            <div class="alert alert-success alert-dismissible fade show mb-2" role="alert">
                                <strong>Table below shows the results that you have already declared.</strong>
                                <hr>
                                <p class="mb-0">Click edit result on the furthest right for student to edit their
                                    results.
                                </p>
                            </div>
                            <div id="main_content" class="card border-primary mb-4">
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

    <?php include '../includes/edit_students_marks_modal.html' ?>
    <?php include '../includes/transfer_ownership_modal.html' ?>
    <?php include '../../admin/auth.html' ?>
    
    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/utils/utils.js"></script>
    <script src="/dist/js/teachers/add_result.js"></script>

</body>

</html>

<?php } ?>