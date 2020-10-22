<?php require_once "../../config/config.php";

$class_exam_id = $_POST['exam_id'];
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
echo json_encode($data);

?>