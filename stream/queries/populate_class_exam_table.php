<?php 
        require_once("../../config/config.php");

        $class_id = $_GET['class_id'];

        $sql = "SELECT ce.created_at, e.exam_name, y.year_name, e.exam_id, term.name,
                COUNT(e.exam_id) as exam_count, y.year_id, term_year.term_id
                FROM class_exams ce 
                JOIN exam e ON e.exam_id = ce.exam_id
                JOIN tblclasses c ON c.id = ce.class_id
                JOIN term_year ON ce.term_id = term_year.term_year_id
                JOIN year y ON y.year_id = ce.year_id
                JOIN term ON term.id = term_year.term_id
                WHERE c.stream_id =:class_id 
                GROUP BY ce.exam_id, ce.year_id, ce.term_id";

        $query = $dbh->prepare($sql);

        $query->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_OBJ);

        echo json_encode($result);

?>