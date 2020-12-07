// $(document).ready(() => {
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const year_id = urlParams.get("year_id");

const all_exams_this_year = $("#all_exams_this_year");

//Form holding the year inputs
const year_form = $("#year_form");

// Edit Year button to modify the years details.
const edit_academic_year = $("#edit_academic_year");

//
const term_name = $("#term_name");

// data fetched through ajax call for the term year table.

// Constructor method that populates everything.
const init = () => {
  $("button").prop("disabled", true);
  $.ajax({
    url: "../queries/get_year_details.php",
    data: {
      year_id: year_id,
    },
    type: "GET",
  }).done((response) => {
    const arr = JSON.parse(response);
    arr.forEach((items) => {
      $("#year_title").append(`Academic Year - ${items.year_name}`);
      $("#heading").html(`Academic Year ~ ${items.year_name}`);
      $("#bread_list").html(`${items.year_name}`);
      edit_academic_year.html(`Edit Academic Year ${items.year_name}`);

      const alert = $("#alert").html(`
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>View Year ${items.year_name} and its terms. All the terms performance for the year ${items.year_name} in the school are defined on the table below.</strong>
            <hr>
              <p class="mb-0">Click on edit Academic year to modify or click on one of the terms 
                to view more details and the performance</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        `);
    });
    $("button").prop("disabled", false);
  });
};

init();

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
        position: "topRight",
        transitionIn: "bounceInLeft",
        message: arr.message,
        onClosing: () => {
          term_year_table.ajax.reload(null, false);
        },
      });
    } else {
      iziToast.error({
        type: "Error",
        position: "topRight",
        transitionIn: "bounceInLeft",
        message: arr.message,
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
            
            <a onClick="deleteTermFromYear()">
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
      data:{
        ClassName : "ClassName",
        id : "id",
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
  console.log("Hi There");
});

get_all_exams_this_year();

setInterval(() => {
  class_end_year_table.ajax.reload();
}, 10000000);
// });
