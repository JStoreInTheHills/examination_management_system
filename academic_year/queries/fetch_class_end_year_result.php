<?php include '../../config/config.php';

$year_id = $_GET['year_id'];

$sql = "SELECT id, ClassName, ClassNameNumeric, s.name, CreationDate, t.name as ClassTeacher
        FROM tblclasses AS c 
        JOIN stream s ON s.stream_id = c.stream_id
        JOIN tblteachers t ON t.teacher_id = c.classTeacher
        GROUP BY c.id";

$query = $dbh->prepare($sql);

$query->bindParam(":year_id", $year_id, PDO::PARAM_STR);

$query->execute();
$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);