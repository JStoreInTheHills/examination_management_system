<?php
    include "../layouts/utils/redirect.php";

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

    <title>Manage || Students</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../dist/css/main.min.css" rel="stylesheet">


    <style>
        #student_add_card {
            display: none;
        }
    </style>
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
                          <h1 class="h3 mb-2 text-gray-800"> <span><i class="fas fa-users"></i></span> Manage Students 
                          </h1>
                          <div class="btn-group">
                            <button class="btn btn-primary btn-xs" id="add_student"><span><i class="fas fa-users"></i></span>
                                Add New Students
                            </button>
                            <a class="btn btn-outline-primary btn-xs" target="_blank" href="/reports/students/summary_all_students"><span><i class="fas fa-file-pdf"></i></span>
                                    Print Report
                            </a>
                          </div>
                    </div>

                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class=" breadcrumb-item"><a href="/index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Students</li>
                        </ol>
                    </nav>

                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>All Students in the school, both inactive and active are highlighted here</strong>
                        <hr>
                            <p class="mb-0">Active students are denoted by <span class="badge badge-pill badge-success">Active</span> while In Active students are denoted by <span class="badge badge-pill badge-danger">Inactive</span> </p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div id="main_content" class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="mx font-weight-bold text-primary">
                               <span><i class="fas fa-users"></i></span> All Students</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped " id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Students Name</th>
                                            <th>Roll-Id</th>
                                            <th>Registration Date</th>
                                            <th>Stream Name</th>
                                            <th>Age</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>

                    </div>

                    <div id="student_add_card" class="col-xl-8 mx-auto col-md-8 mb-3">
                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="mx font-weight-bold text-primary">Add Student</h6>
                            </div>
                            <div class="card-body">
                                <form id="form" class="user">

                                    <label class="text-primary" for="">Student Details</label>

                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <label for="first_name">First Name</label>
                                            <input type="text" name="first_name" class="form-control" id="first_name"
                                                placeholder="Enter First Name">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="rollid"> Second Name</label>
                                            <input type="text" class="form-control" name="second_name"
                                                id="second_name" placeholder="Enter Second Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" name="last_name" class="form-control" id="last_name"
                                                placeholder="Enter Last Name">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="rollid"> Admission Number</label>
                                            <input type="text" class="form-control" name="rollid"
                                                id="rollid" placeholder="Enter Admission Number">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    <div class="col-sm-6">
                                            <label for="telephone">Telephone Number</label>
                                            <input type="text" name="telephone_no" class="form-control" id="telephone"
                                                placeholer="Enter Phone Number">
                                        </div>

                                        <div class="col-sm-6">
                                            <label for="gender">Choose Gender</label>
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <label for="classid">Choose a Class</label>
                                            <select name="id" id="classid" class="form-control ">
                                                <?php
                                            include './../config/config.php';
                                            $sql = "SELECT id, ClassName from tblclasses";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {   ?>
                                                <option value="<?php echo htmlentities($result->id); ?>">
                                                    <?php echo htmlentities($result->ClassName); ?>&nbsp;</option>
                                                <?php }
                                            } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="date">Date Of Birth</label>
                                            <input type="text" data-toggle="datepicker" name="dob" id="date"
                                                class="form-control" autocomplete="off" placeholder="2002-04-09">
                                        </div>
                                    </div>

                                    <hr>

                                    <label class="text-primary" for="">Guardian Details</label>

                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <label for="next_of_kin">Next Of Kin Name</label>
                                            <input type="text" name="Guardian Name" class="form-control"
                                                id="next_of_kin" placeholder="Enter Next Of Kin">
                                        </div>
                                       
                                    </div>

                                    <hr>

                                    <label class="text-primary" for="">Address Details</label>

                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <label for="address">Postal Address</label>
                                            <input type="text" name="address" class="form-control" id="address"
                                                placeholder="Enter Postal Code">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="county">County</label>
                                            <select name="county_id" id="county_id" class="form-control">
                                            </select>
                                        </div>
                                    </div>

                                    <hr>

                                    <div>
                                        <div class="btn-grp">
                                            <button class="btn btn-primary float-right" name="submit"
                                                type="submit">Save</button>
                                            <button class="btn btn-danger float-left" id="cancel_add">Cancel</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <?php include '../layouts/footer.php'; ?>

        </div>
        <!-- End of Content Wrapper -->

        <?php include '../../layouts/utils/logout_modal.html'?>

    </div>
    <!-- End of Page Wrapper -->

    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/utils/utils.js"></script>
    <script src="/dist/js/students/student.js"></script>
</body>

</html>

<?php } ?>
