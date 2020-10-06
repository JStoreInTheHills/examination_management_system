<?php require_once("../../config/config.php");

$class_id = $_GET['class_id'];

$sql = "SELECT name, CreationDate FROM tblclasses 
        JOIN tblteachers ON tblclasses.classTeacher = tblteachers.teacher_id 
        WHERE id =:class_id";
$query = $dbh->prepare($sql);

$query->bindParam(":class_id", $class_id, PDO::PARAM_STR);
$query->execute();

$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);
