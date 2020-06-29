<?php include '../../config/config.php';

        $class_exam_id = $_GET['class_exam_id'];
        $class_id = $_GET['class_id'];

        $sql = 'SELECT result.subject_id, SubjectName, SUM(marks) as marks, GROUP_CONCAT(result.subject_id) AS concat
                FROM result JOIN tblsubjectcombination c ON c.id = result.subject_id 
                JOIN tblsubjects t ON c.SubjectId = t.subject_id
                WHERE class_id = :class_id AND class_exam_id =:class_exam_id GROUP BY result.subject_id';

$query = $dbh -> prepare($sql);
$query->bindParam(':class_exam_id', $class_exam_id, PDO::PARAM_STR);
$query->bindParam(':class_id', $class_id, PDO::PARAM_STR);

$query -> execute();

$result = $query -> fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);