<?php

    include '../../config/config.php';

        $marks=array();

        $errors = array();
        $data = array();

        $class = $_POST['class'];
        $studentid = $_POST['studentid'];
        $mark = $_POST['marks'];

        $class_exam_id = $_POST['class_exam_id'];

        if (empty($class))
            $errors['class'] = 'Class Name Cannot be Empty';

        if (empty($studentid))
           $errors['student_id'] = 'Student Id cannot be Empty';

        if (empty($mark))
            $errors['mark'] = 'Marks cannot be Empty';
        
        if (empty($class_exam_id))
            $errors['class_exam_id'] = 'Class Exam cannot be Empty';

        if(!empty($errors)){
            
            $data['success'] = false;
            $data['message'] = $errors;

        }else {

        $stmt = $dbh->prepare("SELECT tblsubjects.SubjectName,tblsubjects.subject_id 
                                     FROM tblsubjectcombination join  tblsubjects on  tblsubjects.subject_id=tblsubjectcombination.SubjectId
                                  WHERE tblsubjectcombination.ClassId=:cid order by tblsubjects.SubjectName");
        $stmt->execute(array(':cid' => $class));
        $sid1 = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            array_push($sid1, $row['subject_id']);
        }

        for ($i = 0; $i < count($mark); $i++) {
            $mar = $mark[$i];
            $sid = $sid1[$i];
            $sql = "INSERT INTO  result(class_exam_id, subject_id, students_id, marks, class_id) VALUES(:class_exam_id,:sid,:studentid,:marks,:class)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':class_exam_id', $class_exam_id, PDO::PARAM_STR);
            $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
            $query->bindParam(':class', $class, PDO::PARAM_STR);
            $query->bindParam(':sid', $sid, PDO::PARAM_STR);
            $query->bindParam(':marks', $mar);
            $query->execute();

             $lastInsertId = $dbh->lastInsertId();

            if($lastInsertId) {
                $data['success'] = true;
                $data['message'] = 'Result Added Successfully';
            }else{

                $er = $query->errorInfo();

                $data['success'] = false;
                $data['message'] = ($er[2]);
            }

        }
    }
    echo json_encode($data);