<?php

    include "../../config/config.php";

    $stdid = $_GET['stdid'];
    $ceid = $_GET['ceid'];

    $query = "SELECT result.subject_id, marks, SubjectName 
              FROM result 
              LEFT JOIN tblsubjectcombination tsc 
              ON  tsc.id = result.subject_id 
              LEFT JOIN tblsubjects s 
              ON s.subject_id = tsc.SubjectId 
              WHERE students_id =:stdid 
              AND class_exam_id =:ceid 
              ORDER BY s.subject_id";

    $sql = $dbh->prepare($query);
    $sql->bindParam(":stdid", $stdid, PDO::PARAM_STR);
    $sql->bindParam(":ceid", $ceid, PDO::PARAM_STR);
    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);

?>