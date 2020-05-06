<?php include '../../config/config.php';

$data = array();
$errors = array();

$subject_id = $_POST['subject_id'];
$class_id = $_POST['class_id'];

if(empty($subject_id))
    $errors['Subject '] = "Subject Cannot be Empty";

if(empty($class_id))
    $errors['Class'] = "Class Cannot be Empty";

if(!empty($errors)){
    $data['success'] = false;
    $data['message'] = $errors;
}else{
    $status = 1;
        
    $sql = 'INSERT INTO tblsubjectcombination (ClassId, SubjectId, status, CreationDate) 
           VALUES (:class_id, :subject_id, :status, CURRENT_TIMESTAMP)';
    $query = $dbh->prepare($sql);

    $query->bindParam(':class_id', $class_id, PDO::PARAM_STR);
    $query->bindParam(':subject_id', $subject_id, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);

    $query->execute();
    $er = $query->errorInfo();
    $lastInsertId = $dbh->lastInsertId();

    if($lastInsertId){
        $data['success'] = true;
        $data['message'] = "Subject Added To Class";
    }else{
        $data['success'] = false;
        $data['message'] = "Error Caught! Check the Inputs Again";
    }
           
}

echo json_encode($data);
