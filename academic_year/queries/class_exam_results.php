<?php include '../../config/config.php';

	$academic_year = $_GET['academic_year'];
	$class_name = $_GET['class_name'];

	$sql = "SELECT exam_name, ce.created_at, ce.status, e.exam_out_of
			FROM class_exams ce 
	        LEFT JOIN year y ON y.year_id = ce.year_id 
	        LEFT JOIN tblclasses c ON ce.class_id = c.id
	        LEFT JOIN exam e ON e.exam_id = ce.exam_id
	        WHERE ce.year_id =:academic_year 
	        AND ce.class_id = :class_name";                        

	$query = $dbh->prepare($sql);
	$query->bindParam(':academic_year', $academic_year, PDO::PARAM_STR);
	$query->bindParam(':class_name', $class_name, PDO::PARAM_STR);

	$query->execute();
	$result = $query->fetchAll(PDO::FETCH_OBJ);

	echo json_encode($result);


