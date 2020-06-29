<?php require_once("../../config/config.php");

$sid = $_GET['sid'];

$query = "SELECT year_name, exam_name, SUM(marks) as mar
          FROM result r 
          JOIN class_exams ce ON r.class_exam_id = ce.id 
          JOIN exam e ON ce.exam_id =e.exam_id  
          JOIN year y ON y.year_id = ce.year_id
          WHERE students_id =:sid
          GROUP BY students_id, class_exam_id";

$sql = $dbh->prepare($query);
$sql->bindParam(":sid", $sid, PDO::PARAM_STR);

$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);

