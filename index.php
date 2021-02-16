<?php

session_start();

 include "./layouts/utils/redirect.php";

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500 || !isset($_SESSION['role_id'])){
  redirectToHomePage();
}else{
      $_SESSION['last_login_timestamp'] = time();
?>

<!DOCTYPE html>
<html lang="en">

  <?php include "./_partials/css_files.php";  ?>

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

        <?php include './layouts/utils/edit_school_modal.html'; ?>

      </div>
      <!-- End of Main Content -->

      <?php include './layouts/footer.php'; ?>

    </div>
    <!-- End of Content Wrapper -->
    <?php include 'layouts/utils/logout_modal.html'?>
  </div>
  <!-- End of Page Wrapper -->

  <script src="/dist/js/main.min.js"></script>
  <script src="/dist/js/utils/utils.js"></script>
  <script src="/dist/js/dashboard/dashboard.js"></script>
</body>

</html>

<?php } ?>
