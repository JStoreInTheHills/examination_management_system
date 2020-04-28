var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);

var class_exam_id = urlParams.get("id");
var cid = urlParams.get("class_id");

$(function () {

  var class_exam_subject = $("#class_exam_subject_table").DataTable({
    ajax: {
      url: "../queries/fetch_class_exam_subject_perrormance.php",
      type: "GET",
      dataSrc: "",
      data: {
        class_exam_id: class_exam_id,
        class_id: cid,
      },
    },
    columnDefs: [
      {
        targets: 0,
        data: "SubjectName",
      },
      {
        targets: 1,
        data: "marks",
      },
      {
        targets: 2,
        data: {
          concat : "concat",
          marks : "marks"
        },
        render: function (data) {
              var x = data.concat;
              var marks = data.marks;
                var y = x.split(',');
                return Math.round(marks / y.length);
        },
      },
    ],
  });

  var class_exam_student_table = $("#class_exam_student_table").DataTable({
    ajax: {
      url: "../queries/fetch_class_exams_student_performance.php",
      type: "GET",
      dataSrc: "",
      data: {
        class_exam_id: class_exam_id,
        class_id: cid,
      },     
    },
    "columnDefs" : [
      {
        targets : 0,
        data : "StudentName"
      },
      {
        targets : 1,
        data : "total",
      },
        {
            targets : 2,
            data : "total",
        },
      {
        targets : 3,
        data : "total",
        render : function(data){
          if(data <= 100){
            return "F"
          }else if(data >=100 && data <= 200){
            return "E"
          }else if(data >= 200 && data <=300){
            return "D"
          }else if(data >= 300 && data <= 400){
            return "C"
          }else if(data >= 400 && data <= 500){
            return "B"
          }else{
            return "A"
          }
        }
      },
      {
        targets : 4,
        data : "students_id",
        render : function(data){
          return '<a href="./_individual_student_result.php?student_id='+data+'"> Print </a>'
        }
      }
    ]
  });

  setInterval(function () {
    class_exam_subject.ajax.reload(null, false);
  }, 100000);

  setInterval(function(){
    class_exam_student_table.ajax.reload(null, false);
  }, 100000)





  $.ajax({
    url: "../queries/get_in_results.php",
    type: "get",
  }).done(function (response) {
    var array = JSON.parse(response); // array fetched from the db.

    for (var i = 0; i < array.length; i++) {
      var ar = array[i];
      var student_id = ar.students_id;
      console.log(`this is the students_id : ${student_id}`);
      // here is where you add it to the table row
      var subjects = ar.subject_name;
      var marks = ar.marks; //

      var subject_names = subjects.split(",");
      var mark = marks.split(",");

      console.log(`this is the mark length ${mark.length}`);
      for (var x = 0; x < mark.length; x++) {
        //the same row add the td for the same student_id
        console.log(`this is the ${subject_names[x]} marks ${mark[x]}`);
      }
      console.log(`--------------------------------------------------`);
    }
  });
});
