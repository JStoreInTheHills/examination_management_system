<?php 
    
    include "../../config/config.php";

    $class_id = $_POST['class_id'];
    $subject_id = $_POST['subject_id'];
    $teachers_id = $_POST['teachers_id'];
    $status = 1;

    $error = array();
    $data = array();

    if(empty($class_id))
        $error['Class ID'] = "Class ID cannot be null";

    if(empty($subject_id))
        $error['Subject ID'] = "Subject ID cannot be null";

    if(!empty($error)){
        $data['success'] = false;
        $data['message'] = $error;
    }
    else{

        $querytocheck = "SELECT id 
                         FROM tblsubjectcombination 
                         WHERE teachers_id=:teachers_id
                         AND ClassId=:classId
                         AND SubjectId=:subjectId
                         ";

        $sqltocheck = $dbh->prepare($querytocheck);
        $sqltocheck->bindParam(":teachers_id", $teachers_id, PDO::PARAM_STR);
        $sqltocheck->bindParam(":classId", $class_id, PDO::PARAM_STR);
        $sqltocheck->bindParam(":subjectId", $subject_id,PDO::PARAM_STR);
        $sqltocheck->execute();
        $result = $sqltocheck->fetchAll();

        if($sqltocheck->rowCount() > 0){
            $data['success'] = false;
            $data['message'] = "Subject Already Declared for this teacher";
        }else{

            $query = "INSERT INTO tblsubjectcombination(ClassId, SubjectId, status, CreationDate, teachers_id)
                    VALUES(:class_id,:subject_id,:status,CURRENT_TIMESTAMP,:teachers_id)";
            
            $sql = $dbh->prepare($query);

            $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
            $sql->bindParam(":subject_id", $subject_id,PDO::PARAM_STR);
            $sql->bindParam(":status", $status, PDO::PARAM_STR);
            $sql->bindParam(":teachers_id", $teachers_id,PDO::PARAM_STR);

            $sql->execute();

            $er = $sql->errorInfo();

            $lastInsertId = $dbh->lastInsertId();

            if($lastInsertId){
                $data['success'] = true;
                $data['message'] = "Teacher assigned Subject Successfully";
            }else{
                $data['success'] = false;
                $data['message'] = $er[2];
            }
        }
    }   

    echo json_encode($data);

?>