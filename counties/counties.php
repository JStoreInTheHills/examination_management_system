<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup ~ Addresses</title>

    <!-- Custom fonts for this template -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="/vendor/fontawesome-free/css/all.css" rel="stylesheet" type="text/css">
    <link href="/dist/css/main.min.css" rel="stylesheet" type="text/css">

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
                        <h1 class="h3 mb-0 text-gray-800" id="heading"> <span><i class="fas fa-address-card"></i></span>
                            Setup Counties And Physical Addresses </h1>
                    </div>

                    <nav aria-label="breadcrumb mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a>Counties</a></li>
                        </ol>
                    </nav>

                    <!-- start of row -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card shadow mb-4">
                                <div class="m-0 card-header text-primary">
                                    <span><i class="fas fa-address-card"></i></span> Physical Addresses / Counties
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="counties_table" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>County Name</th>
                                                    <th>County Code</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!------------------------------------------------------------------------------------------------->
                        
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
        $('#counties_table').DataTable({
            "order": [[ 1, "asc" ]],   
            ajax: {
                url: "queries/get_all_counties.php",
                type: "GET",
                dataSrc: "",
            },columnDefs : [
                {
                    "targets" : 0,
                    "data" : "name",
                },
                {
                    "targets" : 1,
                    "data" : "code",
                },
            ]
            
        });
        $('#county_form').on('submit', function(event){
            event.preventDefault();

            let formData = {
                "county_name" : $('#county_name').val(),
                "county_code" : $('#county_code').val()
            };

            if(formData.county_code.length < 3){
                iziToast.info({
                    type : "Info",
                    message : "County Code cannot be less than 3 digits.",
                    position : "topRight",
                });
            }

            $.ajax({
                url : "queries/add_county.php",
                type : "POST",
                data : formData,
                dataSrc : "",
            })

            console.log(formData);
        })
    </script>

</body>

</html>
