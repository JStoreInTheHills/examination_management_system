let select = document.getElementById("stream_id");

function stream_request() {
  $.ajax({
    url: "./queries/fetch_streams.php",
    type: "GET",
  }).done((response) => {
    var data = JSON.parse(response);
    $.each(data, function (i, d) {
      select.append(
        `<option value="${data.stream_id}"> ${data.name} </option>`
      );
    });
  });
}

stream_request();

var class_table = $("#class_table").DataTable({
  ajax: {
    url: "queries/get_all_classes.php",
    type: "GET",
    dataSrc: "",
  },
  columnDefs: [
    {
      targets: 0,
      data: {
        id: "id",
        ClassName: "ClassName",
      },
      render: function (data) {
        return `<a href="./page/class_view.php?classid=${data.id}&class_name=${data.ClassName}" > ${data.ClassName} </a>`;
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
      data: "number_of_subjects",
      render: function (data) {
        if (data > 1) {
          return `${data} subjects`;
        } else {
          return `${data} subject`;
        }
      },
    },
    {
      targets: 4,
      data: "number_of_students",
      render: function (data) {
        if (data > 1) {
          return `${data} students`;
        } else {
          return `${data} student`;
        }
      },
    },
    {
      targets: 5,
      data: "id",
      orderable: false,
      render: function (data) {
        return `
        <a href=""><i class="fas fa-edit" title="Edit Class"></i></a>
            <a style="color:red" onClick="del(${data})" title="Delete Class"><i class="fas fa-trash"></i></a>
        `;
      },
    },
  ],
});

setInterval(function () {
  class_table.ajax.reload(null, false);
  stream_request();
}, 1000000);

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
        onClosed: function () {
          class_table.ajax.reload(null, false);
          $("#class_form").each(function () {
            this.reset();
          });
        },
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
});

$("#cancel_add_class").on("click", function (e) {
  e.preventDefault();
  $("#class_main_content").show();
  $("#class_add_card").toggle();
});

$('[data-toggle="datepicker"]').datepicker({
  format: "dd-mm-yyyy",
  autoHide: true,
});

var toast = {
  question: function () {
    return new Promise(function (resolve) {
      iziToast.question({
        title: "Question",
        message: "Are you Sure?",
        timeout: 20000,
        close: false,
        position: "center",
        buttons: [
          [
            "<button><b>YES</b></button>",
            function (instance, toast, button, e, inputs) {
              instance.hide({ transitionOut: "fadeOut" }, toast, "button");
              resolve();
            },
            false,
          ],
          [
            "<button>NO</button>",
            function (instance, toast, button, e, inputs) {
              instance.hide({ transitionOut: "fadeOut" }, toast, "button");
            },
          ],
        ],
      });
    });
  },
};

function del(data) {
  toast.question().then(function () {
    $.ajax({
      url: "./queries/delete_class.php",
      type: "POST",
      data: {
        id: data,
      },
    })
      .done(function (response) {
        let s = JSON.parse(response);
        if (s.success === true) {
          iziToast.success({
            type: "Success",
            message: s.message,
            onClosing: function () {
              class_table.ajax.reload(null, false);
            },
          });
        } else {
          iziToast.error({
            type: "Error",
            message: s.message,
          });
        }
      })
      .fail(function () {
        iziToast.error({
          type: "Error",
          message: "Error",
        });
      });
  });
}
