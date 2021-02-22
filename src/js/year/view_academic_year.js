// $(document).ready(() => {
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const year_id = urlParams.get("year_id");

const all_exams_this_year = $("#all_exams_this_year");

//Form holding the year inputs
const year_form = $("#year_form");

// Edit Year button to modify the years details.
const edit_academic_year = $("#edit_academic_year");

let year_acroynm;

//
const term_name = $("#term_name");

async function init() {
  const year = {};
  const request = await fetch(`../queries/get_year_details?year_id=${year_id}`);
  const response = await request.text();
  const parsed = JSON.parse(response);
  parsed.forEach((item) => {
    year.year_name = item.year_name;
    year.created_at = item.created_at;
    year.status = item.status;
  });

  return year;
}
const alert = $("#alert");

async function setYearDetails() {
  const year = await init();
  $("#title").append(`Academic Year - ${year.year_name}`);
  $("#title").append(`Academic Year - ${year.year_name}`);
  $("#heading").val(`${year.year_name}`);
  $("#bread_list").html(`${year.year_name}`);
  edit_academic_year.html(`Delete This Academic Year`);
  $("#creation_date").html(`Created At : ${year.created_at}`);

  year_acroynm = year.year_name;

  if (year.status === "1") {
    $("#status").html(
      ` <span class="badge badge-pill badge-success">Active</span>`
    );
    alert.html(`
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>View Academic year ${year.year_name} and its terms. All the terms performance for the year ${year.year_name} in the school are defined on the table below.</strong>
            <hr>
              <p class="mb-0">Click on edit Academic year to modify or click on one of the terms 
                to view more details and the performance</p>
            </div>
        `);
  } else {
    $("#status").html(
      ` <span class="badge badge-pill badge-danger">InActive</span>`
    );
    alert.html(`
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>View Academic year ${year.year_name} and its terms. All the terms performance for the year ${year.year_name} in the school are defined on the table below.</strong>
    <hr>
      <p class="mb-0">Click on edit Academic year to modify or click on one of the terms 
        to view more details and the performance</p>
    </div>
`);
  }
}
setYearDetails();

