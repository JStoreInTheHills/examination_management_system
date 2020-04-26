var class_id_queryString = window.location.search;
var class_id_urlParams = new URLSearchParams(class_id_queryString);

var class_id = class_id_urlParams.get("classid");

$(function () {
  var view_class_table = $("#view_class").DataTable({
    ajax: {
      url: "../queries/get_class_exams.php",
      type: "GET",
      dataSrc: "",
      data: {
        class_id: class_id,
      },
    },
    columnDefs: [
      {
        targets: 0,
        data: "exam_name",
      },
      {
        targets: 1,
        data: "year_name",
      },
      {
        targets: 2,
        data: "created_at",
      },
      {
        targets: 3,
        data: "created_by",
      },
      {
        targets: 4,
        data: "id",
        orderable: false,
        render: function (data) {
          return (
            '<div class="dropdown">' +
            ' <a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
            '<i class="icon-menu9"></i>' +
            '</a> <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
            "" +
            '<a class="dropdown-item" id="view" href="./class_exams.php?id=' +
            data +
            '">View Performance</a>' +
            '<a class="dropdown-item" href="queries/delete_class.php?classid=' +
            data +
            '">Remove Exam from Class</a>' +
            '<a class="dropdown-item" href="queries/delete_class.php?classid=' +
            data +
            '">Mark as Closed</a>' +
            "</div></div>" +
            ""
          );
        },
      },
    ],
  });

  var view_class_student = $("#view_class_student").DataTable({
    ajax: {
      url: "../queries/get_class_students.php",
      type: "GET",
      data: {
        class_id: class_id,
      },
      dataSrc: "",
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
        data: "RegDate",
      },
      {
        targets: 3,
        data: "DOB",
      },
      {
        targets: 4,
        data: "Gender",
      },
      {
        targets: 5,
        data: "Status",
      },
      {
        targets: 6,
        orderable: false,
        data: "StudentId",
        render: function (data) {
          return data;
        },
      },
    ],
  });

  setInterval(function () {
    view_class_student.ajax.reload(null, false);
  }, 1000000);

  setInterval(function () {
    view_class_table.ajax.reload(null, false);
  }, 100000);

  $("#view_class_submit").on("click", function (event) {
    event.preventDefault();

    var formData = {
      exam_id: $("#exam_id").val(),
      year_id: $("#year_id").val(),
      class_id: class_id,
    };
    $.ajax({
      url: "../queries/add_class_exam.php",
      type: "POST",
      data: formData,
    }).done(function (response) {
      var s = JSON.parse(response);
      if (s.success === true) {
        iziToast.success({
          type: "Success",
          position: "topRight",
          message: s.message,
        });
      } else {
        iziToast.error({
          type: "Error",
          position: "topRight",
          message: s.message,
        });
      }
    });
  });
});
