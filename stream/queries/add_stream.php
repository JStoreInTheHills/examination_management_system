<?php

include "../../config/config.php";

$errors = array();      // array to hold validation errors
$data = array();      // array to pass back data

$stream_name = $_POST['stream_name'];
$desc = $_POST['desc'];

if (empty($stream_name)){
    $errors['Stream'] = 'Stream is required.';
}

// if there are any errors in our errors array, return a success boolean of false
if (!empty($errors)) {
    // if there are items in our errors array, return those errors
    $data['success'] = false;
    $data['errors'] = $errors;
}else{
    $sql = "INSERT INTO  stream(name,created_at,description)
    VALUES(:name,CURRENT_TIMESTAMP,:desc)";

    $query = $dbh->prepare($sql);

    $query->bindParam(':name', $stream_name, PDO::PARAM_STR);
    $query->bindParam(':desc', $desc, PDO::PARAM_STR);

    $query->execute();
    $er = $query->errorInfo();

    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId) {
        $data['success'] = true;
        $data['message'] = 'Stream Added Successfully';
    } else {
        $data['success'] = false;
        $data['message'] = $er[2];
    }
}
echo json_encode($data);
