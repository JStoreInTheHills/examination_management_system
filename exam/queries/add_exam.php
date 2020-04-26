<?php
    include "../../config/config.php";

    $exam_name = $_POST['exam_name'];
    $created_by = "Administrator";

    if (empty($exam_name))
        $errors['ClassName'] = 'Name is required.';

    // if there are any errors in our errors array, return a success boolean of false
    if (!empty($errors)) {

        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors'] = $errors;
    }else {

        $sql = "INSERT INTO exam(exam_name, created_at, created_by) VALUES (:exam,CURRENT_TIMESTAMP,:created_by)";
        $query = $dbh->prepare($sql);

        $query->bindParam(':exam', $exam_name, PDO::PARAM_STR);
        $query->bindParam(':created_by', $created_by, PDO::PARAM_STR);

        $query->execute();

        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId) {
            $data['success'] = true;
            $data['message'] = 'Exam Added Successfully';
        } else {
            $data['success'] = false;
            $data['message'] = 'Exam Already Exists!! Check The Name and Try Again!!';

        }

    }
echo json_encode($data);
