<?php 

    include "../../config/config.php";

    $teacher_id = $_POST['teacher_id'];
    $address = $_POST['address'];
    $teacher_name = $_POST['edit_teachers_name'];
    $id_no = $_POST['edit_id_no'];
    $edit_phone = $_POST['edit_phone'];
    $edit_gender = $_POST['edit_gender'];

    $data = array();

    $query = "UPDATE tblteachers 
              SET name=:teachers_name, id_no=:id_no, phone=:phone, gender=:gender, address=:address, update_date=CURRENT_TIMESTAMP
              WHERE teacher_id =:teacher_id";
    
    $sql = $dbh->prepare($query);

    $sql->bindParam(":teachers_name", $teacher_name, PDO::PARAM_STR);
    $sql->bindParam(":id_no", $id_no, PDO::PARAM_STR);
    $sql->bindParam(":phone", $edit_phone, PDO::PARAM_STR);
    $sql->bindParam(":gender", $edit_gender, PDO::PARAM_STR);
    $sql->bindParam(":address", $address, PDO::PARAM_STR);
    $sql->bindParam(":teacher_id", $teacher_id, PDO::PARAM_STR);

    $result = $sql->execute();

    $err = $sql->errorInfo();

    if($result){
        $data['success'] = true;
        $data['message'] = "Updated successfully";
    }else{
        $data['success'] = false;
        $data['message'] = $err[2];
    }

    echo json_encode($data);

?>