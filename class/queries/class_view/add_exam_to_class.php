<?php
    
    include '../../../config/config.php';

    if(empty($_POST['searchTerm'])){
        $sql = "SELECT exam_id, exam_name 
                FROM exam 
                WHERE closed = 1";
        $query = $dbh->prepare($sql);
        $query->execute();
        $exam_List = $query->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $searchTerm = $_POST['searchTerm'];

        $sql = "SELECT exam_id, exam_name 
                FROM exam 
                WHERE exam_name 
                LIKE :exam_name 
                AND closed = 1";
        $query = $dbh->prepare($sql);
        $query->bindValue(':exam_name', '%'.$searchTerm.'%', PDO::PARAM_STR);
        $query->execute();
        $exam_List = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    $data = array();

    foreach ($exam_List as $exam) {
        $data[] = array(
            "id" => $exam['exam_id'],
            "text" => $exam['exam_name'],
        );
    }
    echo json_encode($data);

    exit();



?>

    
