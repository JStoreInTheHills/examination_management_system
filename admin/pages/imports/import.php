<?php 
session_start();

if(strlen($_SESSION['alogin'])==""){
  header("Location: /login.php");
}else{

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage || Imports</title>

    <!-- Custom fonts for this template -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../vendor/fontawesome-free/css/all.css" rel="stylesheet" type="text/css">
    <link href="../dist/css/main.min.css" rel="stylesheet" type="text/css">

    <style>
        #customFile .custom-file-input:lang(en)::after {
            content: "Select file...";
        }

        #customFile .custom-file-input:lang(en)::before {
            content: "Click me";
        }

        /*when a value is selected, this class removes the content */
        .custom-file-input.selected:lang(en)::after {
            content: "" !important;
        }

        .custom-file {
            overflow: hidden;
        }

        .custom-file-input {
            white-space: nowrap;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include "../layouts/sidebar.php"; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include '../layouts/topbar.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">



                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800" id="heading">
                            <span><i class="fas fa-download"></i></span> Imports </h1>


                    </div>

                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Imports</li>
                        </ol>
                    </nav>


                    <p>Import data from local file in .csv form</p>

                    <!-- start of row -->
                    <div class="row">


                        <div class="col-lg-6 mx-auto">
                            <div class="card shadow mb-4">
                                <div class="card-header text-primary">
                                    <span><i class="fas fa-plus"></i></span> Import File
                                </div>
                                <div class="card-body">
                                    <form id="input_file_form">
                                        <div class="form-group">
                                            
                                            <label for="custom-file-input">Choose File to Import</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                       
                                                        <input type="file" class="custom-file-input" id="myInput"
                                                            aria-describedby="myInput">
                                                        <label class="custom-file-label" for="myInput">Click Browse to Import</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            id="myInput">Import</button>
                                                    </div>
                                                </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- endo of row -->

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
    <script>
        /* show file value after file select */
        document.querySelector('.custom-file-input').addEventListener('change', function (e) {
            var fileName = document.getElementById("myInput").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName
        });

        
    </script>

</body>

</html>

<?php } ?>