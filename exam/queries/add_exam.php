<?php

    session_start();

    include "../../config/config.php";

    $exam_name = $_POST['exam_name'];
    $created_by = $_SESSION['uuid'];
    $add_exam = $_POST['exam_out_of'];
    $closed = 1;
    $r_style = $_POST['r_style'];

    if (empty($exam_name))
        $errors['ClassName'] = 'Name is required.';

    if(empty($add_exam))
        $errors['add_exam'] = "Exam out of is required";

    // if there are any errors in our errors array, return a success boolean of false
    if (!empty($errors)) {

        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors'] = $errors;
    }else {

        $sql = "INSERT INTO exam(exam_name, created_at, creator_id, exam_out_of, closed, r_style) 
                VALUES (:exam,CURRENT_TIMESTAMP,:created_by,:exam_out_of, :closed, :r_style)";

        $query = $dbh->prepare($sql);

        $query->bindParam(':exam', $exam_name, PDO::PARAM_STR);
        $query->bindParam(':exam_out_of', $add_exam, PDO::PARAM_STR);
        $query->bindParam(':created_by', $created_by, PDO::PARAM_STR);
        $query->bindParam(':closed', $closed, PDO::PARAM_STR);
        $query->bindParam(':r_style', $r_style, PDO::PARAM_STR);
        
        $query->execute();

        $er = $query->errorInfo();

        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId) {
            $data['success'] = true;
            $data['message'] = 'Exam Added Successfully';
        } else {
            $data['success'] = false;
            $data['message'] = $er[2];

        }

    }
echo json_encode($data);

exit();

?>