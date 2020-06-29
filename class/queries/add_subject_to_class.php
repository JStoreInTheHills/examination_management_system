<?php include '../../config/config.php';

$data = array();
$errors = array();

$subject_id = $_POST['subject_id'];
$class_id = $_POST['class_id'];
$teachers_id = $_POST['teacher_id'];


if(empty($subject_id))
    $errors['Subject '] = "Subject Cannot be Empty";

if(empty($class_id))
    $errors['Class'] = "Class Cannot be Empty";

if(!empty($errors)){
    $data['success'] = false;
    $data['message'] = $errors;
}else{
    $checkExist = "SELECT ClassId, SubjectId, teachers_id 
                    FROM tblsubjectcombination 
                    WHERE ClassId =:class_id 
                    AND SubjectId =:subject_id
                    AND teachers_id =:teachers_id
                    ";
    $checkQuery = $dbh->prepare($checkExist);
    $checkQuery->bindParam(":class_id", $class_id, PDO::PARAM_STR);
    $checkQuery->bindParam(":subject_id", $subject_id, PDO::PARAM_STR);
    $checkQuery->bindParam(":teachers_id", $teachers_id, PDO::PARAM_STR);

    $checkQuery->execute();

    $CheckResult = $checkQuery->fetchAll();

    if($checkQuery->rowCount() > 0){
            $data['success'] = false;
            $data['message'] = "Subject Already Inserted";
    }else{
        $status = 1;
        $sql = 'INSERT INTO tblsubjectcombination (ClassId, SubjectId, status, CreationDate, teachers_id) 
        VALUES (:class_id, :subject_id, :status, CURRENT_TIMESTAMP, :teachers_id)';
        $query = $dbh->prepare($sql);

        $query->bindParam(':class_id', $class_id, PDO::PARAM_STR);
        $query->bindParam(':subject_id', $subject_id, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':teachers_id', $teachers_id, PDO::PARAM_STR);

        $query->execute();
        $er = $query->errorInfo();
        $lastInsertId = $dbh->lastInsertId();

        if($lastInsertId){
            $data['success'] = true;
            $data['message'] = "Subject Added To Class Successfully";
        }else{
            $data['success'] = false;
            $data['message'] = er[2];
        }
    }
           
              
}

echo json_encode($data);
