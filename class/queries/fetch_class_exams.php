<?php include '../../config/config.php';

$cid = $_GET['cid'];
$class_exam_id = $_GET['class_exam_id'];

$sql = "SELECT id, exam_name FROM class_exams JOIN exam ON class_exams.exam_id = exam.exam_id 
        WHERE class_exams.class_id =:class_id AND class_exams.id =:class_exam_id";

$query = $dbh -> prepare($sql);
$query->bindParam(':class_id', $cid, PDO::PARAM_STR);
$query->bindParam(':class_exam_id', $class_exam_id, PDO::PARAM_STR);

$query -> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);

echo json_encode($results);