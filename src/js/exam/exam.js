$(document).ready(() => {
  const exam_table = $("#exam_table").DataTable({
    ajax: {
      url: "./queries/get_all_exams.php",
      dataSrc: "",
      type: "GET",
    },
    columnDefs: [
      {
        targets: 1,
        data: "exam_name",
      },
      {
        targets: 0,
        data: "created_at",
      },
      {
        targets: 2,
        data: "exam_out_of",
      },
      {
        targets: 3,
        data: "created_by",
      },
      {
        targets: 4,
        orderable: false,
        data: "exam_id",
        render: function (data) {
          return `<a style="color:red" onClick="deleteExam(${data})" class="fas fa-trash"></a>`;
        },
      },
    ],
  });

  const toast = {
    question: function () {
      return new Promise(function (resolve) {
        iziToast.question({
          title: "Warning",
          icon: "fas fa-exclamation-triangle",
          message: "Are you sure you want to delete this Exam?",
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

  function deleteExam(exam_id) {
    toast.question().then(function () {
      $.ajax({
        url: "./queries/delete_exam.php",
        type: "POST",
        data: {
          exam_id: exam_id,
        },
      }).done(function (response) {
        iziToast.success({
          type: "Success",
          icon: "fas fa-certificate",
          position: "bottomRight",
          message: "Exam Deleted Successfully",
          onClosing: function () {
            exam_table.ajax.reload(null, false);
          },
        });
      });
    });
  }

  $("#submit").click((e) => {
    var formData = {
      exam_name: $("#exam_name").val(),
      exam_out_of: $("#exam_out_of").val(),
    };
    $.ajax({
      url: "./queries/add_exam.php",
      method: "POST",
      data: formData,
    }).done(function (response) {
      var arr = JSON.parse(response);
      if (arr.success === true) {
        iziToast.success({
          title: "Success",
          icon: "fas fa-certificate",
          position: "topRight",
          message: arr.message,
          onClosing: function () {
            exam_table.ajax.reload(null, false);
            $("#exam_form").each(function () {
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
    e.preventDefault();
  });

  setInterval(function () {
    exam_table.ajax.reload(null, false);
  }, 100000);
});
