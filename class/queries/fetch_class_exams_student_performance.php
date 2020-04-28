<?php include '../../config/config.php';

$class_exam_id = $_GET['class_exam_id'];
$class_id = $_GET['class_id'];

$sql = 'SELECT StudentName,RollId, students_id, sum(marks) AS total 
        FROM result JOIN tblstudents ON tblstudents.StudentId = result.students_id
        WHERE class_id =:class_id AND class_exam_id =:class_exam_id
        GROUP BY students_id ';

$query = $dbh -> prepare($sql);
$query->bindParam(':class_id', $class_id, PDO::PARAM_STR);
$query->bindParam(':class_exam_id', $class_exam_id, PDO::PARAM_STR);

$query -> execute();

$result = $query -> fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);