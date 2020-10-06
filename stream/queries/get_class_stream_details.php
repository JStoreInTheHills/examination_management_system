<?php include "../../config/config.php";

$class_id = $_GET['class_id'];
$class_exam_id = $_GET['class_exam_id'];

$query = "SELECT s.name as stream_name, s.stream_id, ce.created_at, e.exam_name, y.year_name, e.exam_id, term.name as term_name 
          FROM class_exams ce 
          JOIN exam e ON e.exam_id = ce.exam_id 
          JOIN year y ON y.year_id = ce.year_id 
          JOIN tblclasses c ON c.id = ce.class_id 
          JOIN term ON ce.term_id = term.id 
          JOIN stream s ON s.stream_id = c.stream_id 
          WHERE c.stream_id =:stream_id AND ce.exam_id=:class_exam_id
          GROUP BY ce.exam_id, y.year_id"; 

$sql = $dbh->prepare($query);
$sql->bindParam(":stream_id", $class_id, PDO::PARAM_STR);
$sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);

$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);

?>