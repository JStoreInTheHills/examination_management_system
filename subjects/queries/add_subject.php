<?php

include "../../config/config.php";


$errors = array();      // array to hold validation errors
$data = array();      // array to pass back data


if (empty($_POST['subject_name']))
    $errors['subject_name'] = 'subject_name is required.';

if (empty($_POST['subject_code']))
    $errors['subject_code'] = 'subject_code ID is required.';


// if there are any errors in our errors array, return a success boolean of false
if (!empty($errors)) {

    $data['success'] = false;
    $data['message'] = $errors;
} else {

    $subject_name = $_POST['subject_name'];
    $subject_code = $_POST['subject_code'];
    $ar_subject_name = $_POST['ar_subject_name'];


    $sql = "INSERT INTO  tblsubjects(SubjectName, SubjectCode, Creationdate, SubjectNameAr)
            VALUES(:subject_name,:subject_code,CURRENT_TIMESTAMP, :subject_name_ar)";

    $query = $dbh->prepare($sql);

    $query->bindParam(':subject_name', $subject_name, PDO::PARAM_STR);
    $query->bindParam(':subject_code', $subject_code, PDO::PARAM_STR);
    $query->bindParam(':subject_name_ar', $ar_subject_name, PDO::PARAM_STR);

    $query->execute();

    $lastInsertId = $dbh->lastInsertId();

    // show a message of success and provide a true success variable
    if ($lastInsertId){
        $data['success'] = true;
        $data['message'] = 'Subject Added Successfully';
    }
    else{
        $data['success'] = false;
        $data['message'] = 'Input Already Exists...Check the name and try again...';
    }


}

echo json_encode($data);


