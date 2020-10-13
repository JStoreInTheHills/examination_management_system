<?php 

session_start();

if(!isset($_SESSION['alogin']) || (time() - $_SESSION['last_login_timestamp']) > 1500 || !isset($_SESSION['role_id'])){
  header("Location: /login.php");
}else{


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subject To Class</title>

    <!-- Custom fonts for this template -->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="/dist/css/main.min.css">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include "./../../layouts/sidebar.php"; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <?php include './../../layouts/topbar.php' ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">


                <nav aria-label="breadcrumb mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="/class/class.php">Classes</a></li>
                        <li id="bread_lists" class="breadcrumb-item active" aria-current="page">Add Subject To Class
                        </li>
                    </ol>
                </nav>


                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mx-auto text-gray-800" id="heading">Add Subject and Assign Teacher to Class</h1>

                </div>
                <hr>
                <div class="row">
                    <!-- Exam DataTales -->
                    <div class="col-xl-6 col-md-12 mx-auto">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <form id="add_teacher_form" action="" method="post">
                                    <div class="form-group">
                                        <label for="subject_id">Choose Class to Assign Subject:</label>
                                        <select name="class_id" id="class_id" class="form-control" ">
                                            <?php 
                                            include '../../config/config.php';
                                            $sql = "SELECT id, ClassName FROM tblclasses";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                                            foreach($results as $result){
                                                ?>
                                            <option class=" form-control form-control-user"
                                            value="<?php echo htmlentities($result->id); ?>">
                                            <?php echo htmlentities($result->ClassName); ?>
                                            </option>
                                            <?php }
                                           
                                           ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="subject_id">Choose Subject to add Class:</label>
                                        <select name="subject_id" id="subject_id" class="form-control"
                                            onClick="getSubjectTeacher(this.value);">
                                            <?php 
                                            include '../../config/config.php';
                                            $sql = "SELECT subject_id, SubjectName FROM tblsubjects";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                                            foreach($results as $result){
                                                ?>
                                            <option class="form-control form-control-user"
                                                value="<?php echo htmlentities($result->subject_id); ?>">
                                                <?php echo htmlentities($result->SubjectName); ?>
                                            </option>
                                            <?php }
                                           
                                           ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="subject_id">Assign Subject Teacher: </label>
                                        <select name="teacher_id" id="teacher_id" class="form-control"></select>
                                    </div>

                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-primary"
                                            id="save_subject_to_class">Save</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
    </div>

    <?php include '../../layouts/utils/logout_modal.html'; ?>

    <script src="/dist/js/main.min.js"></script>

    <script>
        

        function getSubjectTeacher(val) {
            $.ajax({
                url: '../queries/get_subject_teacher.php',
                type: 'get',
                data: {
                    subject_id: val,
                },
            }).done(function (response) {
                let res = JSON.parse(response);
                res.forEach((element) => {
                    subject_id.append(
                        `<option value="${element.teacher_id}">${element.name}</option>`
                    );
                });
            });
        }

        $('#add_teacher_form').on('submit', function (e) {
            e.preventDefault();
            formData = {
                class_id: $('#class_id').val(),
                subject_id: $('#subject_id').val(),
                teacher_id: $('#teacher_id').val(),
            }
            $.ajax({
                url: '../queries/add_subject_to_class.php',
                type: 'post',
                data: formData,
                dataSrc: "",
            }).done(function (response) {
                let r = JSON.parse(response);
                if(r.success === true){
                    iziToast.success({
                    title: "Success",
                    icon: "fas fa-user-graduate",
                    transitionIn: "bounceInLeft",
                    position: "topRight",
                    message: r.message,
                    onClosing: function () {
                        $("#add_teacher_form").each(function () {
                            this.reset();
                        });
                    },
                });
                }else{
                    iziToast.error({
                    title: "Error",
                    icon: "fas fa-user-graduate",
                    transitionIn: "bounceInLeft",
                    position: "bottomRight",
                    message: r.message,
                   
                });
                }
                
            })
        })
    </script>
</body>

</html>

    <?php } ?>