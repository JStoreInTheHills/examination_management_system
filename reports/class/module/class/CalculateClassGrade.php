<?php

    function calculateGradeForStudentsUsingRaudhwaFormart($SubjectPercentages){
       
        if($SubjectPercentages >= 96){
                    $grade = "EX";
                }elseif ($SubjectPercentages >= 86 && $SubjectPercentages <= 95) {
                    $grade = "VG";
                }elseif($SubjectPercentages >=70 && $SubjectPercentages <= 85 ){
                    $grade = "G";
                }elseif ($SubjectPercentages >= 50 && $SubjectPercentages <= 69) {
                    $grade = "P";
                }else {
                    $grade = "F";
        }
        return $grade;


    }

    function calculateGradeForStudentsNotUsingRaudhwaFormart($SubjectPercentages){
       
        if($SubjectPercentages >= 86){
                    $grade = "EX";
                }elseif ($SubjectPercentages >= 76 && $SubjectPercentages <= 85) {
                    $grade = "VG";
                }elseif($SubjectPercentages >=66 && $SubjectPercentages <= 75 ){
                    $grade = "G";
                }elseif ($SubjectPercentages >= 50 && $SubjectPercentages <= 65) {
                    $grade = "P";
                }else {
                    $grade = "F";
        }
         return $grade;


    }
?>