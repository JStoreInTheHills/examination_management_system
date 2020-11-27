<?php 

    include "../../config/config.php";

    $data = array();

    $inputId = $_POST['inputId'];
    $uuid = $_POST['uuid'];
    $inputPhone = $_POST['inputPhone'];
    $inputAddress = $_POST['inputAddress'];

    $query = "UPDATE tblteachers 
              SET id_no=:id_no, phone=:phone, address=:address
              WHERE teacher_id =:uuid";

    $sql = $dbh->prepare($query);
    $sql->bindParam(":id_no", $inputId, PDO::PARAM_STR);
    $sql->bindParam(":phone", $inputPhone, PDO::PARAM_STR);
    $sql->bindParam(":address", $inputAddress, PDO::PARAM_STR);
    $sql->bindParam(":uuid", $uuid, PDO::PARAM_STR);

    $result = $sql->execute();

    $error = $sql->errorInfo();

    if($result){
        $data['success'] = true;
        $data['message'] = "Updated Successfully";
    }else{
        $data['success'] = false;
        $data['message'] = $error[2];
    }

    echo json_encode($data);


?>