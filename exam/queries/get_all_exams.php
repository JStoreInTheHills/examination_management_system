<?php

include '../../config/config.php';

$sql = 'SELECT name, exam_id, exam_name, exam.created_at,username as created_by,exam_out_of, closed 
        FROM exam 
        LEFT JOIN tbl_user 
        ON exam.creator_id = tbl_user.id 
        LEFT JOIN tbl_rstyle 
        ON tbl_rstyle.id = exam.r_style';

$query = $dbh->prepare($sql);

$query->execute();

$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);