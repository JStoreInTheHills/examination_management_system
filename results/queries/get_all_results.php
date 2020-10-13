<?php

        include '../../config/config.php';

            $sql = "SELECT r.result_id,  s.StudentId, c.ClassName, s.FirstName, s.LastName, s.OtherNames, s.RollId, SUM(marks)as score, class_exam_id
             FROM result r right join tblstudents s On students_id = s.StudentId join tblclasses c on c.id = r.class_id
             group by r.students_id, class_exam_id ORDER BY score desc";
             $query = $dbh->prepare($sql);
             $query->execute();

        $row = $query->fetchAll(PDO::FETCH_OBJ);

  echo json_encode($row);