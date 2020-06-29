<?php
include('../../config/config.php');


if (!empty($_GET["classid"])) {

    $cid = intval($_GET['classid']);

    if (!is_numeric($cid)) {

        echo htmlentities("Class cannot be an non numeric value");
        exit;

    } else {
        $stmt = $dbh->prepare("SELECT StudentName,StudentId,RollId FROM tblstudents WHERE ClassId= :id order by StudentName");
        $stmt->execute(array(':id' => $cid));
        ?>
        <option value="">Select Student </option>
        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <option value="<?php echo htmlentities($row['StudentId']); ?>">
                <?php echo htmlentities($row['StudentName']) .' ~  Roll Id: ' . $row['RollId'] ;  ?>
            </option>
        <?php   }
    }
}

// Code for Subjects
if (!empty($_GET["classid1"])) {
    $cid1 = intval($_GET['classid1']);

    if (!is_numeric($cid1)) {
        echo htmlentities("Invalid Class");
        exit;
    } else {
        $status = 0;

        $stmt = $dbh->prepare("SELECT t.SubjectName, t.subject_id FROM tblsubjectcombination c 
                               JOIN tblsubjects t on c.SubjectId = t.subject_id 
                                        WHERE c.ClassId =:cid AND c.status !=:stts ORDER BY t.SubjectName");
        $stmt->execute(array(':cid' => $cid1, ':stts' => $status));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>

            <label class="text-primary"> <?php echo htmlentities($row['SubjectName']); ?> </label>

                <input type="text" name="marks[]" class="form-control marks"  placeholder="Enter Marks Out Of 100" autocomplete="off">

            <hr>
        <?php  }
    }
}

if (!empty($_GET["class_exam_id"]) && !empty($_GET['clid']) && !empty($_GET['val'])) {

    $class_exam_id = $_GET['class_exam_id'];
    $clid = $_GET['clid'];
    $val = $_GET['val'];

    $sql = "SELECT students_id, class_id FROM result 
            WHERE students_id=:id1 and class_id=:id and class_exam_id =:cid";
    
    $query = $dbh->prepare($sql);

    $query->bindParam(':id1', $val, PDO::PARAM_STR);
    $query->bindParam(':id', $clid, PDO::PARAM_STR);
    $query->bindParam(':cid', $class_exam_id, PDO::PARAM_STR);

    $query->execute();

    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;

    if ($query->rowCount() > 0) { ?>
        <p>
            <?php
            echo "
                
        <span style='color:red'> Result Already Declare for this Student.</span>
        
        ";
            echo "<script>$('#submit').prop('disabled',true);</script>";
            ?>
        </p>
    <?php }
} ?>