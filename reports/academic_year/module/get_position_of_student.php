<?php 

    define("TOTAL_SCORE_FOR_ACADEMIC_YEAR", 100); // CONSTANT TOTAL MARKS

    function getTerms($class_id, $year_id){
        
        // include "../../../config/config.php";
        global $dbh;

        $query = "SELECT DISTINCT class_exams.term_id, term.name 
                  FROM class_exams 
                  JOIN term_year ty ON ty.term_year_id = class_exams.term_id 
                  JOIN term ON term.id = ty.term_id 
                  WHERE class_id =:class_id
                  AND class_exams.year_id=:year_id";

        $sql = $dbh->prepare($query);
        
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
        $sql->execute();

        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function getTermsForTheYearClass($year_id){
        global $dbh;
        $query = "SELECT term_year.term_year_id 
                  FROM term 
                  LEFT JOIN term_year ON term.id = term_year.term_id 
                  WHERE year_id =:year_id";
        
        $sql = $dbh->prepare($query);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);

        $sql->execute();

        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }   

    function getSubjectMarksFortheYear($students_id, $year_id){
        global $dbh;
        $query = "SELECT sum(marks) marks
                  FROM result r 
                  LEFT JOIN class_exams ce ON ce.id = r.class_exam_id 
                  LEFT JOIN tblsubjectcombination sc ON sc.id = r.subject_id 
                  LEFT JOIN tblsubjects s ON s.subject_id = sc.SubjectId 
                  WHERE students_id =:students_id AND term_id =11 AND ce.year_id=:year_id
                  GROUP BY r.subject_id ORDER BY s.subject_id DESC";
        
        $sql = $dbh->prepare($query);
        $sql->bindParam(":students_id", $students_id,PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
        $sql->execute();

        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    function getSubjectMarksFortheSecondTermYear($students_id, $year_id){
        global $dbh;
        $query = "SELECT sum(marks) marks
                  FROM result r 
                  LEFT JOIN class_exams ce ON ce.id = r.class_exam_id 
                  LEFT JOIN tblsubjectcombination sc ON sc.id = r.subject_id 
                  LEFT JOIN tblsubjects s ON s.subject_id = sc.SubjectId 
                  WHERE students_id =:students_id AND term_id =10 AND ce.year_id =:year_id
                  GROUP BY r.subject_id ORDER BY s.subject_id DESC";
        
        $sql = $dbh->prepare($query);
        $sql->bindParam(":students_id", $students_id,PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
        $sql->execute();

        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    function getTotalMarksForEachSubject($students_id, $year_id){
        global $dbh;
        $query = "SELECT sum(marks) marks
                  FROM result 
                  LEFT JOIN class_exams ON class_exams.id = result.class_exam_id 
                  LEFT JOIN tblsubjectcombination sc ON result.subject_id = sc.id
                  LEFT JOIN tblsubjects s ON s.subject_id = sc.SubjectId
                  WHERE students_id =:students_id 
                  AND year_id=:year_id 
                  GROUP BY result.subject_id 
                  ORDER BY s.subject_id DESC";
        
        $sql = $dbh->prepare($query);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
        $sql->bindParam(":students_id", $students_id,PDO::PARAM_STR);
        $sql->execute();

        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    function getTotalSumOfStudentForTheYear($student_id, $class_id, $year_id){
        global $dbh;
        $query = "SELECT SUM(marks)
                FROM result
                JOIN class_exams
                ON class_exams.id = result.class_exam_id
                WHERE result.class_id =:class_id
                AND result.students_id =:students_id
                AND class_exams.year_id =:year_id";
        
        $sql = $dbh->prepare($query);
        
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->bindParam(":students_id", $student_id, PDO::PARAM_STR);
        // $sql->bindParam(":term_id", $term_id, PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
        
        $sql->execute();
        
        $results = $sql->fetchColumn();
        
        return $results;
    }

    function getTotalMarksProposedForTheYear($numberOfSubjects){
        return $numberOfSubjects * TOTAL_SCORE_FOR_ACADEMIC_YEAR;
    }

    function getPercentageYearPerformance($sum_of_total, $total_marks){
        return number_format(($sum_of_total / $total_marks) * TOTAL_SCORE_FOR_ACADEMIC_YEAR);
    }

    function getStudentRankForTheYear($students_id, $class_id, $year_id){

        global $dbh;

        $query = "SELECT r 
                  FROM(SELECT RANK() OVER (PARTITION BY ce.year_id, r.class_id ORDER BY SUM(marks)DESC)r, SUM(marks) marks, students_id 
                       FROM result r 
                       LEFT JOIN class_exams ce ON ce.id = r.class_exam_id 
                       WHERE r.class_id =:class_id AND ce.year_id=:year_id
                       GROUP BY students_id)sub_query WHERE students_id =:students_id";
        
        $sql = $dbh->prepare($query);
        
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->bindParam(":students_id", $students_id, PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);

        $sql->execute();

        $result=$sql->fetchColumn();

        return $result;

    }

    function getStudentOverallMarks($stream_id, $year_id, $students_id){
        global $dbh;

        $query = "SELECT r FROM(SELECT RANK() OVER (PARTITION BY ce.year_id, c.stream_id ORDER BY SUM(marks)DESC)r, SUM(marks) marks, students_id 
                  FROM result r 
                  LEFT JOIN class_exams ce ON ce.id = r.class_exam_id 
                  LEFT JOIN tblclasses c ON c.id = ce.class_id 
                  WHERE c.stream_id =:stream_id 
                  AND ce.year_id=:year_id 
                  GROUP BY students_id)query 
                  WHERE students_id =:students_id";

        $sql = $dbh->prepare($query);
        $sql->bindParam(":stream_id", $stream_id, PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
        $sql->bindParam(":students_id", $students_id, PDO::PARAM_STR);

        $sql->execute();

        $overall_performance = $sql->fetchColumn();

        return $overall_performance;
    }

    function getNumberOfStudentsSatForTheExams($class_id, $year_id){
        global $dbh;

        $query = "SELECT COUNT(DISTINCT students_id) 
                  FROM result r 
                  LEFT JOIN class_exams ce ON r.class_exam_id = ce.id 
                  WHERE r.class_id =:class_id 
                  AND year_id =:year_id";
        
        $sql = $dbh->prepare($query);

        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);

        $sql->execute();

        $total_number_of_students_for_class_ = $sql->fetchColumn();

        return $total_number_of_students_for_class_;

        
    }

    function getNumberOfStudentsForStreamSatForExam($year_id, $stream_id){

        global $dbh;

        $query = "SELECT COUNT(DISTINCT students_id) 
                  FROM result r 
                  LEFT JOIN class_exams ce ON r.class_exam_id = ce.id 
                  LEFT JOIN tblclasses c ON c.id = r.class_id 
                  WHERE c.stream_id =:stream_id AND year_id =:year_id";

        $sql = $dbh->prepare($query);
        $sql->bindParam(":stream_id", $stream_id, PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);

        $sql->execute();

        $total_number_of_students_for_stream_ = $sql->fetchColumn();

        return $total_number_of_students_for_stream_;

        
    }