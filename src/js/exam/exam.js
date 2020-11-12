const r_style = $("#r_style");
const exam_form = $("#exam_form");

const exam_table = $("#exam_table").DataTable({
  ajax: {
    url: "./queries/get_all_exams.php",
    dataSrc: "",
    type: "GET",
  },
  columnDefs: [
    {
      targets: 1,
      data: {
        exam_name: "exam_name",
        exam_id: "exam_id",
      },
      render: (data) => {
        return `<a href="./pages/exam_view?eid=${data.exam_id}">${data.exam_name}</a>`;
      },
    },
    {
      targets: 0,
      data: "created_at",
    },
    {
      targets: 2,
      data: "exam_out_of",
      width: "10%",
    },
    {
      targets: 3,
      data: "created_by",
    },
    {
      targets: 4,
      width: "5%",
      orderable: false,
      data: "exam_id",
      render: function (data) {
        return `<a style="color:red" onClick="deleteExam(${data})" class="fas fa-trash"></a>`;
      },
    },
  ],
});

r_style.select2({
  theme: "bootstrap4",
  placeholder: "Type to choose a Reporting style",
  ajax: {
    url: "./queries/fetchReportingStyle",
    dataType: "json",
    processResults: function (data) {
      return {
        results: data,
      };
    },
  },
});

const toast = {
  question: function () {
    return new Promise(function (resolve) {
      iziToast.error({
        title: "Warning",
        icon: "fas fa-exclamation-triangle",
        message: "Are you sure you want to delete this Exam?",
        timeout: 20000,
        close: false,
        overlay: true,
        zindex: 999,
        transitionIn: "bounceInUp",
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
        transitionIn: "bounceInUp",
        overlay: true,
        zindex: 999,
        onClosing: function () {
          exam_table.ajax.reload(null, false);
        },
      });
    });
  });
}

exam_form.validate({
  rules: {
    exam_name: "required",
    exam_out_of: "required",
    r_style: "required",
  },
  errorClass: "text-danger",
  submitHandler: (form) => {
    $.ajax({
      url: "./queries/add_exam.php",
      method: "POST",
      data: $(form).serialize(),
    }).done(function (response) {
      var arr = JSON.parse(response);
      if (arr.success === true) {
        iziToast.success({
          title: "Success",
          icon: "fas fa-certificate",
          position: "topRight",
          overlay: true,
          zindex: 999,
          transitionIn: "bounceInUp",
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
          transitionIn: "bounceInUp",
          overlay: true,
          zindex: 999,
          message: arr.message,
        });
      }
    });
  },
});

setInterval(function () {
  exam_table.ajax.reload(null, false);
}, 100000);
