var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);

var class_name = urlParams.get("class_name");
var academic_year = urlParams.get("academic_year");

var formData = {
  class_name: class_name,
  academic_year: academic_year,
};

var heading = $("#heading");
heading.append(`${class_name} ~ Academic Year ~ ${academic_year}`);
$("#academic_title").append(`${academic_year} || ${class_name}`);
$("#bread_list").append(
  `<a href="/academic_year/page/view_academic_year.php?year_name=${academic_year}">${academic_year}</a>`
);
$("#bread_list2").append(`${class_name}`);

// tables.
var table = $("#table");
var class_academic_table = $("#class_academic_table");



table.DataTable({
  ajax: {
    url: "./../queries/class_exam_results.php",
    data: formData,
    type: "GET",
    dataSrc: "",
  },
  columnDefs: [
    {
      targets: 0,
      data: "exam_name",
      render: function (data) {
        return `<a href="#">${data}</a>`;
      },
    },
  ],
});

class_academic_table.DataTable({
  ajax: {
    url: "./../queries/class_academic_year_exam_students.php",
    type: "GET",
    dataSrc: "",
    data: formData,
  },
  columnDefs: [
    {
      targets: 0,
      data: {
        StudentName: "StudentName",
        StudentId: "StudentId",
      },
      render: function (data) {
        return `<a href="./page/print_result.php?sid=${data.StudentId}">${data.StudentName}</a>`;
      },
    },
    {
      targets: 1,
      data: "RollId",
    },
    {
      targets: 2,
      data: "StudentId",
      render: function (data) {
        return `${data}`;
      },
    },
  ],
});

// Intervals
setInterval(function () {
  class_academic_table.ajax.reload(null, false);
  table.ajax.reload(null, false);
}, 100000);
