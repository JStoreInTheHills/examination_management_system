<?php include '../../config/config.php';

$class_id = $_GET['class_name'];

$sql = "SELECT FirstName,OtherNames, LastName, StudentId, RollId, Status, RegDate
		FROM tblstudents s 
        JOIN tblclasses c ON c.id = s.ClassId 
        WHERE c.id = :class_id";

$query = $dbh->prepare($sql);
$query->bindParam(':class_id', $class_id, PDO::PARAM_STR);

$query->execute();

$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);