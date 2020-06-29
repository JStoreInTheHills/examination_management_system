<?php include '../../config/config.php';


    $exam_id = $_POST['exam_id'];

    $sql = "DELETE FROM exam WHERE exam_id =:exam_id";
    $query = $dbh->prepare($sql);

    $query->bindParam(':exam_id', $exam_id, PDO::PARAM_STR);

    $query->execute();
