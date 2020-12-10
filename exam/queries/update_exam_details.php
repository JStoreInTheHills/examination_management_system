<?php
    include "../../config/config.php";

    $exam_id = $_POST['exam_id_edit'];
    $exam_out_of = $_POST['exam_out_of_edit'];
    $exam_name = $_POST['exam_name'];
    $r_style = $_POST['r_style'];

    $query = "UPDATE exam 
              SET exam_name=:exam_name,
              exam_out_of=:exam_out_of,
              r_style=:r_style
              WHERE exam_id=:exam_id";

    $sql = $dbh->prepare($query);

    $sql->bindParam(":exam_name", $exam_name, PDO::PARAM_STR);
    $sql->bindParam(":exam_out_of", $exam_out_of, PDO::PARAM_STR);
    $sql->bindParam(":r_style", $r_style, PDO::PARAM_STR);
    $sql->bindParam(":exam_id", $exam_id, PDO::PARAM_STR);

    $result = $sql->execute();

    $data = array();
    $error = $sql->errorInfo();

    if($result == 1){
        $data['success'] = true;
        $data['message'] = "Updated Exam Details Successfully";
    }else{
        $data['success'] = false;
        $data['message'] = $error[2];
    }

    echo json_encode($data);

?>