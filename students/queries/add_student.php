<?php

include "../../config/config.php";


$errors = array();      // array to hold validation errors
$data = array();      // array to pass back data


if (empty($_POST['fullanme']))
    $errors['fullname'] = 'Name is required.';

if (empty($_POST['rollid']))
    $errors['rollid'] = 'Roll ID is required.';

if (empty($_POST['emailid']))
    $errors['emailid'] = 'Email is required.';

if (empty($_POST['gender']))
    $errors['gender'] = 'Gender is required.';

if (empty($_POST['classid']))
    $errors['classid'] = 'Class is required and A must.';

if (empty($_POST['dob']))
    $errors['dob'] = 'Date is required.';

// if there are any errors in our errors array, return a success boolean of false
if (!empty($errors)) {

    $data['success'] = false;
    $data['message'] = $errors;
} else {

    $studentname = $_POST['fullanme'];
    $roolid = $_POST['rollid'];
    $studentemail = $_POST['emailid'];
    $gender = $_POST['gender'];
    $classid = $_POST['classid'];

    $dob = $_POST['dob'];
    $status = 1;

    $sql = "INSERT INTO tblstudents(StudentName,RollId,StudentEmail,Gender,ClassId,DOB,RegDate, Status)
            VALUES(:studentname,:roolid,:studentemail,:gender,:classid,:dob, CURRENT_TIMESTAMP(),:status)";

    $query = $dbh->prepare($sql);

    $query->bindParam(':studentname', $studentname, PDO::PARAM_STR);
    $query->bindParam(':roolid', $roolid, PDO::PARAM_STR);
    $query->bindParam(':studentemail', $studentemail, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':classid', $classid, PDO::PARAM_STR);
    $query->bindParam(':dob', $dob, PDO::PARAM_STR);

    $query->bindParam(':status', $status, PDO::PARAM_STR);


    $query->execute();

    $er = $query->errorInfo();

    $lastInsertId = $dbh->lastInsertId();

    // show a message of success and provide a true success variable
    if ($lastInsertId){

        // $next_of_kin = $_POST['next_of_kin'];
        // $telephone = $_POST['telephone'];
        // $address = $_POST['address'];
        // $county_id = $_POST['county_id'];

        // $guardian_insert_query = "INSERT INTO  students_details(next_of_kin, telephone, address,county_id,students_id)
        //     VALUES(:next_of_kin, :telephone, :address, :county_id, :students_id)";
        // $guardian_sql = $dbh->prepare($guardian_insert_query);
        // $guardian_sql->bindParam(":next_of_kin", $next_of_kin, PDO::PARAM_STR);
        // $guardian_sql->bindParam(":telephone", $telephone, PDO::PARAM_STR);
        // $guardian_sql->bindParam(":address", $address, PDO::PARAM_STR);
        // $guardian_sql->bindParam(":county_id", $county_id, PDO::PARAM_STR);
        // $guardian_sql->bindParam(":students_id", $lastInsertId, PDO::PARAM_STR);
        
        // $guardian_sql->execute();

        // $lastInsertId2 = $dbh->lastInsertId();

        // if ($lastInsertId2){
            $data['success'] = true;
            $data['message'] = 'Student Added Successfully Yay';
        // }else{
        //     $data['success'] = false;
        //     $data['message'] = 'Contact Cannot be Added.';
        // }
    }
    else{
        $data['success'] = false;
        $data['message'] = $er[2];
    }


}

// return all our data to an AJAX call
echo json_encode($data);


