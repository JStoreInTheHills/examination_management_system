<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All || Class Report</title>

    <!-- Custom fonts for this template -->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="/dist/css/main.min.css">

    <style>
        #query_result_card {
            display: none;
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">
        <?php include "../../layouts/sidebar.php"; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../../layouts/topbar.php' ?>
                <div class="container-fluid">

                    <div id="main_content" class="col-md-6 mx-auto card mb-4">
                        <div class="card-header">
                          Filter Class
                        </div>
                        <div class="card-body">
                            <form id="query_result_form" class="user">
                                <div class="form-group row">
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <label for="class_id">Choose Class </label>
                                        <select id="class_id" class="form-control ">
                                            <?php
                                        include './../../config/config.php';
                                        $sql = "SELECT id, ClassName from tblclasses";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {   ?>
                                            <option value="<?php echo htmlentities($result->id); ?>">
                                                <?php echo htmlentities($result->ClassName); ?>&nbsp;</option>
                                            <?php }
                                        } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="year_id">Choose Exam Period</label>
                                        <select id="year_id" class="form-control ">
                                            <?php
                                        include './../../config/config.php';
                                        $sql = "SELECT year_id, year_name from year";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {   ?>
                                            <option value="<?php echo htmlentities($result->year_id); ?>">
                                                <?php echo htmlentities($result->year_name); ?>&nbsp;</option>
                                            <?php }
                                        } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="exam_id">Choose Exam </label>
                                        <select id="exam_id" class="form-control ">
                                            <?php
                                        include './../../config/config.php';
                                        $sql = "SELECT ce.id, exam_name from exam left join class_exams ce on exam.exam_id = ce.exam_id";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {   ?>
                                            <option value="<?php echo htmlentities($result->id); ?>">
                                                <?php echo htmlentities($result->exam_name); ?>&nbsp;</option>
                                            <?php }
                                        } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="btn-group">
                                    <button class="btn btn-primary" name="submit" type="submit">Search</button>
                                </div>

                            </form>
                        </div>


                    </div>

                    <div id="query_result_card" class="card shadow mb-4 col-sm-offset-3">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Result Table ~ Exam ~ Class ~ Exam Period
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="query_result_table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Admission #</th>
                                        <th>Total Marks</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/dist/js/main.min.js"></script>
    <script>
        function createNode(element) {
            return document.createElement(element); // Create the type of element you pass in the parameters
        }

        function append(parent, el) {
            return parent.appendChild(el); // Append the second parameter(element) to the first one
        }

        const class_url = `./queries/get_all_classes.php`;
        let classes = document.getElementById('class');


        fetch(class_url)
            .then((resp) => resp.json())
            .then(function (data) {
                let items = data;
                return items.map(function (item) {
                    let option = createNode('option');

                    option.innerHTML = `${item.StudentName}`;
                    option.innerHTML = `${item.RollId}`;
                    option.innerHTML = `${item.marks}`;
                    // append(classes, option);
                });
            }).catch(function (error) {
                console.log(error); // for debugging purposes
                iziToast.error({
                    title: 'Error',
                    drag: true,
                    message: "Data for table doesn't exist",
                    position: 'bottomRight'
                });
            });

        $(function () {
            $('#query_result_form').on('submit', function (e) {
                e.preventDefault();

                let class_id = $('#class_id').val();
                let year_id = $('#year_id').val();
                let exam_id = $('#exam_id').val();

                let table_element = document.getElementById('query_result_table');

                let url =
                    `./queries/get_class_results.php?class_id=${class_id}&year_id=${year_id}&exam_id=${exam_id}`;

                $('#query_result_card').show();

                fetch(url)
                    .then((resp) => resp.json())
                    .then(function (data) {


                        return data.map(function (data_result) {
                            let option = createNode('tbody');
                            let tb = createNode('td');
                            let tb2 = createNode('td');
                            let tb3 = createNode('td');


                            tb.innerHTML = `${data_result.StudentName}`;
                            tb2.innerHTML = `${data_result.RollId}`;
                            tb3.innerHTML = `${data_result.marks}`;

                            append(option, tb);
                            append(option, tb2);
                            append(option, tb3);
                            append(table_element, option);
                        })
                    }).catch(function (error) {
                        console.log(error); // for debugging purposes
                        iziToast.error({
                            title: 'Uncaught Reference',
                            drag: true,
                            message: "Result for the Exam/Class/Year specified not found",
                            position: 'bottomRight'
                        });
                    });
            })

        });
    </script>

</body>

</html>