<?php

    include "../../config/config.php";

        $firstname = $_POST['first_name'];
        $othernames = $_POST['second_name'];
        $lastname = $_POST['last_name'];
        $rollid = $_POST['rollid'];
        $telephone = $_POST['telephone_no'];
        $gender = $_POST['gender'];
        $classid = $_POST['classid'];
        $dob = $_POST['dob'];
        $students_id = $_POST['students_id'];
   
    $json_data = array();

    $query = "UPDATE tblstudents 
              SET FirstName=:firstname, 
              OtherNames=:othernames,
              LastName=:lastname,
              RollId =:rollid,
              TelNo=:telephone,
              Gender=:gender,
              ClassId=:classid,
              DOB=:dob WHERE StudentId=:students_id";
    
    $sql = $dbh->prepare($query);
    $sql->bindParam(":firstname", $firstname,PDO::PARAM_STR);
    $sql->bindParam(":othernames", $othernames,PDO::PARAM_STR);
    $sql->bindParam(":lastname", $lastname,PDO::PARAM_STR);
    $sql->bindParam(":rollid", $rollid,PDO::PARAM_STR);
    $sql->bindParam(":telephone", $telephone,PDO::PARAM_STR);
    $sql->bindParam(":gender", $gender,PDO::PARAM_STR);
    $sql->bindParam(":classid", $classid,PDO::PARAM_STR);
    $sql->bindParam(":dob", $dob,PDO::PARAM_STR);
    $sql->bindParam(":students_id", $students_id,PDO::PARAM_STR);

    $result=$sql->execute();

    $errors = $sql->errorInfo();

    if($result){
        $json_data['success'] = true;
        $json_data['message'] = "Student Updated Successfully";
    }else{
        $json_data['success'] = false;
        $json_data['message'] = $errors[2];
    }

    echo json_encode($json_data);
?>