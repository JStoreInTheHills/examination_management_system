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
        $class_id = $_POST['class_id'];

        $checkExam = "SELECT class_id, exam_id,year_id FROM class_exams
                      WHERE exam_id=:exam_id AND class_id =:class_id
                      AND year_id =:year_id";
        $ExamQuery = $dbh->prepare($checkExam);
        $ExamQuery->bindParam(':exam_id', $exam_id, PDO::PARAM_STR);
        $ExamQuery->bindParam(':class_id', $class_id, PDO::PARAM_STR);
        $ExamQuery->bindParam(':year_id', $year_id, PDO::PARAM_STR);

        $ExamQuery->execute();
        $ExamResult = $ExamQuery->fetchAll();

        if($ExamQuery->rowCount() > 0){
            $data['success'] = false;
            $data['message'] = "Exam already assigned to Class";
        }else{
            $sql = "INSERT INTO class_exams(class_id,exam_id,year_id,created_at)
                    VALUES(:class_id,:exam_id,:year_id, CURRENT_TIMESTAMP)";

            $query=$dbh->prepare($sql);
            $query->bindParam(':class_id', $class_id, PDO::PARAM_STR);
            $query->bindParam(':exam_id', $exam_id, PDO::PARAM_STR);
            $query->bindParam(':year_id', $year_id, PDO::PARAM_STR);
            
            $query->execute();

            $er = $query->errorInfo();
            
            $lastInsertId = $dbh->lastInsertId();
            if($lastInsertId){
                $data['success'] = true;
                $data['message'] = "Successfully Added Exam to Class";
            }else{
                $data['sucess'] = false;
                $data['message'] = er[2];
            }
        }
    }

    echo json_encode($data);

