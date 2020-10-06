<?php

session_start();

if(strlen($_SESSION['alogin'])=="" && (time() - $_SESSION['last_login_timestamp']) > 1500){
  header("Location: /login.php");
}else{
      $_SESSION['last_login_timestamp'] = time();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>SRMS || Reports</title>

  <!-- Custom fonts for this template -->
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet" />
  <link href="../vendor/fontawesome-free/css/all.css" rel="stylesheet" type="text/css" />
  <link href="/dist/css/main.min.css" rel="stylesheet" type="text/css" />

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php include '../layouts/sidebar.php' ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">

        <?php require '../layouts/topbar.php' ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Madrasatul Reports</h1>



          <!-- Content Row -->
          <div class="row">
            <!-- First Column -->
            <div class="col-lg-6">


              <!-- Custom Text Color Utilities -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">
                    All Reports
                  </h6>
                </div>
                <div class="card-body">

                  <div class="col-lg-11 mb-4">
                    <ul>

                      <li>
                        <a> <span> <i class="text-primary fas fa-user-graduate"></i> </span> Students Reports</a>
                        <ul>
                          <li>
                            <a target="_blank" href="./students/summary_all_students.php">Summary All Students</a>
                          </li>
                          <li>
                            <a target="_blank" href="./students/detailed_all_students.php">Detailed Students Report</a>
                          </li>
                          <li>
                            <a target="_blank" href="./students/students.php?status=1">Active Students Report</a>
                          </li>
                          <li>
                            <a target="_blank" href="./students/detailed_all_students.php">In Active Students Report</a>
                          </li>
                        </ul>
                      </li>

                      <li>
                        <a> <span> <i class="text-primary fas fa-users"></i> </span> Teachers Reports</a>
                        <ul>
                          <li>
                            <a target="_blank" href="./teacher/all_teachers.php">Detailed All Teachers</a>
                          </li>
                        </ul>
                      </li>

                      <li>
                        <a> <span> <i class="text-primary fas fa-map"></i> </span> Class Reports</a>
                        <ul>
                          <li>
                            <a target="_blank" href="./class/all_classes.php">All Class Report</a>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </div>

                </div>
              </div>

            </div>

          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php require_once '../layouts/footer.php'; ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->
    <?php include '../layouts/utils/logout_modal.html'?>
  </div>
  <!-- End of Page Wrapper -->

  <script src="/dist/js/main.min.js"></script>
  <script src="/dist/js/utils/utils.js"></script>


</body>

</html>
<?php } ?>