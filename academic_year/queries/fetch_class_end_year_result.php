<?php include '../../config/config.php';

$year_name = $_GET['year_name'];

$sql = "SELECT id, ClassName, ClassNameNumeric,name,(SELECT sum(marks) FROM result where class_id = id) as class_result
         FROM tblclasses c JOIN stream s 
        ON c.stream_id = s.stream_id";

$query = $dbh->prepare($sql);

$query->execute();
$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);