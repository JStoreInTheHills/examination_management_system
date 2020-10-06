<?php require_once("../../config/config.php");

$class_id = $_GET['class_id'];
$class_exam_id = $_GET['class_exam_id'];

$query = "SELECT COUNT(DISTINCT students_id) AS exam_sat_count,
         (SELECT COUNT(DISTINCT StudentId)
         FROM tblstudents WHERE ClassId =:class_id) AS class_total_students_count
         FROM result WHERE class_id =:class_id AND 
         class_exam_id =:class_exam_id";

$sql = $dbh->prepare($query);
$sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
$sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);

$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);