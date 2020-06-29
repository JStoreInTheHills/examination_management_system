<?php
session_start();

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 900){
  header("Location: login.php");
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
  <meta name="description" content="Student Management Application that monitors students performance">
  <meta name="author" content="Jsoreinthehills">

  <title>SSRMS || Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/dist/css/main.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php include "layouts/sidebar.php";?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <?php include 'layouts/topbar.php'?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Al Madrasatul Munawwarah Al Islamiyah</h1>
          </div>


          <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">All Students</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800" id="all_students"></div>
                    </div>
                    <div class="col-auto">
                      <a href="/students/student.php"> <i class="fas fa-user-graduate fa-2x text-info-300"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Registered Teachers</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800" id="all_teachers"></div>
                    </div>
                    <div class="col-auto">
                      <a href="/teachers/teachers.php"> <i class="fas fa-users fa-2x text-info-300"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Streams</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800" id="all_classes"></div>
                    </div>
                    <div class="col-auto">
                      <a href="/class/class.php"> <i class="fas fa-door-open fa-2x text-primary-300"></i></a>
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

      <?php include './layouts/footer.php'; ?>

    </div>
    <!-- End of Content Wrapper -->
   <?php include 'layouts/utils/logout_modal.html'?>
  </div>
  <!-- End of Page Wrapper -->



  <script src="/dist/js/main.min.js"></script>
  <script src="/dist/js/dashboard/dashboard.js"></script>
</body>

</html>

<?php } ?>
