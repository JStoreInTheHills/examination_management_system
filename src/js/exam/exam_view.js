// Declaration of a string holding the URI location values.
const exam_query_id = window.location.search;

// Creating an object that holds the values of the argurments in the URI.
// The URI is passed as an argurment.
const exam_id_param = new URLSearchParams(exam_query_id);

// Variable holding the value of the exam unique id
// ----------------------------------------------------------------
const exam_id = exam_id_param.get("eid");

const page_heading = $("#page_heading");
const exam_nav_label = $("#exam_nav_label");
const page_title = $("#page_title");

const exam_out_of = $("#exam_out_of");

const editExamStatusButton = $("#editExamStatusButton");
const editExamDetails = $("#editExamDetails");
const exampleModalCenterTitle = $("#exampleModalCenterTitle");

const exam_name = $("#exam_name");

const exam_out_of_edit = $("#exam_out_of_edit");
const edit_exam_form = $("#edit_exam_form");

const exam_id_edit = $("#exam_id_edit");

const r_style = $("#r_style");
var studentSelect = $("#r_style");
var isClosed;

const init = () => {
  $.ajax({
    url: "../queries/get_exam_details.php",
    type: "GET",
    data: {
      eid: exam_id,
    },
  }).done((response) => {
    const arr = JSON.parse(response);

    let status;
    let data = {};

    arr.forEach((element) => {
      page_heading.html(element.exam_name);
      exam_nav_label.html(element.exam_name);
      page_title.html(element.exam_name);
      exam_name.val(element.exam_name);
      exam_out_of_edit.val(element.exam_out_of);
      status = element.closed;
      exam_id_edit.val(exam_id);
      exam_out_of.html(`${element.exam_out_of} points`);
      exampleModalCenterTitle.html(element.exam_name);
      data.name = element.name;
      data.r_style = element.r_style;
    });

    fillSelect2WithData(data);
    checkIfExamIsClosed(status);
  });
};

init();

function fillSelect2WithData(data) {
  var option = new Option(data.name, data.r_style, true, true);
  studentSelect.append(option).trigger("change");
  studentSelect.trigger({
    type: "select2:select",
    params: {
      data: data,
    },
  });
}

function checkIfExamIsClosed(status) {
  if (status == 1) {
    $("#alert").html(`
        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>This Exam is Active. </strong>
                        <hr>
                        <p class="mb-0">You can close the exam by click on close exam button above. </p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
        `);
    isClosed = status;

    editExamStatusButton.html(`Make Inactive`);
  } else {
    $("#alert").html(`
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>This Exam has been Closed.</strong>
                        <hr>
                        <p class="mb-0">Student Results cannot be added to the Exam. Use the button above to open the exam period. </p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
        `);
    isClosed = status;
    editExamStatusButton.html(`Make Active`);
  }
}

const toast = {
  question: function () {
    return new Promise(function (resolve) {
      iziToast.error({
        title: "Warning",
        icon: "fas fa-exclamation-triangle",
        message: "Are you sure you want to change the status of this Exam?",
        timeout: 20000,
        close: false,
        zindex: 999,
        overlay: true,
        displayMode: "once",
        titleSize: "50",
        messageColor: "black",
        timeout: 200000,
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

editExamStatusButton.click(() => {
  toast.question().then(() => {
    $.ajax({
      url: "../queries/edit_exam_status",
      type: "POST",
      data: {
        exam_id: exam_id,
        status: checkExamStatusBeforeEdit(),
      },
    }).done((response) => {
      const arr = JSON.parse(response);
      if (arr.success == true) {
        iziToast.success({
          message: arr.message,
          messageColor: "black",
          position: "topRight",
          transitionIn: "bounceInUp",
          overlay: true,
          onClosing: () => {
            init();
          },
        });
      } else {
        iziToast.error({
          message: arr.message,
          messageColor: "black",
          position: "topRight",
          transitionIn: "bounceInUp",
          overlay: true,
        });
      }
    });
  });
});

function checkExamStatusBeforeEdit() {
  let status;
  if (isClosed == 1) {
    status = 0;
    return status;
  } else {
    status = 1;
    return status;
  }
}

editExamDetails.html(`Edit Exam`);

editExamDetails.click(() => {
  $("#exampleModalCenter").modal("show");
});

edit_exam_form.validate({
  rules: {
    exam_name: {
      required: true,
    },
    exam_out_of_edit: {
      required: true,
      number: true,
    },
  },
  errorClass: "text-danger",

  submitHandler: (form) => {
    $.ajax({
      url: "../queries/update_exam_details.php",
      type: "POST",
      data: $(form).serialize(),
    }).done((response) => {
      const arr = JSON.parse(response);
      if ((arr.success = true)) {
        iziToast.success({
          message: arr.message,
          position: "topRight",
          transitionIn: "bounceInUp",
          overlay: true,
          onClosing: () => {
            $("#exampleModalCenter").modal("hide");
            init();
          },
        });
      }
    });
  },
});

r_style.select2({
  theme: "bootstrap4",
  placeholder: "Type to select Report style",
  ajax: {
    url: "../queries/fetchReportingStyle",
    dataType: "json",
    processResults: function (data) {
      return {
        results: data,
      };
    },
  },
});
