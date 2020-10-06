<?php
    include "../../../config/config.php";

    $teachers_id = $_POST['teachers_id'];
    $class_id = $_POST['class_id'];
    $SubjectId = $_POST['SubjectId'];

    $data = array();

    $query = "DELETE FROM tblsubjectcombination 
              WHERE teachers_id =:teachers_id 
              AND ClassId =:class_id 
              AND id =:subject_id";

    $sql = $dbh->prepare($query);

    $sql->bindParam("teachers_id", $teachers_id, PDO::PARAM_STR);
    $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
    $sql->bindParam(":subject_id", $SubjectId, PDO::PARAM_STR);

    $result = $sql->execute();

    $errors = $sql->errorInfo();

    if($result){
        $data['success'] = true;
        $data['message'] = "Successfully deleted subject from teacher";
    }else{
        $data['success'] = false;
        $data['message'] = $errors[2];
    }

    echo json_encode($data);
