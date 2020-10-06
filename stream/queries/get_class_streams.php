<?php require_once("../../config/config.php");

$class_id = $_GET['class_id'];

$sql = "SELECT id, CreationDate, ClassName, ClassNameNumeric,
        (SELECT COUNT(DISTINCT StudentId) 
                FROM tblstudents
                WHERE ClassId = c.id) 
        AS number_of_students,
        (SELECT COUNT(DISTINCT SubjectId) 
                FROM tblsubjectcombination 
                WHERE ClassId = c.id) 
        AS number_of_subjects,
        (SELECT COUNT(e.exam_id) 
                FROM class_exams ce 
                JOIN exam e ON e.exam_id = ce.exam_id 
                WHERE ce.class_id = c.id
        ) AS exams
        FROM tblclasses c
        WHERE stream_id =:class_id 
        ORDER BY CreationDate DESC";

$query = $dbh->prepare($sql);
$query->bindParam(":class_id", $class_id, PDO::PARAM_STR);

$query->execute();

$result = $query->fetchAll();

echo json_encode($result);