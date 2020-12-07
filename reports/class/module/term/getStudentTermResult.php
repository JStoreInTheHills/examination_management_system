<?php

    define("PERCENTAGE", 100); // CONSTANT PERCENTAGE MARKS.
    define("TOTAL_SCORE", 50); // CONSTANT TOTAL MARKS

    /**
     * This function calculates and returns the sum of the students marks for 
     * the same term and same year term. 
     */

    function getTotalSumOfStudentForTheExam($student_id, $class_id, $year_id, $term_id){
        global $dbh;
        $query = "SELECT SUM(marks)
        FROM result
        JOIN class_exams
        ON class_exams.id = result.class_exam_id
        WHERE result.class_id =:class_id
        AND result.students_id =:students_id
        AND class_exams.term_id =:term_id
        AND class_exams.year_id =:year_id";
        
        $sql = $dbh->prepare($query);
        
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->bindParam(":students_id", $student_id, PDO::PARAM_STR);
        $sql->bindParam(":term_id", $term_id, PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
        
        $sql->execute();
        
        $results = $sql->fetchColumn();
        
        return $results;
    }

    /**
     * This function return the number of subjects the class has been allocated. 
     */
    function getNumberOfSubjectsForTheExam($class_id){
        
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

    /**
     * This function calculates and returns the percent % of the students
     * the same term and same year term. 
     */
    function getPercentage($sum_of_total, $class_id){
        
        $total_marks = (getNumberOfSubjectsForTheExam($class_id) * TOTAL_SCORE);
        
        $sum_of_total = number_format((($sum_of_total / $total_marks) * PERCENTAGE));
        
        return $sum_of_total;
    }

    /**
     * This function check if a grade satisfies a specific condition and returns the code under 
     * which the condition is true.
     */
    function caluculateGrade($grade){
        
        if($grade >= 96){
            return "Excellent";
        }elseif ($grade >= 95 && $grade <= 86) {
            return "Very Good";
        }elseif ($grade >= 70 && $grade <= 85) {
            return "Good";
        }elseif ($grade >= 50 && $grade <= 69) {
            return "Pass";
        }else {
            return "Fail";
        }
        
    }

    /**
     * This fucntion uses sub query to calculate the students rank for the term exams.
     */
    function getStudentsRank($year_id, $term_id, $student_id, $class_id){
        
        global $dbh;
        
        $query = "SELECT query.r 
                    FROM (SELECT result.students_id, 
                    RANK () OVER (PARTITION BY term_id ORDER BY SUM(marks) DESC) r 
                    FROM result JOIN class_exams 
                    ON class_exams.id = result.class_exam_id 
                    WHERE result.class_id=:class_id 
                    AND term_id=:term_id 
                    AND year_id=:year_id
                    GROUP BY students_id) query 
                    WHERE students_id=:students_id";
        
        $sql = $dbh->prepare($query);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->bindParam(":term_id", $term_id, PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
        $sql->bindParam(":students_id", $student_id, PDO::PARAM_STR);
        
        $sql->execute();
        
        $result = $sql->fetchColumn();
        
        return $result;
    }

    /**
     * Function to return the number of students who sat for the exam for that term and year. 
     */
    function getNumberOfStudentsSatForTheExam($class_id, $term_id, $year_id){
        global $dbh;
        
        $query = "SELECT COUNT(DISTINCT students_id) 
        FROM result 
        LEFT JOIN class_exams
        ON result.class_exam_id = class_exams.id
        WHERE result.class_id=:class_id
        AND class_exams.term_id=:term_id 
        AND class_exams.year_id=:year_id";
        
        $sql = $dbh->prepare($query);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->bindParam(":term_id", $term_id, PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
        
        $sql->execute();
        
        $numberOfStudents = $sql->fetchColumn();
        
        return $numberOfStudents;
    }


    /**
     * Function to get the total overall number of students who sat for the exam for that term. 
     */
    function getOveralNumberOfStudentsSatForExam($term_id, $stream_id, $year_id){
        
        global $dbh;
        
        $query = "SELECT COUNT(DISTINCT students_id) AS s
        FROM result 
        LEFT JOIN tblclasses 
        ON tblclasses.id = result.class_id
        LEFT JOIN class_exams
        ON result.class_exam_id = class_exams.id
        WHERE tblclasses.stream_id=:stream_id
        AND class_exams.term_id=:term_id
        AND class_exams.year_id=:year_id";
        
        $sql= $dbh->prepare($query);
        $sql->bindParam(":stream_id", $stream_id, PDO::PARAM_STR);
        $sql->bindParam(":term_id", $term_id, PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
        
        $sql->execute();
        
        $result = $sql->fetchColumn();
        
        return $result;
    }

    /**
     * Get the id for the exams that the students sat for. 
     */
    function getExamsForThatTerm($term_id, $year_id, $class_id){
        
        global $dbh;
        
        $query = "SELECT id
        FROM class_exams 
        LEFT JOIN exam ON exam.exam_id = class_exams.exam_id
        WHERE class_exams.year_id=:year_id 
        AND class_exams.term_id=:term_id
        AND class_exams.class_id =:class_id";
        $sql = $dbh->prepare($query);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->bindParam(":term_id", $term_id, PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
        
        $sql->execute();
        
        $exams = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        return $exams;
    }

    /**
     * Function to get the names of the subjects the class has been allocated. 
     */
    function getNamesOfSubjectsForTerm($class_id){
        global $dbh; 
        
        $query = "SELECT SubjectName
        FROM tblsubjectcombination
        LEFT JOIN tblsubjects
        ON tblsubjectcombination.SubjectId = tblsubjects.subject_id
        WHERE tblsubjectcombination.ClassId=:class_id
        ORDER BY tblsubjectcombination.id ASC";
        
        $sql =$dbh->prepare($query);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->execute();
        
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        return ($result);
    }

    /**
     * Function to check if the student sat for all the subjects assigned to the class. 
     */
    function checkIfTheStudentSatForAllSubjectsBetweenTheExams($student_id, $term_id, $year_id){
        global $dbh; 

        $query = "SELECT GROUP_CONCAT(SubjectName) names, 
                  GROUP_CONCAT(result.subject_id) subjects, class_exam_id, 
                  GROUP_CONCAT(marks) marks, sum(marks) total 
                  FROM result 
                  JOIN class_exams 
                  ON class_exams.id = result.class_exam_id 
                  LEFT JOIN tblsubjectcombination 
                  ON result.subject_id = tblsubjectcombination.id 
                  LEFT JOIN tblsubjects 
                  ON tblsubjects.subject_id = tblsubjectcombination.SubjectId
                  WHERE students_id=:students_id
                  AND term_id =:term_id
                  AND year_id =:year_id
                  GROUP BY class_exam_id";
        
        $sql = $dbh->prepare($query);
        $sql->bindParam(":students_id", $student_id, PDO::PARAM_STR);
        $sql->bindParam(":term_id", $term_id, PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);

        $sql->execute();

        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     *  Function to get the students marks for the subjects sat for 
     */

    function getStudentsMarksForRespectiveSubjects($year_id, $term_id, $student_id){

        global $dbh; 

        $array = array();

        $query = "SELECT GROUP_CONCAT(marks) marks 
                    FROM result 
                    JOIN class_exams 
                    ON class_exams.id = result.class_exam_id 
                    LEFT JOIN tblsubjectcombination 
                    ON result.subject_id = tblsubjectcombination.id 
                    LEFT JOIN tblsubjects 
                    ON tblsubjects.subject_id = tblsubjectcombination.SubjectId
                    WHERE students_id=:students_id
                    AND term_id =:term_id
                    AND year_id =:year_id
                    GROUP BY class_exam_id";

        $sql = $dbh->prepare($query);
        $sql->bindParam(":students_id", $student_id, PDO::PARAM_STR);
        $sql->bindParam(":term_id", $term_id, PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);

        $sql->execute();

        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $r ) {
            $resultString = $r['marks'];
            $resultArray = explode(",", $resultString);

            array_push($array, $resultArray);
        }

        return $array;
    }

    /**
     * Total sum of both the exam for the term. 
     */
    function getTotalSumOfTermSubjectPerformance($term_id, $year_id, $student_id){
        global $dbh;

        $query = "SELECT SUM(marks) marks
                  FROM result 
                  LEFT JOIN class_exams 
                  ON class_exams.id = result.class_exam_id 
                  WHERE students_id =:students_id
                  AND year_id =:year_id
                  AND term_id =:term_id
                  GROUP BY subject_id";
        $sql = $dbh->prepare($query);

        $sql->bindParam(":students_id", $student_id, PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
        $sql->bindParam(":term_id", $term_id, PDO::PARAM_STR);

        $sql->execute();

        $results = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $results;

    }

    /**
     * Function that returns the out of marks that the students was supposed to attain. 
     */
    function getTotalMarksProposed($numberOfSubjects){
        return $numberOfSubjects * TOTAL_SCORE;
    }

    /***
     * Similar to the above function that return the stream id of a specific class.
     */
    function getClassStreamId($class_id){

        global $dbh;
        $query = "SELECT stream_id FROM tblclasses WHERE id =:class_id";
        $sql = $dbh->prepare($query);

        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->execute();

        $result = $sql->fetchColumn();

        return $result;

    }

    /**
     * Function that returns the rank of the student overall for the term and year. 
     */
    function getOverallStudentsPerformance($stream_id, $term_id, $year_id, $student_id){
        
        global $dbh;

        $query = "SELECT sub_query.r as position FROM (SELECT r.class_id, students_id, 
                    RANK() OVER(PARTITION BY c.stream_id ORDER BY SUM(marks) DESC) r,
                    sum(marks) AS marks
                    FROM result r 
                    LEFT JOIN tblclasses c 
                    ON c.id = r.class_id 
                    LEFT JOIN stream s 
                    ON s.stream_id = c.stream_id 
                    LEFT JOIN class_exams ce 
                    ON ce.id = r.class_exam_id 
                    WHERE c.stream_id =:stream_id
                    AND term_id =:term_id 
                    AND year_id =:year_id 
                    GROUP BY students_id) sub_query WHERE sub_query.students_id =:students_id";
        $sql = $dbh->prepare($query);

        $sql->bindParam(":stream_id", $stream_id,PDO::PARAM_STR);
        $sql->bindParam(":term_id", $term_id, PDO::PARAM_STR);
        $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
        $sql->bindParam(":students_id", $student_id, PDO::PARAM_STR);

        $sql->execute();

        $result = $sql->fetchColumn();

        return $result;

    }

    function getExams($class_id, $term_id){
        global $dbh;
        $query = "SELECT exam_name, exam_out_of 
                  FROM class_exams 
                  LEFT JOIN exam 
                  ON exam.exam_id = class_exams.exam_id 
                  WHERE term_id =:term_id
                  AND class_id =:class_id
                  ORDER BY class_exams.exam_id DESC";

        $sql=$dbh->prepare($query);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->bindParam(":term_id", $term_id, PDO::PARAM_STR);
        $sql->execute();

        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Function to return the stream id for the class. 

        // function getClassDetails($class_id){
        //     global $dbh;
            
        //     $query = "SELECT stream_id FROM tblclasses
        //     WHERE id=:class_id";
            
        //     $sql = $dbh->prepare($query);
            
        //     $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
            
        //     $sql->execute();
            
        //     $result = $sql->fetchColumn();
            
        //     return $result;
            
        // }
     */

?>