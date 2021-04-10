<?php 
	
	require_once "../../config/config.php";
	
	$class_id = $_GET['class_id'];

	$query = "SELECT ClassName, id, CreationDate, ClassNameNumeric, name, tblteachers.teacher_id
				FROM tblclasses 
				LEFT JOIN tblteachers 
				ON tblteachers.teacher_id = tblclasses.classTeacher
				WHERE id =:class_id";
	$sql = $dbh->prepare($query);
	$sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
	$sql->execute();

	$result = $sql->fetchAll(PDO::FETCH_ASSOC);

	echo json_encode($result);

?>