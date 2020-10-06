<?php

include "../../config/config.php";


$errors = array();      // array to hold validation errors
$data = array();      // array to pass back data


$classname = $_POST['ClassName'];
$classnamenumeric = $_POST['ClassNameNumeric'];
$section = $_POST['stream_id'];
$teachers_id = $_POST['teachers_id'];

if (empty($classname))
    $errors['ClassName'] = 'Name is required.';

if (empty($classnamenumeric))
    $errors['ClassNameNumeric'] = 'ClassNameNumeric is required.';

if (empty($section))
    $errors['stream_id'] = 'Stream is required.';

if (empty($teachers_id))
    $errors['teachers_id'] = 'Teacher is required.';


// if there are any errors in our errors array, return a success boolean of false
if (!empty($errors)) {

    // if there are items in our errors array, return those errors
    $data['success'] = false;
    $data['errors'] = $errors;
}else{



    $sql = "INSERT INTO  tblclasses(ClassName,ClassNameNumeric,stream_id,classTeacher)
    VALUES(:classname,:classnamenumeric,:section, :classTeacher)";

    $query = $dbh->prepare($sql);

    $query->bindParam(':classname', $classname, PDO::PARAM_STR);
    $query->bindParam(':classnamenumeric', $classnamenumeric, PDO::PARAM_STR);
    $query->bindParam(':section', $section, PDO::PARAM_STR);
    $query->bindParam(':classTeacher', $teachers_id, PDO::PARAM_STR);

    $query->execute();

    $er = $query->errorInfo();

    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId) {
        $data['success'] = true;
        $data['message'] = 'Class Added Successfully';
    } else {
        $data['success'] = false;
        $data['message'] = $er[2];

    }

}
echo json_encode($data);
