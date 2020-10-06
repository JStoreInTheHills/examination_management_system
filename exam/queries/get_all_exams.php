<?php

include '../../config/config.php';

$sql = 'SELECT exam_id, exam_name, exam.created_at,username as created_by, exam_out_of 
        FROM exam 
        JOIN tbl_user 
        ON exam.creator_id = tbl_user.id';

$query = $dbh->prepare($sql);

$query->execute();

$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);