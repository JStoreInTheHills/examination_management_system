<?php

    include "../../config/config.php";

    $eid = $_GET['eid'];

    $query = "SELECT exam_name, exam_out_of, created_at, closed, r_style, tbl_rstyle.name
              FROM exam 
              JOIN tbl_rstyle ON exam.r_style = tbl_rstyle.id
              WHERE exam_id=:exam_id";

    $sql=$dbh->prepare($query);
    $sql->bindParam(":exam_id", $eid, PDO::PARAM_STR);
    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
?>