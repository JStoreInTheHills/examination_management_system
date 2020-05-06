<?php include '../../config/config.php';

$class_exam_id = $_POST['class_exam_id'];

$data = array();

$sql = "DELETE FROM class_exams WHERE id =:class_exam_id";

$query = $dbh->prepare($sql);
$query->bindParam(':class_exam_id', $class_exam_id, PDO::PARAM_STR);

$result = $query->execute();

if($result){
    $data['success'] = true;
    $data['message'] = "Exam Deleted From Class Successfully";
}else{
    $data['success'] = true;
    $data['message'] = "Error Check Again";
}

echo json_encode($data);
