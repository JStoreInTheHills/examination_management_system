<?php 
    include "../../config/config.php";

    $old_teachers_id = $_POST['old_teacher_id'];
    $subject_id  = $_POST['subject_id'];
    $class_id  = $_POST['class_id'];

    $new_teacher_id = $_POST['new_teacher_id'];

    $error = array();
    $data = array();

    if(empty($new_teacher_id))
        $error['New Teacher'] = "New Teacher Cannot be Null";
    
    if(empty($subject_id))
        $error['Subject ID'] = "Subject ID cannot be null";
    
    if(empty($class_id))
        $error['Class ID'] = "Class ID cannot be null";

    if($new_teacher_id == $old_teachers_id){
        $data['success'] = false;
        $data['message'] = "You cant transfer subject to the same referenced teacher";
    }else{
        if(empty($error)){

            $query = "UPDATE tblsubjectcombination 
                      SET teachers_id =:new_teachers_id 
                      WHERE teachers_id =:old_teachers_id
                      AND ClassId =:class_id
                      AND id =:id"; 
    
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(":new_teachers_id", $new_teacher_id, PDO::PARAM_STR);
            $stmt->bindParam(":old_teachers_id", $old_teachers_id, PDO::PARAM_STR);
            $stmt->bindParam(":class_id", $class_id, PDO::PARAM_STR);
            $stmt->bindParam(":id", $subject_id, PDO::PARAM_STR);
    
            $result = $stmt->execute();
    
            $pdo_error = $stmt->errorInfo();
    
            if($result){
                $data["success"] = true;
                $data['message'] = "Updated Successfully";
            }else{
                $data['success'] = false;
                $data['message'] =  $pdo_error[2];
            }
            
        }else{
            $data['success'] = false;
            $data['message'] = $error;
        }
    }

    echo json_encode($data);
    exit();

