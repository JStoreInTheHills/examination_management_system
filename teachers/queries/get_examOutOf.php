<?php 
    include "../../config/config.php";

    $exam_id = $_GET['exam_id'];
    
    $data = array();
    $error = array();

    if(empty($exam_id)){
        $error['ExamId'] = "Exam Id cannot be empty";
    }

    if(!empty($error)){
        $data['success'] = false;
        $data['message'] = $error;
    }else{
        $query = "SELECT exam_out_of 
                    FROM exam 
                    LEFT JOIN class_exams 
                    ON class_exams.exam_id = exam.exam_id 
                    WHERE id =:id";
        $sql = $dbh->prepare($query);
        
        $sql->bindParam(":id", $exam_id, PDO::PARAM_STR);
        
        $sql->execute();

        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        $data = $result;
    }

    echo json_encode($data);
    exit();
    

