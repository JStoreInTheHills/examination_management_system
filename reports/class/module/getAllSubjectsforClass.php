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
                  ORDER BY id ASC";
                  
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
        if($averages >= 86){
            $grades = "EX";
        }elseif ($averages >= 76 && $averages <= 85) {
            $grades = "VG";
        }elseif($averages >=66 && $averages <= 75 ){
            $grades = "G";
        }elseif ($averages >= 50 && $averages <= 65) {
            $grades = "P";
        }else {
            $grades = "F";
        }
    return $grades;
   }

   function calculateGradesForRaudhwa($averages){
        if($averages >= 96){
            $grades = "EX";
        }elseif ($averages >= 86 && $averages <= 95) {
            $grades = "VG";
        }elseif($averages >=70 && $averages <= 85 ){
            $grades = "G";
        }elseif ($averages >= 50 && $averages <= 69) {
            $grades = "P";
        }else {
            $grades = "F";
        }
    return $grades;
   }

   function getClassSubjectNameAndSubjectPerformance($class_id, $class_exam_id){
       global $dbh;

       $subject_query = "SELECT DISTINCT sum(marks) AS total_subject_marks, r.subject_id, SubjectName
                        FROM result r 
                        LEFT JOIN tblsubjectcombination sc 
                        ON r.subject_id = sc.id 
                        LEFT JOIN tblsubjects s 
                        ON s.subject_id = sc.SubjectId 
                        WHERE r.class_id =:class_id 
                        AND class_exam_id =:class_exam_id
                        GROUP BY r.subject_id 
                        ORDER BY r.subject_id ASC";

        $sql = $dbh->prepare($subject_query);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);

        $sql->execute();

        $subject_result = $sql->fetchAll();

        return $subject_result;
   }

   
    /**
      *  function returning the stream id of the class. 
      *  var $class_id;
      *  return $stream_id;
    **/
   function getStreamOfClasses($class_id){

        // using the global mysql database connection 
        global $dbh;

        // Query to get the stream_id of the class using the where clause to specify the class. 
        $query = "SELECT stream_id 
                 FROM tblclasses 
                 WHERE id =:class_id";

        // Prepare the query using the dpo prepare function. 
        $sql= $dbh->prepare($query);

        // Binding the argurments with the parameters passed. 
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);

        // After binding is execution of the query. 
        $sql->execute();

        // We place the result on a variable 
        $stream_id = $sql->fetchColumn();

        // Return the vairable to the invocation call. 
        return $stream_id;

   }


?>