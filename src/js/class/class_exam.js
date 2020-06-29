/**
 * This is the Class Exam Main JS file.
 * It contains subject performance table, student result table and the subject performance chart
 * the chart, the subject performance table and the student result table refresh after 100000 ms.
 * the heading is appended from this file.
 * the rest of the code uses the above variables to query the database using ajax jquery calls.
 *
 * author: Salim Juma.
 */

var queryString = window.location.search; // points to the url and store the value in a variable
var urlParams = new URLSearchParams(queryString); // the url is passed as an argurment to the search

var class_exam_id = urlParams.get("id"); // the pointer holds the value that match the passed argurment
var cid = urlParams.get("class_id"); // the pointer also holds the value of the matching passed value
var class_exam_name = urlParams.get("exam_name"); // the pointer holds the value of the matching passed argurment
var class_name = urlParams.get("class_name"); // the pointer now holds the value of the matching passed argurment

// Setting the heading and the page title using jquery.
$("#heading").append(`${class_name} ~ ${class_exam_name} Performance`);
$("#page_title").append(`${class_name} || ${class_exam_name} Performance`);
$("#class_name").append(`${class_name}`);
$("#class_exam").append(`${class_exam_name}`);
// The exam subject datatable. fetches the performance of students per subjects using average and total marks obtained.
// We pass the class and class_exam ids as parameters to be used to query the database.
var class_exam_subject = $("#class_exam_subject_table").DataTable({
  order: [[2, "desc"]],
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
        concat: "concat",
        marks: "marks",
      },
      render: function (data) {
        var x = data.concat;
        var marks = data.marks;
        var y = x.split(",");
        return Math.round(marks / y.length);
      },
    },
  ],
});

/**
 * This is the students datatables. fetches the performance of students in an exam. The total and mean score are placed here
 * We pass the class and class_exam id as parameters for the call
 */
var class_exam_student_table = $("#class_exam_student_table").DataTable({
  order: [[3, "desc"]],
  ajax: {
    url: "../queries/fetch_class_exams_student_performance.php",
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
      data: "StudentName",
    },
    {
      targets: 1,
      data: "RollId",
    },
    {
      targets: 2,
      data: "total", // this is the sum of all the marks of the student for that exam.
    },
    {
      targets: 3,
      data: {
        total: "total", // total marks of the students.
        subjects: "subjects", // string from group_concat values of the result.
        subject: "subject", //count of all the subject the class sits for
      },
      render: function (data) {
        let total_marks = data.total, // declaration of total marks.
          d = data.subjects; // declararion and assigning of the string concatenated .

        let l = d.split(","); // split the string to array and find the length of the array.
        if (data.subject == l.length) {
          // comparing the value of count subjects against length of the array.
          var total = total_marks / l.length;
          return total.toFixed(2);
        } else {
          return `__`; //return this if the student didnt sit for all the exams.
        }
      },
    },
    {
      targets: 4,
      data: {
        total: "total",
        subject: "subject",
      },
      render: function (data) {
        var t = data.total;
        var s = data.subject;
        var result = t / s;

        result = Math.round(result);

        if (result >= 96) {
          return `Excellent`;
        } else if ((result <= 95) & (result >= 86)) {
          return `Very Good`;
        } else if ((result <= 85) & (result >= 70)) {
          return `Good`;
        } else if ((result <= 69) & (result >= 50)) {
          return `Pass`;
        } else {
          return `Fail`;
        }
      },
    },
    {
      targets: 5,
      data: "subjects",
      render: function (data) {
        let d = data, //get the total subjects sat by the student in form of a string
          l = d.split(","); // remove the commas and convert to array`
        return l.length; // check the length of the array and output it.
      },
    },
    {
      targets: 6,
      data: "subjects",
      render: function (data) {
        return `Approved`;
      },
    },
    {
      targets: 7,
      data: "students_rank",
    },

    {
      targets: 8,
      orderable: false,
      data: {
        result_id: "result_id",
      },

      render: function (data) {
        return `
          <a target="_blank" href="/reports/students/report_card.php?sid=${data.students_id}&cid=${cid}&ceid=${class_exam_id}">
                  <i class="fas fa-file-pdf"></i>
          </a>    
          <a style="color:red" onClick=deleteResult(${data})><i class="fas fa-trash"></i></a>`;
      },
    },
  ],
});

function deleteResult(result_id) {
  console.log("Delete");
}

// This function gets the result of individual student
function getIndividualResult() {
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
}

