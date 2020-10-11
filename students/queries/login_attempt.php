<?php

    
    require_once ("../../config/config.php");

    $name = $_POST["name"];
    $rollid = $_POST["rollid"];

    $error = array();
    $data = array();

    $query = "SELECT StudentId, FirstName,LastName,ClassId FROM 
              tblstudents 
              WHERE FirstName LIKE :firstname
              AND RollId =:rollid";

    $sql = $dbh->prepare($query);

    $sql->bindParam(":firstname", $name, PDO::PARAM_STR);
    $sql->bindParam(":rollid", $rollid, PDO::PARAM_STR);

    $sql->execute();

    // $sql_errors = $sql->errorInfo();

    $result = $sql->fetch(PDO::FETCH_ASSOC);

    if($sql->rowCount() > 0){
     
        session_start(); // start a session

        $_SESSION['alogin'] = $result['FirstName'];
        $_SESSION['uuid'] = $result['StudentId'];
        // $_SESSION['role_id'] = $result['role_id'];
        $_SESSION['last_login_timestamp'] = time();

        $data['success'] = true; 
        $data['uuid'] = $result['StudentId'];
        $data['class_id'] = $result['ClassId'];
        $data['message'] = "Login Successfully. Redirecting you to Student profile";
    }else{
        $data['succes'] = false;
    }

  echo json_encode($data);
?>