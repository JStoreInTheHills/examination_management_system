<?php 
    include "../../config/config.php";

    // Variable being passed through the GET method. 
    $class_id = $_GET['cid'];
    $class_exam_id = $_GET['ceid'];
    $students_id = $_GET['sid'];

    $query = "SELECT sub.r 
              FROM (SELECT students_id, RANK() OVER (PARTITION BY class_exam_id, class_id ORDER BY SUM(marks) DESC) r 
                    FROM result 
                    WHERE class_id =:class_id 
                    AND class_exam_id =:class_exam_id 
                    GROUP BY students_id) sub 
              WHERE students_id =:students_id";

    $sql = $dbh->prepare($query);

    $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
    $sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);
    $sql->bindParam(":students_id", $students_id, PDO::PARAM_STR);  

    $sql->execute();

    $result = $sql->fetchColumn();

    echo json_encode($result);
    exit();

?>