<?php require_once("../../config/config.php");

$sid = $_GET['sid'];

$query = "SELECT year_name, exam_name, class_exams.id, SUM(marks) as mar, term.name, class_exams.created_at
          FROM result
          LEFT JOIN class_exams ON class_exams.id = result.class_exam_id
          LEFT JOIN exam ON exam.exam_id = class_exams.exam_id
          LEFT JOIN term_year ON term_year.term_year_id = class_exams.term_id
          LEFT JOIN term ON term.id = term_year.term_id
          LEFT JOIN year ON year.year_id = class_exams.year_id
          WHERE students_id =:sid
          GROUP BY students_id, class_exam_id
          ORDER BY class_exams.id ASC";

$sql = $dbh->prepare($query);
$sql->bindParam(":sid", $sid, PDO::PARAM_STR);

$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);

