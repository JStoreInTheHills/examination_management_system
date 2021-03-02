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

<?php include "../../_partials/css_files.php"; ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php 

            if($_SESSION['role_id'] == 1){
                include "../layouts/sidebar.php";
            }        
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include '../../layouts/topbar.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <a class="btn btn-md text-primary mb-2" onclick="goBack()"> <i class="fas fa-arrow-left"></i> Back to previous page</a>

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-3">
                        <h1 class="h3 mb-0 text-gray-900" id="heading"></h1>

                        <div class="btn-group">

                            <button id="edit_teacher_btn" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                data-target="#edit_teacher">
                            </button>

                            <?php 
                             if($_SESSION['role_id'] == 1){
                                 echo '<button id="btn_add_subject_teacher" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#add_class_teacher">
                                    <span><i class="fas fa-users"></i> </span> Add Teacher Subject
                                </button>
                                ';
                             }
                            ?>
                            <!-- <button class="btn btn-outline-primary btn-md" id="btn_print_subjects">
                                        Subject Report
                                </button> -->
                        </div>
                    </div>

                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        <h1 class="h5 mb-0 text-gray-900" id="email"></h1>
                        <h1 class="h5 mb-0 text-gray-900" id="CreationDate"></h1>
                    </div>

                    <div class="d-sm-flex align-items-center justify-content-between mb-3">
                        <h1 class="h5 mb-0 text-gray-900" id="id_no"></h1>
                        <h1 class="h5 mb-0 text-gray-900" id="teacher_address"></h1>
                    </div>

                    <div class="d-sm-flex align-items-center justify-content-between mb-3">
                        <h1 class="h4 mb-0 text-gray-900" id="status"></h1>
                    </div>
                    <?php 

                    if($_SESSION['role_id'] == 1){
                        echo '<nav aria-label="breadcrumb mb-3">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/index">Home</a></li>
                                <li class="breadcrumb-item"><a href="../teachers">All Teachers </a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a>All Teachers</a></li>
                            </ol>
                        </nav>';                    
                    }
                    ?>

                    <hr class="my-3">

                    <div class="alert alert-info alert-dismissible fade show mb-1" role="alert">
                        <strong>Use these if you want to change Ownership of a teacher. </strong>
                        <hr class="my-2">
                        <div class="d-sm-flex align-items-center justify-content-between mb-0">
                            <p class="mb-0">Click on change Ownership to transfer Ownership from one teacher to the other.</p>

                            <button class="btn btn-md btn-primary" id="change_ownership">Change Ownership</button>
                        </div>
                    </div>

                    
                    <hr class="my-3">

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Choose the class you teach and click on it to enter marks for the subject.</strong>
                        <hr>
                        <p class="mb-0">Click on the <span><a href="" data-toggle="modal" data-target="#edit_teacher">Edit Teacher</a></span>  to edit this teacher.</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- start of row -->
                    <div class="row">
                        <div class="col-lg-12 mb-2">
                            <div id="main_content" class="card shadow mb-2">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <p class="m-0 font-weight-bold text-primary"> <span><i
                                                class="fas fa-users"></i></span>
                                        Classes and the respective subjects that you teach
                                </p>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="teachers_subject_table" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Class Name</th>
                                                    <th>Subject Name</th>
                                                    <th>Subject Code</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-lg-4 mb-2">
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Teachers' Details</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <!-- <li id="teachers_name" class="list-group-item"></li> -->
                                        <!-- <li id="id_no" class="list-group-item"></li> -->
                                        <!-- <li id="email" class="list-group-item"></li> -->
                                        <!-- <li id="gender" class="list-group-item"></li> -->
                                        <!-- <li id="CreationDate" class="list-group-item"></li> -->
                                        <!-- <li id="teacher_address" class="list-group-item"></li> -->
                                        <!-- <li id="county" class="list-group-item"></li> -->
                                    <!-- </ul> -->
                                <!-- </div> -->
                            <!-- </div> -->

                        <!-- </div> -->
                    </div>
                    <!-- endo of row -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include '../../layouts/footer.php'; ?>
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php include '../../layouts/utils/logout_modal.html'; ?>

    <div class="modal fade" id="add_class_teacher" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="class_teacher_modal" aria-hidden="true">

        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="class_teacher_modal">
                        <span><i class="fas fa-users"></i></span> Add Teacher Specialization</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="subject_teachers_form">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-primary" for="class_id">Choose a Class: </label>
                                <select class="custom-select" name="class_id" id="class_id">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-primary" for="subject_id">Choose a Subject: </label>
                                <select name="subject_id" id="subject_id" class="custom-select">
                                </select>
                            </div>

                        </div>

                    </form>

                </div>

                <div class="modal-footer btn-group">
                    <button class="btn btn-dark" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" id="add_subject_teacher_submit">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_teacher" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="class_teacher_modal" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="edit_teacher_heading">
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_teachers_form">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-primary" for="edit_teachers_name"> Enter Teachers Name : </label>
                                <input type="text" class="form-control" name="edit_teachers_name"
                                    id="edit_teachers_name">
                                </input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-primary" for="edit_id_no">Enter ID Number : </label>
                                <input type="text" name="edit_id_no" id="edit_id_no" class="form-control">
                                </input>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-primary" for="edit_phone">Enter Phone Number : </label>
                                <input type="text" name="edit_phone" id="edit_phone" class="form-control">
                                </input>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-primary" for="edit_gender">Choose a Gender</label>
                                <select name="edit_gender" id="edit_gender" class="form-control">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-primary" for="address">Address : </label>
                                <input type="text" name="address" id="address" class="form-control">
                                </input>
                            </div>
                        </div>

                    </form>

                </div>

                <div class="modal-footer btn-group">
                    <button class="btn btn-dark" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" id="edit_teachers_details">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/utils/school.js"></script>
    <script src="/dist/js/utils/utils.js"></script>
    <script src="/dist/js/teachers/view_teacher.js"></script>
</body>

</html>

<?php } ?>