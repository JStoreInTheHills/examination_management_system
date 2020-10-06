<?php include "../../config/config.php";
    
    $teachers_id = $_GET['teachers_id'];

    $sql = "SELECT tblteachers.name, id_no, phone, tblteachers.created_at, tbl_user.email, address, counties.name as county_name
            FROM tblteachers 
            JOIN tbl_user
            ON tblteachers.user_id = tbl_user.id
            LEFT JOIN counties ON counties.id = tblteachers.county_id
            WHERE teacher_id =:teachers_id";

    $query = $dbh->prepare($sql);
    $query->bindParam(":teachers_id", $teachers_id, PDO::PARAM_STR);

    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);

?>