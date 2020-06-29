<?php require_once '../../config/config.php';

$flag = 0; 
$class_exam_id = $_GET['id'];
$class_id = $_GET['class_id'];

$sql = "SELECT status FROM class_exams
        WHERE class_id=:class_id 
        AND id=:class_exam_id";

$query = $dbh->prepare($sql);

$query->bindParam(':class_id', $class_id, PDO::PARAM_STR);
$query->bindParam(':class_exam_id', $class_exam_id, PDO::PARAM_STR);

$query->execute();
$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);

