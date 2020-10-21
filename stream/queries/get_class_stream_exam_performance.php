<?php require_once("../../config/config.php");

$class_id = $_GET['class_id'];
$exam_id = $_GET['class_exam_id'];

$sql = "SELECT r.created_at, ClassName, StudentId, FirstName, OtherNames, LastName, RollId, SUM(marks)AS total,
        GROUP_CONCAT(subject_id ORDER BY subject_id DESC) 
            AS subject_count, 
            RANK () OVER (ORDER BY SUM(marks) DESC) AS r,
        COUNT(DISTINCT subject_id) AS number_of_subjects
        FROM result r 
        JOIN tblstudents s 
        ON r.students_id = s.StudentId 
        JOIN tblclasses c 
        ON c.id = r.class_id 
        JOIN class_exams ce 
        ON ce.id = r.class_exam_id  
        WHERE c.stream_id =:stream_id
        AND ce.exam_id =:exam_id
        GROUP BY r.students_id
        ORDER BY total DESC";

$query = $dbh->prepare($sql);
$query->bindParam(":stream_id", $class_id, PDO::PARAM_STR);
$query->bindParam(":exam_id", $exam_id, PDO::PARAM_STR);

$query->execute();

$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);
