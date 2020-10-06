<?php require_once("../../config/config.php");

$class_id = $_GET['class_id'];
$class_exam_id = $_GET['class_exam_id'];

$query = "SELECT FirstName, OtherNames, LastName, MAX(t.total) as max 
          FROM (SELECT FirstName,OtherNames, LastName, SUM(marks) AS total FROM result
          JOIN tblstudents ON result.students_id = tblstudents.StudentId
          WHERE class_id =:class_id AND class_exam_id =:class_exam_id
          GROUP BY students_id ORDER BY total DESC) AS t";

$sql = $dbh->prepare($query);
$sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
$sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);

$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);