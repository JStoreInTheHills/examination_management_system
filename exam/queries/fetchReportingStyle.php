<?php
    include "../../config/config.php";

    $query = "SELECT id, name 
             FROM tbl_rstyle";

    $sql = $dbh->prepare($query);

    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    $data = array();

   foreach ($result as $res) {
       $data[] = array(
           "id" => $res['id'],
           "text" => $res['name']
       );
   }

   echo json_encode($data);
?>