<?php

include '../../config/config.php';

$class_id = $_POST['id'];

$data = array();
$error = array();

if (empty($class_id)) 
    $error['Class ID'] = 'Class ID cannot be a null value';

if(!empty($error)){
    $data['success'] = false;
    $data['message'] = $error;
}else{

    $sql = "DELETE FROM tblclasses where id =:class_id";

    $query = $dbh->prepare($sql);
    $query->bindParam(':class_id', $class_id, PDO::PARAM_STR);
    
        $result = $query->execute();
    
        $er = $query->errorInfo();
    
        if($result){
            $data['success'] = true;
            $data['message'] = 'Class Deleted Successfully';
        }else{
            $data['success'] = false;
            $data['message'] ="Error returned false ";
        }
}


    echo json_encode($data);