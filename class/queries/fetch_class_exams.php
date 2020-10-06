<?php include '../../config/config.php';

$cid = $_GET['cid'];
$class_exam_id = $_GET['class_exam_id'];

$sql = "SELECT ce.id AS class_exam_id, ce.created_at, status, exam_name, ClassName, exam_out_of
        FROM class_exams ce 
        JOIN exam e ON e.exam_id = ce.exam_id 
        JOIN tblclasses c on c.id = ce.class_id 
        WHERE ce.class_id =:class_id 
        AND ce.id =:class_exam_id";

$query = $dbh -> prepare($sql);
$query->bindParam(':class_id', $cid, PDO::PARAM_STR);
$query->bindParam(':class_exam_id', $class_exam_id, PDO::PARAM_STR);

$query -> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);

echo json_encode($results);