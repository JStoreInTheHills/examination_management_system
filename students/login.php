<?php

  include "../_partials/check_session.php";

?>
<!DOCTYPE html>
<html lang="en">

  <?php include "../_partials/css_files.php"; ?>

<body>

  <div class="container mb-2">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-6 col-lg-6 col-md-6">

        <div class="card o-hidden border-0 my-4">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">

                  <div class="text-center">

                    <img class="mb-2" src="../src/img/favicon.jpeg" width="50%" alt="">

                    <h1 class="h4 text-gray-900 mb-3">
                      Al Madrasatul Munawarah Al Islamiyyah
                    </h1>


                    <h1 class="h4 text-primary mb-3">Students Portal</h1>
                  </div>

                  <span id="toast"></span>

                  <form class="user mb-1" id="login_form" autocomplete="off">

                    <div class="form-group">
                     
                      <input type="text" name="name"  class="form-control form-control-user"
                        id="exampleInputEmail" aria-describedby="emailHelp" 
                        placeholder="Enter your name...">
                    </div>

                    <div class="form-group">
                      
                      <input type="password"  class="form-control form-control-user" id="exampleInputPassword"
                        name="rollid" placeholder="Enter you admission number">
                    </div>

                    <button id="submit" class="btn btn-primary btn-user btn-block">
                      Let Me In
                    </button>
                  </form>

                  <hr class="my-4">

                  <div class="text-center">
                    <a href="/login">
                      <i class="fas fa-users"></i> Sign In As Teacher
                    </a>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <?php include './layouts/footer.php'; ?>

  <script src="/dist/js/main.min.js"></script>

  <script src="/dist/js/students/landing_page.js"></script>

</body>

</html>