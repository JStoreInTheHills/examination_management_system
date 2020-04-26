$(function () {
  var class_table = $("#class_table").DataTable({
    ajax: {
      url: "queries/get_all_classes.php",
      type: "GET",
      dataSrc: "",
    },
    columnDefs: [
      {
        targets: 0,
        data: "ClassName",
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
        data: "number_of_subjects",
      },
      {
        targets: 4,
        data: "number_of_students",
      },
      {
        targets: 5,
        data: "id",
        orderable: false,
        render: function (data, type, row, meta) {
          return (
            '<div class="dropdown">' +
            ' <a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
            '<i class="icon-menu9"></i>' +
            '</a> <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
            "" +
            // '<a class="dropdown-item"  href='+data+'"/class/page/add_subject_to_class.php?cid=">Add Subject to Class</a>' +
            '<a class="dropdown-item" id="view" href="page/view_class.php?classid=' +
            data +
            '">View</a>' +
            '<a class="dropdown-item" href="queries/delete_class.php?classid=' +
            data +
            '">Delete</a>' +
            "</div></div>" +
            ""
          );
        },
      },
    ],
  });

  setInterval(function(){
      class_table.ajax.reload(null,false);
  }, 100000)

  $("#class_form").on("submit", function (e) {
    e.preventDefault();

    var formData = {
      ClassName: $("#ClassName").val(),
      ClassNameNumeric: $("#ClassNameNumeric").val(),
      stream_id: $("#stream_id").val(),
    };

    $.ajax({
      url: "queries/add_class.php",
      method: "POST",
      data: formData,
    }).done(function (response) {
      var arr = JSON.parse(response);

      if (arr.success === true) {
        iziToast.success({
          title: "Success",
          position: "topRight", // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
          message: arr.message,
        });
      } else {
        iziToast.error({
          title: "Error",
          position: "topRight",
          message: arr.message,
        });
      }
    });
  });
  $("#add_class").on("click", function (e) {
    e.preventDefault();
    $("#class_main_content").toggle();

    $("#class_add_card").show();
    class_table.ajax.reload(null, false);
  });

  $("#add_subject_to_class").on("click", function (e) {
    e.preventDefault();
    $("#class_main_content").toggle();

    $("#subject_add_card").show();
  });
  $("#cancel_add_class").on("click", function (e) {
    e.preventDefault();
    $("#class_main_content").show();
    $("#class_add_card").toggle();
  });
  $("#cancel_add_subject").on("click", function (e) {
    e.preventDefault();
    $("#class_main_content").show();
    // $('#add_subject_to_class').toggle();
  });
  $("#subject_form_add").on("submit", function (e) {
    e.preventDefault();
  });

  $('[data-toggle="datepicker"]').datepicker({
    format: "dd-mm-yyyy",
    autoHide: true,
  });
});
