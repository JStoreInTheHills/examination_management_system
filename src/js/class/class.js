/**
 * This is the official javascript file for class page.
 */

// $(document).ready(() => {
const select = document.getElementById("stream_id");

const streamFunction = () => {
  $.ajax({
    url: "./queries/fetch_streams.php",
    type: "GET",
  })
    .done((response) => {
      let data = JSON.parse(response);
      $.each(data, function (i, d) {
        select.append(
          `<option value="${data.stream_id}"> ${data.name} </option>`
        );
      });
    })
    .fail(() => {
      iziToast.error({
        type: "Error",
        position: "topRight",
        transitionIn: "bounceInLeft",
        message: "Error fetching streams.. Refresh the page.",
      });
    });
};

streamFunction();

const classTable = $("#class_table").DataTable({
  autoWidth: true,
  info: true,
  ajax: {
    url: "queries/get_all_classes.php",
    type: "GET",
    dataSrc: "",
  },
  columnDefs: [
    {
      targets: 1,
      data: {
        id: "id",
        ClassName: "ClassName",
        ClassCode: "ClassCode",
      },
      render: function (data) {
        return `<a href="./page/class_view?classid=${data.id}"> ${data.ClassName} (${data.ClassCode}) </a>`;
      },
    },
    {
      targets: 2,
      data: "ClassNameNumeric",
    },
    {
      targets: 3,
      data: "name",
    },
    {
      targets: 4,
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
      targets: 5,
      data: "exams",

      render: function (data) {
        if (data > 1) {
          return `${data} exams`;
        } else {
          return `${data} exam`;
        }
      },
    },
    {
      targets: 6,
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
      targets: 7,
      data: "id",
      width: "3%",
      orderable: false,
      render: (data) => {
        return `
            <a style="color:red" onClick="del(${data})" title="Delete Class"><i class="fas fa-trash"></i></a>
        `;
      },
    },
    {
      targets: 0,
      data: "CreationDate",
    },
  ],
});

setInterval(() => {
  classTable.ajax.reload(null, false);
  streamFunction();
}, 1000000);

const classForm = $("#class_form");

const stream_id = $("#stream_id");

stream_id.select2({
  placeholder: "Type to Search Class",
  theme: "bootstrap4",
  ajax: {
    url: "queries/class/get_all_class_during_add_stream.php",
    type: "POST",
    dataType: "json",
    delay: 250,
    data: function (params) {
      return {
        searchTerm: params.term,
      };
    },
    processResults: function (response) {
      return {
        results: response,
      };
    },
    cache: true,
  },
});

classForm.validate({
  rules: {
    ClassName: {
      required: true,
    },
    ClassNameNumeric: {
      required: true,
      maxlength: 4,
    },
    stream_id: {
      required: true,
    },
    teachers_id: {
      required: true,
    },
  },
  errorClass: "text-danger",

  invalidHandler: function (event, validator) {
    var errors = validator.numberOfInvalids();
    if (errors) {
      var message =
        errors == 1 ? "You missed 1 field" : `You missed ${errors} fields`;
      $("div.error span").html(message);
      $("div.error").show();
    } else {
      $("div.error").hide();
    }
  },

  submitHandler: function (form) {
    $.ajax({
      url: "queries/add_class.php",
      method: "POST",
      data: $(form).serialize(),
    })
      .done(function (response) {
        let arr = JSON.parse(response);
        if (arr.success === true) {
          iziToast.success({
            title: "Success",
            position: "topRight", // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
            message: arr.message,
            transitionIn: "bounceInLeft",
            onClosed: () => {
              classTable.ajax.reload(null, false);
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
      })
      .fail(() => {
        iziToast.error({
          title: "Error",
          position: "topRight", // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
          message: "POST URI not found. ",
        });
      });
  },
});

const teachers_id = $("#teachers_id");
teachers_id.select2({
  placeholder: "Type to search for a teacher",
  theme: "bootstrap4",
  ajax: {
    url: "queries/class/get_all_teachers_during_add_stream.php",
    type: "POST",
    dataType: "json",
    delay: 250,
    data: function (params) {
      return {
        searchTerm: params.term,
      };
    },
    processResults: function (response) {
      return {
        results: response,
      };
    },
    cache: true,
  },
});

$('[data-toggle="datepicker"]').datepicker({
  format: "dd-mm-yyyy",
  autoHide: true,
});

let toast = {
  question: () => {
    return new Promise((resolve) => {
      iziToast.error({
        title: "Warning!",
        titleSize: 40,
        message:
          "Are you sure you want to delete this stream? This process is Irreversible",
        timeout: 200000,
        close: false,
        overlay: true,
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

const del = (data) => {
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
            position: "topRight",
            transitionIn: "bounceInLeft",
            message: s.message,
            overlay: true,
            onClosing: function () {
              classTable.ajax.reload(null, false);
            },
          });
        } else {
          iziToast.error({
            type: "Error",
            message: s.message,
            overlay: true,
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
};
// });
