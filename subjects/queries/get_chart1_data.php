<?php include '../../config/config.php';


$class_id = $_GET['class_id'];
$class_exam_id = $_GET['class_exam_id'];

$sql = "SELECT result.subject_id, sum(CASE WHEN tblsubjects.subject_id = result.subject_id THEN marks ELSE 0 END) AS total, SubjectName 
        FROM result JOIN tblsubjects ON result.subject_id = tblsubjects.subject_id WHERE class_id =:class_id 
        AND class_exam_id =:class_exam_id
        GROUP BY result.subject_id";

$query = $dbh->prepare($sql);
$query->bindParam(':class_id', $class_id, PDO::PARAM_STR);
$query->bindParam(':class_exam_id', $class_exam_id, PDO::PARAM_STR);
$query->execute();

$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);