<?php
session_start(); // start a session 

// check to see if the session has been started and unset the active session.
if(isset($_SESSION['alogin'])){
  unset($_SESSION['alogin']);
  session_destroy(); // destroy session
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Teachers || Login</title>

  <!-- Custom fonts for this template-->
  <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/dist/css/main.min.css" rel="stylesheet">


  <style>
    .ff {
      color: red;
    }

    .success {
      color: green;
    }

    .border {
      border
    }
  </style>

</head>

<body>

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-6 col-lg-6 col-md-6">

        <div class="card o-hidden border my-2">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <img class="mb-3" src="/img/favicon.jpeg" width="50%" alt="">
                    <h1 class="h4 text-gray-900 mb-2">Al Madrasatul Munawarah Al Islamiyyah</h1>
                    <h1 class="text-primary h4 mb-3">Teachers Sign In!</h1>
                  </div>

                  <div id="toast">
                  
                  </div>
                 

                  <form class="user mb-3" id="login_form">
                    <div class="form-group">
                      <label class="text-primary" id="email_label" for="">ID Number:</label>
                      <input type="text" class="form-control form-control-user" id="exampleInputId"
                        aria-describedby="emailHelp" autocomplete placeholder="Enter ID Number...">
                    </div>
                    <div class="form-group">
                      <label class="text-primary" id="pass_label" for="exampleInputPassword">Password:</label>
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword"
                        placeholder="Enter Password..." autocomplete>
                    </div>
                    <button name="submit" id="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>

                  <div class="text-center">
                    <a class="small" href="/login.php">Administrator Login</a>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <script src="/dist/js/main.min.js"></script>

  <script src="/dist/js/teachers/tlog.js"> </script>
</body>

</html>
