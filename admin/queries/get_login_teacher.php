<?php 

    include "../../config/config.php";

    $uuid = $_POST['uuid'];

    $error = array();
    $data = array();     

    if(empty($uuid))
        $error['uuid'] = "uuid cannot be empty";

   if(!empty($error)){
        $data['success'] = false;
        $data['data'] = $error;
   }else{
        $sql = "SELECT teacher_id
                FROM tblteachers 
                LEFT JOIN  tblsubjectcombination
                ON tblteachers.teacher_id = tblsubjectcombination.teachers_id
                WHERE user_id =:user_id 
                LIMIT 1";

        $query = $dbh->prepare($sql);

        $query->bindParam(":user_id",$uuid, PDO::PARAM_STR );

        $query->execute();

        $result = $query->fetchColumn();

        $data['success'] = true;
        $data['data'] = $result;
   }
    
   echo json_encode($data);
   exit();

