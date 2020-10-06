<?php

include '../../../config/config.php';

$sql = 'SELECT students_id, GROUP_CONCAT(marks) AS marks FROM result GROUP BY students_id';

$query = $dbh->prepare($sql);
 $query->execute();

        $result = $query->fetchAll(PDO::FETCH_OBJ);

        echo json_encode($result);