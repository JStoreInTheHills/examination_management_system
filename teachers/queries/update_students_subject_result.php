<?php 

    include "../../config/config.php";

    $students_id = $_GET['students_id'];
    $students_marks = $_GET['students_marks'];
    $exam_id = $_GET['exam_id'];
    $result_id = $_GET['result_id'];
    $class_id = $_GET['class_id'];
    $subject_id = $_GET['subject_id'];
    
    $data = array();

    $query = "UPDATE result SET marks =:new_marks 
              WHERE result_id =:result_id";
    
    $sql = $dbh->prepare($query);

    $sql->bindParam(":new_marks", $students_marks, PDO::PARAM_STR);
    $sql->bindParam(":result_id", $result_id, PDO::PARAM_STR);

    $result = $sql->execute();

    $errors = $sql->errorInfo();

    if($result){
        $data['success'] = true;
        $data['message'] = "Updated Successfully";
    }else{
        $data['success'] = false;
        $data['message'] = $errors[2];
    }
    echo json_encode($data);
