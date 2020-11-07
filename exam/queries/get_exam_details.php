<?php

    include "../../config/config.php";

    $eid = $_GET['eid'];

    $query = "SELECT exam_name, exam_out_of, created_at, closed
              FROM exam 
              WHERE exam_id=:exam_id";

    $sql=$dbh->prepare($query);
    $sql->bindParam(":exam_id", $eid, PDO::PARAM_STR);
    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
?>