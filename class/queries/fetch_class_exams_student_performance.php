<?php include '../../config/config.php';

$class_exam_id = $_GET['class_exam_id'];
$class_id = $_GET['class_id'];

$sql = 'SELECT created_at, result_id, FirstName, OtherNames, LastName,RollId, students_id, sum(marks) AS total, 
        (SELECT COUNT(DISTINCT subject_id)FROM result WHERE class_id =:class_id AND class_exam_id =:class_exam_id) as subject,
        GROUP_CONCAT(subject_id) as subjects, RANK () OVER (PARTITION BY class_exam_id 
        ORDER BY sum(marks) DESC) students_rank
        FROM result JOIN tblstudents ON tblstudents.StudentId = result.students_id
        WHERE class_id =:class_id AND class_exam_id =:class_exam_id
        GROUP BY students_id ORDER BY total desc';

$query = $dbh -> prepare($sql);
$query->bindParam(':class_id', $class_id, PDO::PARAM_STR);
$query->bindParam(':class_exam_id', $class_exam_id, PDO::PARAM_STR);

$query -> execute();

$result = $query -> fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);