// Function to get the terms
const get_terms = () => {
  $.ajax({
    url: "../queries/get_academic_terms.php",
    type: "GET",
  }).done((resp) => {
    const arr = JSON.parse(resp);

    if (arr.length == 0) {
      $("#card_alert")
        .html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Terms have not yet been added. </strong>
        <hr>
          <p class="mb-0">Please add terms to proceed</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>`);

      $("#form_submit").prop(`disable`);
    }

    arr.forEach((item) => {
      term_name.append(`<option value="${item.id}">${item.name}</option>`);
    });
  });
};

get_terms();

year_form.submit((event) => {
  const formData = {
    year_id: year_id,
    term_id: term_name.val(),
  };
  $.ajax({
    url: "../queries/add_term_to_year.php",
    type: "GET",
    dataSrc: "",
    data: formData,
  }).done((resp) => {
    const arr = JSON.parse(resp);
    if (arr.success == true) {
      iziToast.success({
        type: "Success",
        position: "bottomLeft",
        transitionIn: "bounceInLeft",
        message: arr.message,
        zindex: 999,
        overlay: true,
        onClosing: () => {
          term_year_table.ajax.reload(null, false);
        },
      });
    } else {
      iziToast.error({
        type: "Error",
        position: "bottomLeft",
        transitionIn: "bounceInLeft",
        message: arr.message,
        zindex: 999,
        overlay: true,
      });
    }
  });

  event.preventDefault();
});

const formData = {
  year_id: year_id,
};

const term_year_table = $("#term_year_table").DataTable({
  ajax: {
    url: "./../queries/get_view_academic_year_terms.php",
    dataSrc: "",
    type: "GET",
    data: formData,
  },
  columnDefs: [
    {
      targets: 1,
      data: {
        name: "name",
        term_year_id: "term_year_id",
      },
      render: (data) => {
        return `<a href="./view_academic_year_term_performance?term_id=${data.term_year_id}&year_id=${year_id}">${data.name}</a>`;
      },
    },
    {
      targets: 0,
      data: "created_at",
    },
    {
      targets: 2,
      data: "created_by",
    },
    {
      targets: 3,
      data: "status",
      render: function (data) {
        if (data == "1") {
          return `<span class="badge badge-pill badge-success">Active</span>`;
        } else {
          return `<span class="badge badge-pill badge-danger">InActive</span>`;
        }
      },
    },
    {
      targets: 4,
      data: {
        status: "status",
        term_year_id: "term_year_id",
      },
      render: (data) => {
        return `
          <div>
            <a onClick="editTermFromYear(${data.term_year_id}, ${data.status})">
              <span><i class="fas fa-edit text-primary"></i></span>
            </a>
            
            <a onClick="deleteTermFromYear(${data.term_year_id})">
              <span><i class="fas fa-trash text-danger"></i></span>
            </a>
          </div>
          `;
      },
    },
  ],
});

const questionToast = {
  question: () => {
    return new Promise((resolve) => {
      iziToast.error({
        title: "Warning",
        icon: "fas fa-exclamation-triangle",
        message: "Are you Sure you want to change the status of this term?",
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

function editTermFromYear(term_id, status) {
  questionToast.question().then(function () {
    let s;
    if (status == 1) {
      s = 0;
    } else {
      s = 1;
    }
    $.ajax({
      url: "../queries/makeTermYearInactive.php",
      type: "POST",
      data: {
        status: s,
        term_year_id: term_id,
      },
    }).done(function (resp) {
      const l = JSON.parse(resp);
      if (l.success == true) {
        iziToast.success({
          type: "Success",
          message: l.message,
          position: "topRight",
          transitionIn: "bounceInRight",
          onClosing: () => {
            term_year_table.ajax.reload(null, false);
          },
        });
      } else {
        iziToast.error({
          type: "Error",
          message: l.message,
          position: "topRight",
          transitionIn: "bounceInRight",
        });
      }
    });
  });
}

const class_end_year_table = $("#class_end_year_table").DataTable({
  ajax: {
    url: "./../queries/fetch_class_end_year_result.php",
    dataSrc: "",
    type: "GET",
    data: formData,
  },
  columnDefs: [
    {
      targets: 1,
      data: {
        ClassName: "ClassName",
        id: "id",
      },
      render: function (data) {
        return `<a href="./view_class_academic_year_performance?cid=${data.id}&yid=${year_id}">${data.ClassName}</a>`;
      },
    },
    {
      targets: 2,
      data: "ClassNameNumeric",
    },
    {
      targets: 3,
      data: "ClassTeacher",
    },
    {
      targets: 4,
      data: "name",
    },
    {
      targets: 0,
      data: "CreationDate",
    },
  ],
});

function get_all_exams_this_year() {
  $.ajax({
    url: "/utils/get_all_exams_this_year.php",
    type: "GET",
    data: {
      year_id: year_id,
    },
  }).done(function (response) {
    const j = JSON.parse(response);
    j.forEach((item) => {
      all_exams_this_year.append(`${item.exams}`);
    });
  });
}

edit_academic_year.click(() => {
  $("#modal_aside_left").modal({
    show: true,
    keyboard: false,
    backdrop: "static",
  });
});

get_all_exams_this_year();

setInterval(() => {
  class_end_year_table.ajax.reload();
}, 10000000);
// });

async function getAllStudentsRegisteredThisYear() {
  await setYearDetails();
  let year_name = year_acroynm;
  let start_query = year_name.slice(0, 4);
  let end_query = year_name.slice(5, 9);
  const request = await fetch(
    `../queries/fetch_all_registered_students_this_year?start=${start_query}&end=${end_query}`
  );
  const response = await request.text();

  const parsed = JSON.parse(response);

  $("#all_students_registered_this_year").html(parsed);
}

getAllStudentsRegisteredThisYear();

$(".edit_school_input").on("keypress", (e) => {
  $("#year_id").val(year_id);
  if (e.which == 13) {
    $("#edit_year_form").validate({
      rules: {
        heading: "required",
      },
      errorClass: "text-danger",
      submitHandler: (form) => {
        $.ajax({
          url: "../queries/edit_academic_year.php",
          type: "post",
          data: $(form).serialize(),
        }).done((response) => {
          const arr = JSON.parse(response);
          if (arr.success == true) {
            iziToast.success({
              position: "bottomLeft",
              message: arr.message,
              messageColor: "black",
              overlay: true,
              zindex: 999,
              progressBar: false,
              onClosing: () => {
                setYearDetails();
              },
            });
          } else {
            iziToast.error({
              position: "bottomLeft",
              message: arr.message,
              messageColor: "black",
              overlay: true,
              zindex: 999,
              progressBar: false,
            });
          }
        });
      },
    });
  }
});

function deleteTermFromYear(id) {
  $.post("../queries/Models/term_year/delete_term_from_year.php", {
    id: id,
  }).done(function (response) {
    const arr = JSON.parse(response);
    if (arr.success == true) {
      iziToast.success({
        message: arr.message,
        position: "bottomLeft",
        overlay: true,
        zindex: 999,
        onClosing: () => {
          term_year_table.ajax.reload(null, false);
        },
      });
    } else {
      iziToast.error({
        message: arr.message,
        position: "bottomLeft",
        overlay: true,
        zindex: 999,
      });
    }
  });
}
