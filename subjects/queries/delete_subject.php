<?php include '../../config/config.php';

$subject_id = $_POST['subject_id'];

$data = array();
$errors = array();

if(empty($subject_id))
    $errors['Subject'] = "Subject Cannot be Null"; 

if(!empty($errors)){
    $data['success'] = false;
    $data['message'] = $errors;
}else{

    $sql = 'DELETE FROM tblsubjects WHERE subject_id =:subject_id';

    $query = $dbh->prepare($sql);
    $query->bindParam(':subject_id', $subject_id, PDO::PARAM_STR);
    
    $result = $query->execute();
    
    $er = $query->errorInfo();
    
    if($result){
        $data['success'] = true;
        $data['message'] = "Subject Deleted Successfully";
    }else{
        $data['success'] = false;
        $data['message'] = $er[2];
    }
}


echo json_encode($data);