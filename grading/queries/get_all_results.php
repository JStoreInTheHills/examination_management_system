<?php

    include '../../config/config.php';

            $exam_id = $_GET['exam_id'];
            $cid = $_GET['cid'];

            $sql = "SELECT r.result_id,  s.StudentId, c.ClassName, s.StudentName,s.RollId, SUM(marks)as score, class_exam_id
             FROM result r right join tblstudents s On students_id = s.StudentId join tblclasses c on c.id = r.class_id
             group by r.students_id ORDER BY score desc";
             $query = $dbh->prepare($sql);
             $query->execute();



        $row = $query->fetchAll(PDO::FETCH_OBJ);

        echo json_encode($row);