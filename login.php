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

  <title>Munawarah ~ Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/dist/css/main.min.css" rel="stylesheet">


  <style>
    .ff {
      color:red;
    }
    .success {
      color:green;
    }
    .border {
      border
    }
  </style>
</head>

<body class="">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-6 col-lg-6 col-md-6">

        <div class="card o-hidden border shadow-lg my-3">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                  <img src="/img/favicon.jpeg"  width="50%"  alt="">
                    <h1 class="h4 text-gray-900 mb-1">Al Madrasatul Munawarah Al Islamiyyah</h1>
                    <h1 class="h4 mb-3">Welcome Back!</h1>
                  </div>

                  <span id="toast"></span>
                  <form class="user" id="login_form">
                        <div class="form-group">
                          <label id="email_label" for="">Email Address:</label>
                          <input type="email" class="form-control form-control-user"
                           id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                        </div>
                        <div class="form-group">
                        <label id="pass_label" for="exampleInputPassword">Password:</label>
                          <input type="password" class="form-control form-control-user"
                           id="exampleInputPassword" placeholder="Enter Password...">
                        </div>
                        <button name="submit" id="submit" class="btn btn-primary btn-user btn-block">
                          Login 
                        </button>
                  </form>
                  
              <div class="text-center">
                <a class="small" href="register.php">New User? Register</a>
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

  <script>
          
          $('#login_form').on('submit', function(event){
            event.preventDefault();

            let email = $('#exampleInputEmail').val();
            let password = $('#exampleInputPassword').val();

            if(email === "" && password === ""){
           
              $('#exampleInputEmail').addClass("border border-danger");
              $('#exampleInputPassword').addClass("border border-danger");
              $('#email_label').addClass("text-danger");
              $('#pass_label').addClass("text-danger");          
            }else{
            formData = {
              "email_address" : email,
              "password" : password,
            }
            $.ajax({
              "url" : "/admin/login_attempt.php",
              "type" : "GET",
              "data" : formData,
            }).done(function(response){

              var s = JSON.parse(response)

              if(s.success === true){
                
                $('#toast').empty()
                .append(`<div class="alert alert-success" role="alert">
                        Redirecting.. Please Wait.</div>`);
                setInterval(() => {
                  document.location = './index.php'; 
                }, 100);
              }else{
                $('#toast').addClass('ff');
                $('#toast').empty().append('User Not Found! Kindly contact Examination Administrator for Assistance!');  
              }
            });

            }

            
          });

  </script>
</body>

</html>