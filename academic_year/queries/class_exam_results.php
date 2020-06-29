<?php include '../../config/config.php';

$academic_year = $_GET['academic_year'];
$class_name = $_GET['class_name'];

$sql = "SELECT exam_name FROM class_exams ce 
        JOIN year y ON y.year_id = ce.year_id 
        JOIN tblclasses c ON ce.class_id = c.id
        JOIN exam e ON e.exam_id = ce.exam_id
        WHERE y.year_name =:academic_year AND ClassName LIKE :class_name";                        

$query = $dbh->prepare($sql);
$query->bindParam(':academic_year', $academic_year, PDO::PARAM_STR);
$query->bindParam(':class_name', $class_name, PDO::PARAM_STR);

$query->execute();
$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);