// This is the chart method definition. Settings and Options are declared here. Datasets are populated from an ajax requesting
// class and class_exam id are passed as argurments.
function reloadChart() {
  var ctx = document.getElementById("chart");
  $.ajax({
    url: "/subjects/queries/get_chart1_data.php",
    type: "GET",
    data: {
      class_id: cid,
      class_exam_id: class_exam_id,
    },
  })
    .done(function (response) {
      var ds = JSON.parse(response); // Array of all subject Objects

      var label_array = []; // array that holds the charts label.
      var myChartDataSet = []; // array that holds the chart datasets data.

      for (let i = 0; i < ds.length; i++) {
        let ds_items = ds[i];
        label_array.push(ds_items.SubjectName); // pushes subjectnames to the the subject pointer.
        myChartDataSet.push(ds_items.total);
      }

      var myChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: label_array,
          datasets: [
            {
              label: "Score",
              data: myChartDataSet,
              backgroundColor: function () {
                var letters = "0123456789ABDCEF";
                var color = "#";
                for (var i = 0; i < 6; i++) {
                  color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
              },
              borderWidth: 1,
            },
          ],
        },
        options: {
          scales: {
            xAxes: [
              {
                gridLines: {
                  display: false,
                  drawBorder: true,
                },
                maxBarThickness: 65,
              },
            ],

            yAxes: [
              {
                ticks: {
                  beginAtZero: true,
                },
                gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2],
                },
              },
            ],
          },
        },
      });
    })
    .fail(function (e) {
      console.log(e);
    });
}

// get the subjects and students for that class.
function getStudent(val) {
  $.ajax({
    type: "GET",
    url: "../queries/get_student.php",
    data: {
      classid: val,
    },
    success: function (data) {
      $("#studentid").html(data);
    },
  });
  $.ajax({
    type: "GET",
    url: "../queries/get_student.php",
    data: "classid1=" + val,
    success: function (data) {
      $("#subject").html(data);
    },
  });
}

function getresult(val, clid) {
  var formData = {
    clid: $(".clid").val(),
    val: $(".stid").val(),
    class_exam_id: class_exam_id,
  };
  // console.log(formData);
  $.ajax({
    type: "GET",
    url: "../queries/get_student.php",
    data: formData,
    success: function (data) {
      $("#reslt").html(data);
    },
  });
}
// fetches the class exams using ajax call. We are passing class id as an argurment and appending the result to a select element.
function fetch_class_exams() {
  $.ajax({
    url: "../queries/fetch_class_exams.php",
    type: "GET",
    data: {
      cid: cid,
      class_exam_id: class_exam_id,
    },
  })
    .done(function (response) {
      let select = $("#class_exam_id");
      let j = JSON.parse(response);
      for (let i = 0; i < j.length; i++) {
        let item = j[i];
        let exam_name = item.exam_name;
        let exam_id = item.id;
        select
          .empty()
          .append(`<option value="${exam_id}">${exam_name}</option>`);
      }
    })
    .fail(function (e) {
      console.log(e);
    });
}
// fetching the classes using ajax call.
function fetch_class() {
  $.ajax({
    url: "../queries/fetch_class.php",
    type: "GET",
    data: {
      cid: cid,
    },
  }).done(function (response) {
    let select = $("#class");
    var j = JSON.parse(response);
    for (var i = 0; i < j.length; i++) {
      var item = j[i];
      var class_name = item.ClassName;
      var class_id = item.id;
      select
        .empty()
        .append(`<option value="${class_id}">${class_name}</option>`);
    }
  });
}

// Form submission.
$("#result_form").on("submit", function (e) {
  e.preventDefault();

  var l = $(".marks").length; // getting the length of the class element marks
  var result = []; // creating an empty array.

  for (var i = 0; i < l; i++) {
    result.push($(".marks").eq(i).val());
  }
  var formData = {
    class: cid,
    studentid: $("#studentid").val(),
    marks: result,
    class_exam_id: class_exam_id,
  };

  $.ajax({
    url: "../queries/add_results.php",
    data: formData,
    method: "POST",
  }).done(function (response) {
    $("#result_form").each(function () {
      this.reset();
    });
    var s = JSON.parse(response);
    if (s.success === true) {
      iziToast.success({
        title: "Success",
        position: "topRight", // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
        message: s.message,
        onClosing: function () {
          class_exam_student_table.ajax.reload(null, false);
          reloadChart();
        },
      });
    } else {
      iziToast.error({
        title: "Error",
        position: "topRight", // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
        message: s.message,
      });
    }
  });
});

// Invocation of the function methods. the reloadChart fetch_class and fetch_class_exams functions.
reloadChart();
fetch_class_exams();
fetch_class();

$("#calculate_student_position").on("click", () => {
  calculatePosition();
});

function calculatePosition() {
  // after all results are entered we calculate the students positions.
  // we set the exam to be inactive and cannot add more results.

  // if class_exam is inactive already, we return it to active for adding more results.

  $.ajax({
    url: "../queries/calculate_positions.php",
    type: "POST",
  }).done((response) => {});
}

// Refresh Time Intervals for all the queries updates.
setInterval(function () {
  reloadChart();
}, 10000000);

setInterval(function () {
  class_exam_subject.ajax.reload(null, false);
  class_exam_student_table.ajax.reload(null, false);
  fetch_class_exams();
}, 100000);
