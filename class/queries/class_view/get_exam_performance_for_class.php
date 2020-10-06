<?php include "../../../config/config.php";

$class_id = $_GET['class_id'];

$query = "SELECT SUM(marks) AS total, exam_name, 
         COUNT(distinct students_id) AS stdcnt
          FROM result r JOIN class_exams ce 
          ON ce.id = r.class_exam_id 
          JOIN exam 
          ON ce.exam_id = exam.exam_id 
          WHERE r.class_id =:class_id
          GROUP BY class_exam_id";

$sql = $dbh->prepare($query);
$sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);

$sql->execute();

$errors = $sql->errorInfo();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);

