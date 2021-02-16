<?php 

    include "../../config/config.php";

    $school_name = $_POST['school_name_input'];

    $error = array();
    $data = array();

    if(empty($school_name))
        $error['school_name'] = "School Name Cannot be null";

    if(!empty($error)){
        $data['success'] = false;
        $data['message'] = $error;
    }else{
        $query = "UPDATE school 
                  SET school_name =:school_name";

        $stmt = $dbh->prepare($query);
        $stmt->bindParam(":school_name", $school_name, PDO::PARAM_STR);

        $result = $stmt->execute();

        $errors = $stmt->errorInfo();

        if($result){
            $data['success'] = true;
            $data['message'] = "Changes saved successfully";
        }else{
            $data['success'] = false;
            $data['message'] = $errors[2];
        }
    }

    
    echo json_encode($data);
    exit();
