<?php 

    include '../../config/config.php';

    $class_id = $_GET['class_id'];

    $sql = 'SELECT id,status,SubjectName,
            SubjectCode, 
            t.name as teacherName, t.teacher_id
            FROM tblsubjectcombination sc
            JOIN tblsubjects s ON 
            sc.SubjectId = s.subject_id 
            JOIN tblteachers t ON 
            sc.teachers_id = t.teacher_id
            WHERE ClassId =:class_id';
    
    $query=$dbh->prepare($sql);
    $query->bindParam(':class_id', $class_id, PDO::PARAM_STR);

    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);
