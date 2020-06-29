<?php 

    include '../../config/config.php';

    $class_id = $_GET['class_id'];

    $sql = 'SELECT id,SubjectId,status,SubjectName,SubjectCode,tblsubjectcombination.CreationDate, tblteachers.name
            FROM tblsubjectcombination JOIN tblsubjects ON tblsubjectcombination.SubjectId = tblsubjects.subject_id 
            JOIN tblteachers ON tblsubjectcombination.teachers_id = tblteachers.teacher_id
            WHERE ClassId =:class_id';
    
    $query=$dbh->prepare($sql);
    $query->bindParam(':class_id', $class_id, PDO::PARAM_STR);

    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);
