<?php

include '../../config/config.php';

$sql = "SELECT c.id, ClassName, ClassNameNumeric AS ClassCode, t.name AS ClassNameNumeric, CreationDate, s.name, 
        (SELECT COUNT(ClassId) FROM tblstudents WHERE ClassId = c.id) AS number_of_students,
        (SELECT COUNT(*) FROM tblsubjectcombination WHERE ClassId = c.id) AS number_of_subjects,
        (SELECT count(exam_id) FROM class_exams WHERE class_id = c.id) AS exams
        FROM tblclasses c 
        JOIN stream s ON c.stream_id = s.stream_id 
        LEFT JOIN tblteachers t ON t.teacher_id = c.classTeacher ";

$query = $dbh->prepare($sql);

$query->execute();

$results = $query->fetchAll(PDO::FETCH_OBJ);

echo  json_encode($results);




