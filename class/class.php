<?php

session_start();

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 900){
    header("Location: /login.php");
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
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage || Streams</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../dist/css/main.min.css" rel="stylesheet">
    <style>
        #class_add_card{
            display: none;
        }
    </style>
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <?php include "./../layouts/sidebar.php"; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <?php include './../layouts/topbar.php' ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">

             <!-- Page Heading -->
            

              <!-- Page Heading -->
              <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-2 text-gray-800"> Manage Streams  </h1>
                    <a class="btn btn-sm btn-primary" id="add_class" href="#">Add Stream</a>
                </div>

            <nav aria-label="breadcrumb mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Streams</li>
                    </ol>
                </nav>

                <!-- DataTales Example -->
                <div id="class_main_content" class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <span><i class="fas fa-chalkboard-teacher"></i></span>    
                        All Streams</h6>
                        <div class="dropdown no-arrow">
                            <button class="btn btn-outline-primary btn-sm">
                                <span><i class="fas fa-file-pdf"></i></span> Generate PDF</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="class_table" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Stream Name</th>
                                    <th>Stream Code</th>
                                    <th>Class</th>
                                    <th>Subjects</th>
                                    <th>Students</th>
                                    <th class="text-center sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 100px;">Actions</th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                    </div>

                </div>

                <!-- Class Add Card -->
                <div id="class_add_card" class="card shadow col-md-6 mb-4 mx-auto">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add Stream</h6>
                    </div>
                    <div class="card-body">
                        <form id="class_form" class="user">
                            <div class="row">
                            
                            
                                <div class="form-group col-sm-12 mb-3">
                                    <label>Stream Name</label>
                                    <input type="text" id="ClassName" class="form-control" name="ClassName" placeholder="E.g 'Raudha' , 'Thanawii' " >
                                </div>
                            
                            
                           
                                    <div class="form-group col-sm-12  mb-3">
                                        <label>Stream Unique Code</label>
                                        <input type="text" id="ClassNameNumeric" class="form-control" name="ClassNameNumeric" 
                                        placeholder="E.g '0CRB', 'OCRG'" >
                                    </div>
                           
                           

                           
                                <div class="form-group col-sm-12 mb-3">
                                    <label>Choose a Class</label>
                                    <select name="stream_id" id="stream_id" class="form-control">
                                        <?php
                                        include "../config/config.php";

                                        $sql = "SELECT stream_id, name from stream";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {   ?>
                                                <option value="<?php echo htmlentities($result->stream_id); ?>"><?php echo htmlentities($result->name); ?>&nbsp;</option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>

                           
                            </div>

                            <div class="btn-group">
                                <button class="btn btn-primary" name="submit" type="submit">Save</button>
                                <button class="btn btn-danger" id="cancel_add_class" >Cancel</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

       <?php include '../layouts/footer.php'; ?>

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<?php include '../layouts/utils/logout_modal.html'; ?>

<script src="/dist/js/main.min.js"></script>
<script src="/dist/js/classes/class.js"></script>

</body>

</html>

<?php } ?>