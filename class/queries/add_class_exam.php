<?php

include "../../config/config.php";

    $data = array();
    $error = array();

    if(empty($_POST['exam_id']))
        $error['exam_id'] = "Exam cannot be null";

    if(empty($_POST['year_id']))
        $error['year_id'] = "Year cannot be null";

    if(!empty($error)){
        $data['success'] = false;
        $data['message'] = $error;

    }else{
        $exam_id = $_POST['exam_id'];
        $year_id = $_POST['year_id'];
        $class_id = $_POST['class_id_for_add_exam_modal'];

        $term_id = $_POST['term_id'];

        $status = 1;

        $sql = "INSERT INTO class_exams(class_id,exam_id,year_id,created_at,term_id,status)
                VALUES(:class_id,:exam_id,:year_id,CURRENT_TIMESTAMP,:term_id, :status)";

            $query=$dbh->prepare($sql);
            $query->bindParam(':class_id', $class_id, PDO::PARAM_STR);
            $query->bindParam(':exam_id', $exam_id, PDO::PARAM_STR);
            $query->bindParam(':year_id', $year_id, PDO::PARAM_STR);
            $query->bindParam(':term_id', $term_id, PDO::PARAM_STR);
            $query->bindParam(":status", $status, PDO::PARAM_STR);
            
            $query->execute();

            $er = $query->errorInfo();
            
            $lastInsertId = $dbh->lastInsertId();
            if($lastInsertId){
                $data['success'] = true;
                $data['message'] = "Successfully Added Exam to Class";
            }else{
                $data['success'] = false;
                $data['message'] = $er[2];
            }
    }

    echo json_encode($data);

