<?php require_once "../../config/config.php";

$class_exam_id = $_POST['class_exam_id'];
$class_id = $_POST['class_id'];
$marks = $_POST['marks'];
$students_id = $_POST['students_id'];
$subject_id = $_POST['subject_id'];

$data = array();
$error = array();

if(empty($class_exam_id))
    $error['Class Exam'] = "Class Exam cannot be null";

if(empty($class_id))
    $error['Class'] = "Class cannot be null";

if(empty($marks))
    $error['Marks'] = "Marks Field cannot be null";

if(empty($students_id))
    $error['Students'] = "Students Id cannot be null";

if(empty($subject_id))
    $error['Subject'] = "Subject cannot be null";

if(!empty($error)){
    $data['success'] = false;
    $data['message'] = $error;
}else{

    $query_to_check_whether_already_declared = "SELECT result_id 
        FROM result WHERE class_exam_id =:class_exam_id
        AND subject_id=:subject_id 
        AND students_id=:students_id
        AND class_id=:class_id";

    $sql_to_check_whether_already_declared = $dbh->prepare($query_to_check_whether_already_declared);

    $sql_to_check_whether_already_declared->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);
    $sql_to_check_whether_already_declared->bindParam(":subject_id", $subject_id, PDO::PARAM_STR);
    $sql_to_check_whether_already_declared->bindParam(":students_id", $students_id, PDO::PARAM_STR);
    $sql_to_check_whether_already_declared->bindParam(":class_id", $class_id,PDO::PARAM_STR);

    $sql_to_check_whether_already_declared->execute();

    $result_for_check = $sql_to_check_whether_already_declared->fetchAll(FETCH_OBJ);

    if($sql_to_check_whether_already_declared->rowCount() > 0){
        $data['success'] = false;
        $data['message'] = "Result Already Declared";
    }else{

        $query = "INSERT INTO `result`(`created_at`, `class_exam_id`, `subject_id`, `students_id`, `marks`, `class_id`)
        VALUES(CURRENT_TIMESTAMP(), :class_exam_id, :subject_id, :students_id, :marks, :class_id )";
    
        $sql = $dbh->prepare($query);
    
        $sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);
        $sql->bindParam(":subject_id", $subject_id, PDO::PARAM_STR);
        $sql->bindParam(":students_id", $students_id, PDO::PARAM_STR);
        $sql->bindParam(":marks", $marks, PDO::PARAM_STR);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
    
        $sql->execute();
    
        $queryError = $sql->errorInfo();
    
        $lastInsertId = $dbh->lastInsertId();
    
        if($lastInsertId){
            $data['success'] = true;
            $data['message'] = "Students Result Saved Successfully";
        }else{
            $data['success'] = false;
            $data['message'] = $queryError[2];
        }

    }
   //--------------------------------------------------------------------------------
}
echo json_encode($data);

?>