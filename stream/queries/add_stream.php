<?php

include "../../config/config.php";

$errors = array();      // array to hold validation errors
$data = array();      // array to pass back data

$stream_name = $_POST['stream_name'];


if (empty($stream_name))
    $errors['Stream'] = 'Stream is required.';

// if there are any errors in our errors array, return a success boolean of false
if (!empty($errors)) {
    // if there are items in our errors array, return those errors
    $data['success'] = false;
    $data['errors'] = $errors;
}else{
    $sql = "INSERT INTO  stream(name,created_at)
    VALUES(:name,CURRENT_TIMESTAMP)";

    $query = $dbh->prepare($sql);

    $query->bindParam(':name', $stream_name, PDO::PARAM_STR);

    $query->execute();

    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId) {
        $data['success'] = true;
        $data['message'] = 'Stream Added Successfully';
    } else {
        $data['success'] = false;
        $data['message'] = 'Stream Already Exists!! Check The Name and Try Again!!';
    }
}
echo json_encode($data);
