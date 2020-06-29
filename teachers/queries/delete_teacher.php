<?php 

try{    
    if(file_exists('../../config/config.php')){
        include '../../config/config.php'; // Include the Database Config File. 
    }else{
        throw new Exception("Error Processing Request. Database File not Found", 1);
    }
}catch(Exception $e){
    echo 'Exception Caught ',  $e->getMessage() , "\n";
}

    $errors = array();
    $data = array();

    if(empty($_POST['teachers_id'])){
        $errors['Teachers Id'] = "Teachers ID cannot be null";
    }

    if(!empty($errors)){
        $data['success'] = false;
        $data['message'] = $errors;
    }else{
        $teacher_id = $_POST['teachers_id'];

        $sql = "DELETE FROM tblteachers WHERE teacher_id =:teacher_id";
        $query = $dbh->prepare($sql);
        
        $query->bindParam(':teacher_id', $teacher_id, PDO::PARAM_STR);
        
        $executeQuery = $query->execute();
   
        if($executeQuery){
            $data['success'] = true;
            $data['message'] = "Deleted Successfully";
        }else{
            $data['success'] = false;
            $data['message'] = "Something went wrong";
        }
    }

    echo json_encode($data);



    
