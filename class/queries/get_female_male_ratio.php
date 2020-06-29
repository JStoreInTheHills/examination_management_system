<?php
    try{
        if(file_exists('../../config/config.php')){
            require_once '../../config/config.php';
        }else{
            throw new Exception("Error database configuration file cannot be found.", 1);
        }
    }catch(Exception $e){
        echo $e->getMessage() , "\n";
   }
   
   if(empty($_GET['class_id'])){
       echo "Class ID cannot be null";
   }

    $class_id = $_GET['class_id'];

    $ratio = "SELECT SUM(CASE WHEN `Gender` = 'MALE' THEN 1 ELSE 0 END)AS male,
              SUM(case when `Gender` = 'FEMALE' THEN 1 ELSE 0 END)AS female
              FROM tblstudents WHERE ClassId =:class_id";
    
    $ratioQuery = $dbh->prepare($ratio);
    $ratioQuery->bindParam(':class_id', $class_id, PDO::PARAM_STR);
    $ratioQuery->execute();

    $totalQuery = $ratioQuery->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($totalQuery);