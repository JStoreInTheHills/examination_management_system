<?php 

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

    <title>Manage || Users</title>

    <!-- Custom fonts for this template -->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/dist/css/main.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include "../../layouts/sidebar.php"; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include '../../layouts/topbar.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        <h1 class="h3 mb-2 text-gray-800">
                            <span><i class="fas fa-users"></i></span>
                            Manage All Users
                        </h1>
                        
                    </div>
                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Users</li>
                        </ol>
                    </nav>

                    <hr>
                    <div id="user_add_card">
                        <div class="card mb-2">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <span><i class="fas fa-users"></i></span>
                                    Add New User
                                </h6>
                            </div>
                            <div class="card-body">
                                <form id="user_form">
                                    <div class="form-group row">
                                        <div class="col-sm-4 mb-2 mb-sm-0">
                                            <label class="text-primary" for="firstname">First Name: </label>
                                            <input type="text" name="firstname" class="form-control" id="firstname"
                                                   placeholder="Enter First Name" autocomplete="off">

                                        </div>

                                        <div class="col-sm-4 mb-2">
                                            <label class="text-primary" for="lastname">Last Name: </label>
                                            <input type="text" name="lastname" class="form-control" id="lastname"
                                                   placeholder="Enter Last Name" autocomplete="off">

                                        </div>

                                        <div class="col-sm-4 mb-2">
                                            <label class="text-primary" for="username">User Name: </label>
                                            <input type="text" name="username" class="form-control" id="username"
                                                   placeholder="Enter Username" autocomplete="off">

                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-4 mb-2 mb-sm-0">
                                            <label class="text-primary" for="email">Email Address:</label>
                                            <input type="email" name="emailid" id="email" class="form-control "
                                                   placeholder="Enter Email Address" autocomplete="off">
                                            <small id="emailHelp" class="form-text text-muted">Ex. salimjjuma@gmail.com,
                                                ali.sud@gmail.com</small>
                                        </div>

                                        <div class="col-sm-4 mb-2 mb-sm-0">
                                            <label class="text-primary" for="password">Enter Password:</label>
                                            <input type="password" name="password" id="password" class="form-control "
                                                   placeholder="Enter Password" autocomplete="off">
                                            <small id="emailHelp" class="form-text text-muted">Password should be
                                                greater than 8 digits.</small>
                                        </div>

                                        <div class="col-sm-4 mb-2 mb-sm-0">
                                            <label class="text-primary" for="repeatPassword">Re - Enter Password:</label>
                                            <input type="password" name="repeatPassword" id="repeatPassword" class="form-control "
                                                   placeholder="Enter Password" autocomplete="off">

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-4 mb-2 mb-sm-0">
                                            <label class="text-primary" for="roleFlag">Select Role</label>
                                            <select class="custom-select" id="role_select">
                                            </select>
                                            <small id="emailHelp" class="form-text text-muted">Choose a role for the user Ex. Teacher or Admin</small>
                                        </div>
                                    </div>

                                    <div class="btn-group">
                                        <button class="btn btn-primary" name="submit" type="submit">Save</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div id="main_content" class="card mb-2">
                        <!-- Card Header - Dropdown -->
                         <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="mx font-weight-bold text-primary">
                                <span><i class="fas fa-users"></i></span> All Users
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="users_table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email Address</th>
                                            <th>Registered at</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <?php include '../../layouts/footer.php'; ?>

        </div>
        <!-- End of Content Wrapper -->

        <?php include '../../layouts/utils/logout_modal.html'?>

    </div>
    <!-- End of Page Wrapper -->

    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/admin/new_user.js"></script>
    <script src="/dist/js/utils/utils.js"></script>

</body>

</html>

<?php } ?>