<?php include "../../config/config.php";

$class_id = $_GET['class_id'];
$class_exam_id = $_GET['class_exam_id'];
$year_id = $_GET['year_id'];
$term_id = $_GET['term_id'];

$query = "SELECT e.exam_out_of, s.name as stream_name, s.stream_id, ce.created_at, e.exam_name, y.year_name, e.exam_id, term.name as term_name 
          FROM class_exams ce 
          JOIN exam e ON e.exam_id = ce.exam_id 
          JOIN tblclasses c ON c.id = ce.class_id 
          JOIN term_year ON ce.term_id = term_year.term_year_id 
          JOIN stream s ON s.stream_id = c.stream_id 
          JOIN term ON term.id = term_year.term_id
          JOIN year y ON term_year.year_id = y.year_id 
          WHERE c.stream_id =:stream_id AND e.exam_id=:class_exam_id and term_year.year_id =:year_id AND term_year.term_id=:term_id
          GROUP BY ce.exam_id, term_year.year_id"; 

$sql = $dbh->prepare($query);

$sql->bindParam(":stream_id", $class_id, PDO::PARAM_STR);
$sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);
$sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
$sql->bindParam(":term_id", $term_id, PDO::PARAM_STR);

$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);

?>