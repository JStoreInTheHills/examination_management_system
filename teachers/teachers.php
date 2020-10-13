<?php include '../config/config.php';

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

    <title>Manage || Teachers</title>

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
                        <h1 class="h3 mb-0 text-gray-800" id="heading"> <span><i class="fas fa-users"></i></span>
                            Manage ~ Teachers
                        </h1>
                        <div class="btn-group">

                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add_class_teacher">
                                <span><i class="fas fa-users"></i> </span> Add New Teachers
                            </button>

                            <a class="btn btn-outline-primary btn-xs" target="_blank"
                                href="/reports/teacher/all_teachers">
                                <span><i class="fas fa-file-pdf"></i> </span> Print Report</a>

                        </div>


                    </div>


                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a>All Teachers</a></li>
                        </ol>
                    </nav>


                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Teachers </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="all_students"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#"> <i class="fas fa-users fa-2x text-info-300"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Specializations with "Subject Not Assigned" are Teachers with no subjects or
                            specifications assigned.</strong>
                        <hr>
                        <p class="mb-0">Choose a teacher to add a subject or specification to them.</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- start of row -->
                    <div class="row">

                        <div class="col-lg-12">
                            <div id="main_content" class="card shadow mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="mxfont-weight-bold text-primary"> <span><i
                                                class="fas fa-users"></i></span>
                                        All Teachers</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="teachers_table" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Teachers Name</th>
                                                    <th>ID Number</th>
                                                    <th>Gender</th>
                                                    <th>Email Address</th>
                                                    <th>Phone Number</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!------------------------------------------------------------------------------------------------->
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

    <?php include '../layouts/utils/logout_modal.html'; ?>

    <div class="modal fade" id="add_class_teacher" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="class_teacher_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="class_teacher_modal">
                        <span><i class="fas fa-users"></i></span> Add Teacher</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="teachers_form">

                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong>Before you add a teacher, first add a user in the Users module.</strong>
                            <hr>
                            Click here <a href="/admin/pages/new_user" class="alert-link">Users</a> 
                                to add a new user before you continue.

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <hr>
                        <div class="row">




                            <div class="form-group col-md-12">
                                <span><i class="fas fa-chalkboard-teacher"></i></span> <label for="teachers_name"
                                    class="text-primary">Assign Teacher to User:
                                </label>
                                <select name="teachers_userId" id="teachers_userId" class="form-control"></select>
                            </div>
                        </div>

                        <hr>

                        <span><i class="fas fa-user mr-2"></i></span>
                        <label for="teachers_name" class="text-primary">Personal Information </label>

                        <div class="form-group">
                            <label class="text-primary" for="teachers_name">Teachers Name: </label>
                            <input type="text" name="teachers_name" id="teachers_name" class="form-control"
                                placeholder="Enter teachers full name">
                        </div>
                        <div class="form-group">
                            <label class="text-primary" for="teachers_name">Teachers Identification Number (ID):
                            </label>
                            <input type="number" name="teachers_id" id="teachers_id" class="form-control"
                                placeholder="Enter teachers ID number">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-primary" for="teachers_name">Teachers Phone Number: </label>
                                <input type="tel" name="teachers_phoneNumber" id="teachers_phoneNumber"
                                    class="form-control" placeholder="Enter teachers phone number">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-primary" for="gender">Choose Gender: </label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>


                        <span><i class="fas fa-address-book mr-2"></i></span> <label for="teachers_name"
                            class="text-primary">Physical Address </label>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-primary" for="teachers_name">Address: </label>
                                <input type="text" name="physicalAddress" id="physicalAddress" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="text-primary" for="teachers_name">County: </label>
                                <select name="county_id" id="county_id" class="form-control">
                                </select>
                            </div>

                        </div>




                    </form>

                </div>

                <div class="modal-footer btn-group">
                    <button class="btn btn-dark" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" id="add_teacher_submit">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/teachers/teachers.js"></script>
    <script src="/dist/js/utils/utils.js"></script>
</body>

</html>

<?php } ?>