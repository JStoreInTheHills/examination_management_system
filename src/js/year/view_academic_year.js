var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);

var year_name = urlParams.get("year_name");

var class_end_year_table = $("#class_end_year_table");
var all_exams_this_year = $("#all_exams_this_year");

$("#heading").append(year_name);
$("#bread_list").append(year_name);
$("#year_title").append(`Manage || ${year_name}`);

class_end_year_table.DataTable({
  ajax: {
    url: "./../queries/fetch_class_end_year_result.php",
    dataSrc: "",
    type: "GET",
    data: {
      year_name: year_name,
    },
  },
  columnDefs: [
    {
      targets: 0,
      data: "ClassName",
      render: function (data) {
        return `<a href="./view_class_academic_year_performance.php?class_name=${data}&academic_year=${year_name}">${data}</a>`;
      },
    },
    {
      targets: 1,
      data: "ClassNameNumeric",
    },
    {
      targets: 2,
      data: "name",
    },
    {
      targets: 3,
      data: "class_result",
      render: function (data) {
        if (data === null) {
          return "0";
        } else {
          return `${data}`;
        }
      },
    },
  ],
});

function get_all_exams_this_year() {
  $.ajax({
    url: "/utils/get_all_exams_this_year.php",
    type: "get",
    data: {
      year_name: year_name,
    },
  }).done(function (response) {
    var j = JSON.parse(response);
    all_exams_this_year.append(`${j[0].exams}`);
  });
}
get_all_exams_this_year();

setInterval(function () {
  class_end_year_table.ajax.reload(null, false);
}, 100000);
