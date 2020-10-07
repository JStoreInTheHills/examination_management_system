<?php

session_start();

// include "./layouts/utils/redirect.php";

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500){
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
  <meta name="description" content="Student Management Application that monitors students performance">
  <meta name="author" content="Jsoreinthehills">

  <title id="index_title"></title>

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

        <?php include '_partials/index_.php'; ?>

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
  <script src="/dist/js/utils/utils.js"></script>
</body>

</html>

<?php } ?>