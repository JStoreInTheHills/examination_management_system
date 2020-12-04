<?php
    include "../../layouts/utils/redirect.php";

    if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500 || !isset($_SESSION['role_id'])){
        redirectToHomePage();
    }else{
        $_SESSION['last_login_timestamp'] = time();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">

  <title id="title"></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
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

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <?php include '../../layouts/topbar.php' ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h1 class="h3 mb-2 text-gray-800" id="user_name">
            </h1>
          </div>

          <!--
             Brief alert notification to the user that is viewing the page.  
            -->
          <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>Manage your info, privacy, and security to make Al Munawwarah Examination System work better for you</strong>
            <hr>
            <p class="mb-0">Save periodic changes by click on the save changes. </p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <!--
             Breadcrumb used to navigate the page from one page to the other.  
            -->
          <nav aria-label="breadcrumb mb-2">
            <ol class="breadcrumb" id="breadcrumb">
             
            </ol>
          </nav>

          <div class="row mb-4">
            <!--
             Start of the row.
             The furthest column on the left side of the page.
             Contains links to different section of the page. 
            -->
            <div class="col-md-5 col-xl-4">

              <div class="card mb-2">
               
                <div class="list-group list-group-flush" role="tablist">
                  <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account"
                    role="tab">
                    Account
                  </a>
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#password" role="tab">
                    Password
                  </a>
                </div>
              </div>

            </div>

            <!--
             The furthest column on the right side of the page.
             Contains section of the pages to change and edit settings. 
            -->

            <div class="col-md-7 col-xl-8">
              <div class="tab-content">
                <div class="tab-pane fade show active" id="account" role="tabpanel">

                  <!-- Public Card -->
                  <div class="card shadow mb-2 ">
                    <div class="card-header">
                      <h5 class="card-title mb-0 text-primary">Public info</h5>
                    </div>
                    <div class="card-body">

                      <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>This section of the page and the form below is used if you want to change the username
                          or edit your biography.</strong>
                        <hr>
                        <p class="mb-0">Save periodic changes by click on the save changes button. </p>

                      </div>

                      <form id="public_info">
                        <div class="row">
                          <div class="col-md-12">
                            <input type="hidden" name="uuid" id="uuid">

                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label class="text-primary" for="inputEmail4">Email</label>
                                <input type="email" class="form-control" name="inputEmail4" id="inputEmail4"
                                  placeholder="Email">
                              </div>
                              <div class="form-group col-md-6">
                                <label class="text-primary" for="inputUsername">Username</label>
                                <input type="text" name="inputUsername" class="form-control" id="inputUsername"
                                  placeholder="Username">
                              </div>
                            </div>

                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label class="text-primary" for="inputFirstName">First name</label>
                                <input type="text" class="form-control" name="inputFirstName" id="inputFirstName"
                                  placeholder="First name">
                              </div>
                              <div class="form-group col-md-6">
                                <label class="text-primary" for="inputLastName">Last name</label>
                                <input type="text" class="form-control" name="inputLastName" id="inputLastName"
                                  placeholder="Last name">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="text-primary" for="inputUsername">Bio-graphy</label>
                              <textarea rows="2" class="form-control" id="inputBio" name="inputBio"
                                placeholder="Write something about yourself"></textarea>
                            </div>
                          </div>

                        </div>

                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </form>

                    </div>
                  </div>
                  <!-- Private Card -->
                  <!-- <div class="card shadow">

                    <div class="card-header">
                      <h5 class="card-title mb-0 text-primary">Teachers Private info</h5>
                    </div>

                    <div class="card-body">

                      <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <strong>This section of the page and the form below is used if you want to change
                          your private information including your name, email addresses postal address and county.
                        </strong>
                        <hr>
                        <p class="mb-0">Save periodic changes by click on the save changes button. </p>
                      </div>

                      <form id="private_info">

                        <input type="hidden" name="uuid" id="private_uuid">
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label class="text-primary" for="inputPhone">Phone Number</label>
                            <input type="text" class="form-control" name="inputPhone" id="inputPhone"
                              placeholder="0718596573">
                          </div>
                          <div class="form-group col-md-6">
                            <label class="text-primary" for="inputId">ID Number</label>
                            <input type="text" class="form-control" name="inputId" id="inputId">
                          </div>
                        </div>
                        <div class="form-row">

                          <div class="form-group col-md-6">
                            <label class="text-primary" for="inputAddress">Address</label>
                            <input type="text" class="form-control" name="inputAddress" id="inputAddress"
                              placeholder="Mombasa, Mvita">
                          </div>

                          <div class="form-group col-md-6">
                            <label class="text-primary" for="inputState">County</label>
                            <select style="width: 100%" id="inputState" class="form-control">
                            </select>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </form>

                    </div>
                  </div> -->
                </div>
                <!-- End of the first tab pane.   -->
                <div class="tab-pane fade" id="password" role="tabpanel">
                  <div class="card shadow">
                    <div class="card-header">
                      <h5 class="card-title mb-0 text-primary">Manage your Password</h5>
                    </div>
                    <div class="card-body">
                      <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>Use this page to view and make changes to your account password.</strong>
                        <hr>
                        <p class="mb-0">Save changes by click on the save changes. </p>

                      </div>

                      <form id="password_form" autocomplete="off" method="POST">

                        <input type="hidden" name="uuid" id="password_uuid">

                        <!-- <div class="form-group">
                          <label class="text-primary" for="inputPasswordCurrent">Current password</label>
                          <input type="password"  class="form-control"
                            id="inputPasswordCurrent">
                          <small><a href="#">Forgot your password?</a></small>
                        </div> -->
                        <div class="form-group">
                          <label class="text-primary" for="inputPasswordNew">Enter New password</label>
                          <input type="password" class="form-control" name="inputPasswordNew" id="inputPasswordNew"
                          placeholder="Enter the new password">
                        </div>
                        <div class="form-group">
                          <label class="text-primary" for="inputPasswordNew2">Verify password</label>
                          <input type="password" class="form-control" name="inputPasswordNew2" id="inputPasswordNew2"
                          placeholder="Re Enter the new password again">
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </form>

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
      <?php include '../../layouts/footer.php'; ?>

    </div>
    <!-- End of Content Wrapper -->

    <?php include '../../layouts/utils/logout_modal.html'?>

  </div>
  <!-- End of Page Wrapper -->

  <script src="/dist/js/main.min.js"></script>
  <script src="/dist/js/utils/utils.js"></script>
  <script src="/dist/js/admin/profile.js"></script>

</body>

</html>
<?php } ?>