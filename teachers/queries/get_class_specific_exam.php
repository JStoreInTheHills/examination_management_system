<?php
    require_once "../../config/config.php";

    $class_id = $_POST['class_id'];
    $term_id = $_POST['term_id'];
    
    $query = "SELECT class_exams.id, exam.exam_id, exam_name, year_name, exam_out_of
              FROM class_exams JOIN exam 
              ON exam.exam_id = class_exams.exam_id
              JOIN year ON class_exams.year_id = year.year_id
              JOIN term_year ON term_year.term_year_id = class_exams.term_id
              WHERE class_id =:class_id 
              AND class_exams.status = 1 
              AND class_exams.term_id=:term_id";

    $sql = $dbh->prepare($query);
    $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
    $sql->bindParam(":term_id", $term_id, PDO::PARAM_STR);
    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    $data = array();

    foreach ($result as  $exam) {
        $data[] = array(
            "id" => $exam['id'],
            "text" => $exam['exam_name']
        );
    }

    echo json_encode($data);
?>