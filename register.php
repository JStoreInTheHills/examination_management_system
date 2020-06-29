<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SSRMS || Register</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="./dist/css/main.min.css" rel="stylesheet">

</head>

<body class="bg-gray-100">

  <div class="container">

    <div class="card o-hidden border-2 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">

          <div class="col-md-12">
            <div class="p-5">
              <div class="text-center mb-4">
                <img src="/img/favicon.jpeg" width="15%" height="15%" alt="">
                <h1 class="h4 text-gray-900">Al Madrasatul Munawwarah Al-Islamiya</h1>
                <h4 class="text-gray-600">New Account</h4>
              </div>

              <form class="user" id="register_form">
                <div class="form-group">
                  <label for="first_name">First Name</label>
                  <input type="text" class="form-control form-control-user" id="first_name" required
                    placeholder="E.g 'Salim' , Mohamed' e.t.c">
                </div>
                <div class="form-group">
                  <label for="last_name">Last Name</label>
                  <input type="text" class="form-control form-control-user" id="last_name" required
                    placeholder="E.g 'Juma', 'Swaleh' e.t.c">
                </div>
                <div class="form-group">
                  <label for="email">Email Address</label>
                  <input type="email" class="form-control form-control-user" id="email" required
                    placeholder="E.g 'salimjjuma@gmai;.com' e.t.c">
                </div>
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" class="form-control form-control-user" id="username" required
                    placeholder="E.g 'Salim', 'Mohamed'">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="password">Password</label>
                    <input type="password" class="form-control form-control-user" id="password" required
                      placeholder="Password">
                  </div>
                  <div class="col-sm-6">
                    <label for="repeat-password">Re enter Password</label>
                    <input type="password" class="form-control form-control-user" id="repeat-password" required
                      placeholder="Repeat Password">
                  </div>
                </div>
                <div class="form-group">
                  <button id="register_button" class="btn btn-primary btn-user btn-block">
                    Register Account
                  </button>
                </div>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="login.php">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <script src="./dist/js/main.min.js"></script>
  <script>
    $(function () {
      $("#register_form").on("submit", function (e) {
        e.preventDefault();
        var formData = {
          first_name: $("#first_name").val(),
          last_name: $("#last_name").val(),
          email: $("#email").val(),
          username: $("#username").val(),
          password: $("#password").val(),
          repeat_password: $("#repeat-password").val(),
        };

        if (formData.password !== formData.repeat_password) {
          iziToast.error({
            title: "Error",
            position: "topRight",
            message: "Password Dont Match.. Check the Username and Password..",
          });
        } else {
          $.ajax({
            url: "./admin/queries/add_user.php",
            type: "POST",
            data: formData,
          }).done(function (response) {
            var arr = JSON.parse(response);

            if (arr.success === true) {
              iziToast.success({
                title: "Success",
                position: "topRight",
                message: arr.message,
              });
            } else {
              iziToast.error({
                title: "Error",
                position: "topRight",
                message: arr.message,
              });
            }
          });
        }
      });
    });
  </script>

</body>

</html>