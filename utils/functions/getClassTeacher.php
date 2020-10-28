<?php

   

    function getClassTeacher($class_id){
       
        global $dbh;

        $query = "SELECT name FROM tblclasses LEFT JOIN tblteachers 
                  ON tblclasses.classTeacher = tblteachers.teacher_id 
                  WHERE tblclasses.id =:class_id";
        $sql = $dbh->prepare($query);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);

        $sql->execute();

        $teachersName = $sql->fetchColumn();

        return $teachersName;

    }

    function getNumberOfSubjects($class_id){

        global $dbh;

        $query = "SELECT COUNT(DISTINCT id) AS count 
                  FROM tblsubjectcombination 
                  WHERE ClassId =:class_id";
        
        $sql = $dbh->prepare($query);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);

        $sql->execute();

        $numberOfSubjects = $sql->fetchColumn();

        return $numberOfSubjects;
    }

   

?>