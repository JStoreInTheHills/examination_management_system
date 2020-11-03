<?php

session_start();
// check to see if the session has been started and unset the active session.
if(isset($_SESSION['alogin'])){
  unset($_SESSION['alogin']);
  unset($_SESSION['last_login_timestamp']);
  unset($_SESSION['role_id']);
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

  <title>Teacher || Munawwarah</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/dist/css/main.min.css" rel="stylesheet">

</head>

<body>

  <div class="container ">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-6 col-lg-6 col-md-6">

        <div class="card shadow o-hidden border my-3">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  
                  <div class="text-center">

                  <!-- <h1 class="h4 text-gray-900 mb-4">Electronic Examination Management</h1> -->

                    <img class="mb-2" src="./src/img/favicon.jpeg" width="50%" alt="">
                    <h1 class="h4 text-gray-900 mb-4">Al Madrasatul Munawarah Al Islamiyyah</h1>
                    

                    <h1 class="h4 text-primary mb-4">Teachers Portal.</h1>
                    
                    
                  </div>

                  <span id="toast"></span>
                  
                  <form class="user mb-1" id="login_form">

                    <div class="form-group">
                      <label class="text-gray-900" id="email_label" for="exampleInputEmail">
                        Email Address:
                      </label>
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                        aria-describedby="emailHelp" name="email" placeholder="Enter your Email Address...">
                    </div>

                    <div class="form-group">
                      <label class="text-gray-900" id="pass_label" for="exampleInputPassword">
                        Password:
                      </label>
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword"
                        placeholder="Enter you password..." name="password">
                    </div>
                    <button id="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>

                <hr>

                <div class="text-center">
                    <a href="./students/login">
                          <i class="fas fa-user-graduate"></i> Login As Student
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

  <script>

    sessionStorage.clear();
    
    $('#login_form').validate({
        rules : {
          email : {
            required : true,
            email : true,
          },
          password : "required"
        },

        messages : {
          email :{
            required : "Your email is required to login to the system.",
            email: "Your email address must be in the format of name@almunnawarah.ac.ke",
          },
          password : "Use the password assigned to you by the Examination officer.",
        },

        errorClass : "text-danger",

        invaidHandler : (event, validator) =>{
          const errors = validator.numberOfInvalids();
          if(errors){
            var message =  errors == 1 ? `You missed 1 field` : `You missed ${errors} fields`;
            $("#toast").html(`<div class="alert alert-danger" role="alert">
                <h4 class="alert-heading"><span><i class="fas fa-exclamation-triangle"></i></span>
                ${message}
                 </h4>
                <hr>
                <p class="mb-0">${message}</p>
              </div>`);
          $("#toast").show();
          }else{
            $("#toast").hide();
          }
        },

        submitHandler : (form)=>{
          $.ajax({
          "url": "/admin/login_attempt.php",
          "type": "POST",
          "data": $(form).serialize(),
          dataSrc : "",
          }).done((resp) => {
            const s = JSON.parse(resp);
            if (s.success === true) {
              const last_page = sessionStorage.getItem("last_page");
              const role = sessionStorage.setItem('_token', s.role);

              $('#toast').empty().append(`<div class="alert alert-success" role="alert">${s.message}.</div>`);

              if (s.role === "Teacher") {
                $.ajax({
                  url : "/admin/queries/get_login_teacher.php",
                  type : "GET",
                  data : {
                      uuid : s.uuid,
                  }
                }).done((response)=>{
                  const arr = JSON.parse(response);
                  let id;
                  arr.forEach(item => {
                      id = item.teacher_id
                  });    
                  // const new_teachers_id = sessionStorage.setItem('teachers_token', id);

                  document.location = `./teachers/pages/view_teacher?teachers_id=${id}`;
                });
              } else if (last_page == null) {
                document.location = './index';
              } else {
                document.location = last_page;
              }
            } else {
              $('#toast').empty().append(
                `<div class="alert alert-danger" role="alert">
                  <h4 class="alert-heading"><span><i class="fas fa-exclamation-triangle"></i></span>
                  User Not Found.
                  </h4>
                  <hr>
                  <p class="mb-0">Contact the Examination Officer for assistance</p>
                </div>`);
            }
          });
        }

    });
  </script>

</body>

</html>
