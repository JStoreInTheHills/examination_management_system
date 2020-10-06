<?php 

    include "../../config/config.php";

    $uuid = $_GET['uuid'];

    $sql = "SELECT teacher_id
            FROM tblteachers 
            LEFT JOIN  tblsubjectcombination
            ON tblteachers.teacher_id = tblsubjectcombination.teachers_id
            WHERE user_id =:user_id 
            LIMIT 1";
    
    $query = $dbh->prepare($sql);
    
    $query->bindParam(":user_id",$uuid, PDO::PARAM_STR );

    $query->execute();

   $result = $query->fetchAll(PDO::FETCH_OBJ);

   echo json_encode($result);
  // $fp = fopen('../../teacher_module/subject_class.json', 'w');
  // fwrite($fp, json_encode($result));
  // fclose($fp);
?>

