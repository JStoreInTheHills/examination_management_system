<?php
    include "../../../config/config.php";

    $data = array();
    $error = array();

    $class_id = $_GET['class_id'];
    $year_id = $_GET['year_id'];
    $exam_id = $_GET['exam_id'];

    if (empty($class_id))
        $error['class_id'] = 'Class field cannot be empty';

    if (empty($year_id))
        $error['year_id'] = 'Year field cannot be empty';

    if (empty($exam_id))
        $error['exam_id'] = 'Exam field cannot be empty';

    if (!empty($error)){
        $data['success'] = false;
        $data['message'] = $error;

        echo json_encode($data);

    }else{
        $sql = 'select RollId, class_exam_id, SubjectName,marks,StudentName from result left join tblsubjects on result.subject_id = tblsubjects.subject_id 
                left join tblstudents on result.students_id = tblstudents.StudentId join class_exams on result.class_exam_id = class_exams.id 
                where result.class_exam_id = :class group by students_id
        ';


        $query = $dbh->prepare($sql);
        $query->bindParam(':class', $exam_id, PDO::PARAM_STR);

        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_OBJ);

        echo json_encode($result);
    }
