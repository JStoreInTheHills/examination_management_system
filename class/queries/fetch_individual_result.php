<?php include '../../config/config.php';

$student_id = $_GET['student_id'];

$sql = 'SELECT students_id, GROUP_CONCAT(marks SEPARATOR ",") AS marks, GROUP_CONCAT(SubjectName SEPARATOR ",") AS subject_name FROM result JOIN tblsubjects ON result.subject_id = tblsubjects.subject_id WHERE students_id =:students_id GROUP BY students_id';

$query = $dbh -> prepare($sql);
$query->bindParam(':students_id', $student_id, PDO::PARAM_STR);
$query -> execute();

$result = $query -> fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);