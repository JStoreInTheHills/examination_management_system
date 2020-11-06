<?php

    $StudentsSubjects = array();

    function getClassSubjectsCount($class_id){

       global $dbh;

        $query = "SELECT COUNT(DISTINCT id) AS SubjectCount 
                 FROM tblsubjectcombination 
                 WHERE ClassId = :class_id";
        
        $sql = $dbh->prepare($query);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);

        $sql->execute();

        $Subjects = $sql->fetchColumn();

        return $Subjects;
    }

    function getAllSubjects($class_id){
        
        $AllSubjects = array();

        global $dbh;

        $query = "SELECT id
                  FROM tblsubjectcombination
                  JOIN tblsubjects 
                  ON tblsubjects.subject_id = tblsubjectcombination.SubjectId
                  WHERE ClassId =:class_id 
                  ORDER BY id DESC";
                  
        $sql = $dbh->prepare($query);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);

        $sql->execute();
        
        $Subjects = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($Subjects as $subjects) {
            array_push($AllSubjects, $subjects["id"]);
        }

       return $AllSubjects;
    }

    function getTotalScoreForClass($class_id, $class_exam_id){

        global $dbh;

        $query = "SELECT SUM(marks) AS total_score
                  FROM result
                  WHERE class_id=:class_id
                  AND class_exam_id=:class_exam_id";
        $sql = $dbh->prepare($query);
        $sql->bindParam(":class_id", $class_id,PDO::PARAM_STR);
        $sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);

        $sql->execute();

        $totalscore_ = $sql->fetchColumn();
        return $totalscore_;
    }
    

   function calculateGrades($averages){
        if($averages >= 96){
            $grades = "A";
        }elseif ($averages >= 86 && $averages <= 95) {
            $grades = "B";
        }elseif($averages >=70 && $averages <= 85 ){
            $grades = "C";
        }elseif ($averages >= 50 && $averages <= 69) {
            $grades = "D";
        }else {
            $grades = "E";
        }
    return $grades;
   }
?>