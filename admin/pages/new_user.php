<?php 

session_start();

if(strlen($_SESSION['alogin'])==""){
  header("Location: /login.php");
}else{

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage || Users</title>

    <!-- Custom fonts for this template -->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/dist/css/main.min.css" rel="stylesheet">


    <style>
        #user_add_card {
            display: none;
        }
       .invalid {
        outline-color: red;
        /* also need animation and -moz-animation */
        -webkit-animation: shake .5s linear;
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
                    <h1 class="h3 mb-2 text-gray-800"> Manage Users </h1>

                    <nav aria-label="breadcrumb mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </nav>

                    <!-- DataTales Example -->
                    <div id="main_content" class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="mxfont-weight-bold text-primary">All Users</h6>
                            
                            <div class="dropdown no-arrow">
                                <button id="add_user" class="btn btn-sm btn-primary">
                                <span><i class="fas fa-user"></i></span> Add User</button>
                                <!-- <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Tools:</div>
                                    <a class="dropdown-item" id="add_user" href="#">Add User</a>
                                </div> -->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="users_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email Address</th>
                                            <th>Created at</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>

                    </div>

                    <div id="user_add_card" class="col-xl-8 mx-auto col-md-8 mb-3">
                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary"> <span><i class="fas fa-users"></i></span> Add New Users</h6>
                            </div>
                            <div class="card-body">
                                <form id="user_form" >

                                    <div class="form-group ">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <label for="user_name">Full Name: </label>
                                            <input type="text" name="user_name" class="form-control" id="user_name"
                                                placeholder="Enter Username" autocomplete="off">
                                                <small id="emailHelp" class="form-text text-muted">Use your Official name as your username.</small>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <label for="email">Email Address:</label>
                                            <input type="email" name="emailid" id="email" class="form-control "
                                                placeholder="Enter Email Address" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <label for="password">Enter Password:</label>
                                            <input type="password" name="password" id="password" class="form-control "
                                                placeholder="Enter Password" autocomplete="off">
                                                <small id="emailHelp" class="form-text text-muted">Password should be greater than 8 digits.</small>
                                        </div>
                                    </div>
                                    <div class="btn-group float-right">
                                        <button class="btn btn-primary" name="submit" type="submit">Save</button>
                                        <button class="btn btn-danger" id="cancel_add">Cancel</button>
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
    <script src="/dist/js/admin/new_user.js"></script>
</body>

</html>

<?php } ?>