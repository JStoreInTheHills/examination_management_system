<?php include '../../config/config.php';

session_start();

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 900){
    header("Location: /login");
    exit;
}else{
      $_SESSION['last_login_timestamp'] = time();
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id=title></title>

    <!-- Custom fonts for this template -->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="/dist/css/main.min.css">
</head>

<body id="page-top">

    <div id="wrapper">

        <?php include "./../../layouts/sidebar.php"; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <?php include './../../layouts/topbar.php' ?>

            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800" id="heading"> </h1>
                </div>

                <nav aria-label="breadcrumb mb-3">
                    <ol class="breadcrumb">
                        <li class=" breadcrumb-item"><a href="/index">Home</a></li>
                        <li class="breadcrumb-item"><a href="/students/student">All Students</a></li>
                        <li id="nav" class="breadcrumb-item active" aria-current="page"></li>
                    </ol>
                </nav>

                <div class="row ">
                    <div class="col-lg-8 mb-2">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Overall Students Performance</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="myAreaChart"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Student Details</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li id="students_name" class="list-group-item">Name:</li>
                                    <li id="RollId" class="list-group-item">Admission Number:</li>
                                    <li id="age" class="list-group-item">Age:</li>
                                    <li id="Gender" class="list-group-item">Gender:</li>
                                    <li id="DOB" class="list-group-item">Date of Birth:</li>
                                    <li id="status" class="list-group-item">Status</li>
                                    <li id="RegDate" class="list-group-item">Date of Registration:</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-lg-8">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Students Subject Performance</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="myBarChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">

                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Class Details</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li id="class_name" class="list-group-item">Class Name:</li>
                                    <li id="stream_name" class="list-group-item">Stream Name:</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

          
        </div>
    </div>

    <?php include '../../layouts/utils/logout_modal.html'; ?>

    <script src="/dist/js/main.min.js"></script>
    <script src="/dist/js/students/student_details.js"></script>
    <script src="/src/js/demo/chart-bar-demo.js"></script>
    
</body>

</html>
<?php } ?>