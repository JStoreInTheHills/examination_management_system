/**
 *
 * This is the official javascript page that hoises the subjects.
 */

$(document).ready(() => {
  var subject_table = $("#subject_table").DataTable({
    ajax: {
      url: "queries/get_all_subjects.php",
      type: "GET",
      dataSrc: "",
    },
    columnDefs: [
      {
        targets: 0,
        data: "SubjectName",
        render: function (data) {
          return `<a href="./page/view_subject.php?subject_name=${data}">${data}</>`;
        },
      },
      {
        targets: 1,
        data: "SubjectCode",
      },
      {
        targets: 2,
        orderable: false,
        data: "SubjectNameAr",
      },
      {
        targets: 3,
        orderable: false,
        data: "subject_id",
        render: function (data) {
          return `
                  <a style="color:blue"><span><i class="fas fa-edit"></i></span></a>
                  <a style ="color:red" onClick="deleteSubject(${data})"> <i class="fas fa-trash"></i> </a>
                  `;
        },
      },
    ],
  });

  setInterval(function () {
    subject_table.ajax.reload(null, false);
  }, 100000);

  $("#subject_form").on("submit", function (e) {
    e.preventDefault();

    var formData = {
      subject_name: $("#subject_name").val(),
      subject_code: $("#subject_code").val(),
      ar_subject_name: $("#ar_subject_name").val(),
    };

    $.ajax({
      url: "./queries/add_subject.php",
      type: "POST",
      data: formData,
    }).done(function (response) {
      var s = JSON.parse(response);
      if (s.success === true) {
        iziToast.success({
          type: "Success",
          position: "topRight",
          message: s.message,
          onClosing: function () {
            subject_table.ajax.reload(null, false);
            $("#subject_form").each(function () {
              this.reset();
            });
          },
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

  var toast = {
    question: function () {
      return new Promise(function (resolve) {
        iziToast.question({
          title: "Warning",
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

  function deleteSubject(subject_id) {
    toast.question().then(function () {
      $.ajax({
        url: "./queries/delete_subject.php",
        type: "POST",
        data: {
          subject_id: subject_id,
        },
      })
        .done(function (response) {
          var r = JSON.parse(response);
          if (r.success === true) {
            iziToast.success({
              type: "Success",
              onClosing: function () {
                subject_table.ajax.reload(null, false);
              },
              message: r.message,
            });
          } else {
            iziToast.error({
              type: "Error",
              message: r.message,
            });
          }
        })
        .fail(function (response) {
          iziToast.error({
            type: "Error",
            message: "Error Check Again",
          });
        });
    });
  }

  let print_subjects = $("#print_subjects").on("click", function (event) {});
});
