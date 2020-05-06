<?php include '../../config/config.php';

$class_name = $_GET['class_name'];

$sql = "SELECT StudentName,StudentId, RollId FROM tblstudents s 
        JOIN tblclasses c ON c.id = s.ClassId 
        WHERE c.ClassName LIKE :class_name";

$query = $dbh->prepare($sql);
$query->bindParam(':class_name', $class_name, PDO::PARAM_STR);

$query->execute();

$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);