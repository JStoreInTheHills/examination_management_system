<?php

    include '../../config/config.php';

        $marks=array();

        $class = $_POST['class'];
        $studentid = $_POST['studentid'];
        $mark = $_POST['marks'];

        $class_exam_id = $_POST['class_exam_id'];

        if (empty($class)){
            $data['success'] = false;
            $data['message'] = 'Class Name Cannot be Empty';
        }

        if (empty($studentid)){
            $data['success'] = false;
            $data['message'] = 'StudentName cannot be Empty';
        }

        if (empty($mark)){
            $data['success'] = false;
            $data['message'] = 'Marks cannot be Empty';
        }


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
                $data['success'] = false;
                $data['message'] = 'Something Went Wrong';
            }

    }

    echo json_encode($data);