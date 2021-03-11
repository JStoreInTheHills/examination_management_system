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

    function getClassTeacherGender($class_id){
       
        global $dbh;

        $query = "SELECT gender FROM tblclasses LEFT JOIN tblteachers 
                  ON tblclasses.classTeacher = tblteachers.teacher_id 
                  WHERE tblclasses.id =:class_id";
        $sql = $dbh->prepare($query);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);

        $sql->execute();

        $teachersGender = $sql->fetchColumn();

        return $teachersGender;

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

    function getSubjectNames($class_id){

        global $dbh;

        $query = "SELECT SubjectName,SubjectNameAr 
                  FROM tblsubjectcombination 
                  LEFT JOIN tblsubjects 
                  ON tblsubjects.subject_id = tblsubjectcombination.SubjectId 
                  WHERE ClassId =:class_id
                  ORDER BY subject_id DESC";
                  
        $sql = $dbh->prepare($query);
        
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->execute();

        $data = array();

        $Subjects = $sql->fetchAll(PDO::FETCH_ASSOC);


        return ($Subjects);
    }

    function getStudentsPosition($class_id, $class_exam_id, $students_id){

        global $dbh;

        $query = "SELECT r FROM(SELECT students_id, SUM(marks),
                 RANK() OVER (PARTITION BY class_exam_id, class_id ORDER BY SUM(marks) DESC) as r
                 FROM result  WHERE class_id =:class_id AND class_exam_id=:class_exam_id
                 GROUP BY students_id) AS t
                 WHERE students_id=:students_id";


        $sql = $dbh->prepare($query);
        $sql->bindParam(":class_id", $class_id,PDO::PARAM_STR);
        $sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);
        $sql->bindParam(":students_id", $students_id, PDO::PARAM_STR);

        $sql->execute();

        $performance = $sql->fetchColumn();

        return $performance;
    }

    function getAllStudentsSatForExam($class_id, $class_exam_id){
        global $dbh;

        $query_for_total_number_of_students = "SELECT COUNT(DISTINCT students_id) AS students_number 
                                               FROM result 
                                               WHERE class_id =:class_id 
                                               AND class_exam_id =:class_exam_id";

        $query_rank = $dbh->prepare($query_for_total_number_of_students);
        $query_rank->bindParam(':class_id', $class_id, PDO::PARAM_STR);
        $query_rank->bindParam(':class_exam_id', $class_exam_id, PDO::PARAM_STR);

        $query_rank->execute();

        $stream_total = $query_rank->fetchColumn();

      return $stream_total;

    }

    function getTotalOveralNumberOfStudents($stream_id){

        global $dbh;

        $query = "SELECT COUNT(DISTINCT students_id) as stream_total_item 
                  FROM result s 
                  JOIN tblclasses c ON c.id = s.class_id
                  WHERE c.stream_id =:stream_id";

        $overal_query = $dbh->prepare($query);
        $overal_query->bindParam(':stream_id', $stream_id, PDO::PARAM_STR);

        $overal_query->execute();

        $total_overal_students;
        $stream_total = $overal_query->fetchColumn();

        return $stream_total;
    }

    function getStudentsGrade($percentage){
       
            if($percentage >= 86){
                $grade = "Excellent";
            }elseif ( $percentage >= 76 && $percentage <= 85) {
                $grade = "Very Good";
            }elseif ($percentage >= 66 && $percentage <= 75) {
                $grade = "Good";
            }elseif ($percentage >= 50 && $percentage <= 65) {
                $grade = "Pass";
            }else{
                $grade = "Fail";
            }

            return $grade;
    }

    function getStudentsGradeForRaudhwa($percentage){
       
        if($percentage >= 96){
            $grade = "Excellent";
        }elseif ( $percentage >= 86 && $percentage <= 95) {
            $grade = "Very Good";
        }elseif ($percentage >= 70 && $percentage <=85) {
            $grade = "Good";
        }elseif ($percentage >= 50 && $percentage <= 69) {
            $grade = "Pass";
        }else{
            $grade = "Fail";
        }

        return $grade;
    }

    function getStudentsDetails($students_id){

        global $dbh;

        $sql = "SELECT FirstName, OtherNames, LastName, ClassName, RollId 
                FROM tblstudents s 
                JOIN tblclasses c 
                ON s.ClassId = c.id 
                WHERE s.StudentId =:student_id";

        $query = $dbh->prepare($sql);
        $query->bindParam(':student_id', $students_id, PDO::PARAM_STR);

        $query->execute();
        $results = $query->fetchAll();

        $data = array();

        if($query->rowCount() > 0){
            foreach($results as $result){
                $data [] = array(
                    "firstname" => $result['FirstName'],
                    "second_name" => $result['OtherNames'],
                    "last_name" => $result['LastName'],
                    "class_name" => $result['ClassName'],
                    "rollId" => $result['RollId']
                );
            }
        }else{
            throw new Exception("Data Fields Empty. ", 1);
        }
        return ($data);
    }

    function getTotalSumOfStudent($students_id, $class_exam_id, $class_id){

        global $dbh;

        $query = "SELECT SUM(marks) 
                FROM result 
                WHERE class_exam_id=:class_exam_id
                AND students_id =:students_id
                AND class_id=:class_id";

        $sql = $dbh->prepare($query);
        $sql->bindParam(":students_id", $students_id, PDO::PARAM_STR);
        $sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->execute();

        $total_score = $sql->fetchColumn();

        return $total_score;
    }

    function getExamDetails($class_exam_id){

        global $dbh;

        $sql = "SELECT exam_name, year_name, class_exams.exam_id, exam_out_of, name, 
                exam.r_style  
                FROM exam 
                JOIN class_exams ON exam.exam_id = class_exams.exam_id
                LEFT JOIN term_year ON class_exams.term_id = term_year.term_year_id 
                LEFT JOIN term ON term.id = term_year.term_id
                JOIN year   ON year.year_id = class_exams.year_id
                WHERE class_exams.id =:class_exam_id";

        $query = $dbh->prepare($sql);

        $query->bindParam(':class_exam_id', $class_exam_id, PDO::PARAM_STR);
        $query->execute();

        $exam_result = $query->fetchAll();

        return $exam_result;
    }

    function getTermOfExam($class_exam_id){
        global $dbh;
        $query = "SELECT term_id 
                  FROM class_exams 
                  WHERE id =:class_exam_id";

        $sql = $dbh->prepare($query);
        $sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);
        $sql->execute();
        $result = $sql->fetchColumn();
        
        return $result;
    }

    function getStreamOfClass($class_id){
        global $dbh;

        $query = "SELECT stream_id 
                  FROM tblclasses
                  WHERE id =:class_id";
        $sql = $dbh->prepare($query);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->execute();

        $stream_id = $sql->fetchColumn();
        
        return $stream_id;
    }


    function getOveralPositionOfStudent($stream_id, $term_id, $exam_id, $students_id){
        global $dbh;
        $query = "SELECT sub_query.rnk 
                  FROM (SELECT RANK() OVER(PARTITION BY c.stream_id ORDER BY SUM(marks) DESC) rnk, students_id
                  FROM result r
                  LEFT JOIN tblclasses c ON r.class_id = c.id 
                  LEFT JOIN class_exams ce ON r.class_exam_id = ce.id
                  WHERE c.stream_id =:stream_id
                  AND ce.term_id =:term_id
                  AND ce.exam_id =:exam_id 
                  GROUP BY students_id) AS sub_query 
                  WHERE students_id =:students_id";
        $sql = $dbh->prepare($query);

        $sql->bindParam(":stream_id", $stream_id, PDO::PARAM_STR);
        $sql->bindParam(":term_id", $term_id, PDO::PARAM_STR);
        $sql->bindParam(":exam_id", $exam_id, PDO::PARAM_STR);
        $sql->bindParam(":students_id", $students_id, PDO::PARAM_STR);

        $sql->execute();
        
        $students_overall_position = $sql->fetchColumn();

        return $students_overall_position;
    }
?>