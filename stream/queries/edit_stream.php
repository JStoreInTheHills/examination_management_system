<?php require_once "../../config/config.php";

    $class_name = $_POST['edit_class_name'];
    $class_desc = $_POST['edit_class_desc'];
    $class_id = $_POST['class_id'];

    $data = array();

    $query = "UPDATE stream SET name=:class_name, description=:description WHERE stream_id=:stream_id";

    $sql = $dbh->prepare($query);

    $sql->bindParam(":class_name", $class_name, PDO::PARAM_STR);
    $sql->bindParam(":description", $class_desc, PDO::PARAM_STR);
    $sql->bindParam(":stream_id", $class_id, PDO::PARAM_STR);

    $result = $sql->execute();

    $errors = $sql->errorInfo();

    if($result){
        $data['success'] = true;
        $data['message'] = "Class Updated Successfully";
    }else{
        $data['success'] = false;
        $data['message'] = $errors[2];
    }

    echo json_encode($data);



?>