<?php require_once("../../config/config.php");

$class_id = $_GET['class_id'];
$class_exam_id = $_GET['class_exam_id'];

$query = "SELECT name, SubjectName, MAX(t.total)AS max_total, subject_id 
          FROM (SELECT SubjectName, r.subject_id, t.name, 
          SUM(marks) as total FROM result r JOIN tblsubjectcombination c 
          ON c.id = r.subject_id JOIN tblsubjects s ON s.subject_id = c.SubjectId
          JOIN tblteachers t ON t.teacher_id = c.teachers_id
          WHERE r.class_id =:class_id AND r.class_exam_id =:class_exam_id
          GROUP BY r.subject_id ORDER BY total DESC)t";

$sql = $dbh->prepare($query);
$sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
$sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);

$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);