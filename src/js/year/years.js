// Official js page for the year file.

// variable holding the year input form field.
const year_form = $("#year_form");

const year_heading = $("#year_heading");

const academic_year_title = $("#title");

const school = sessionStorage.getItem("school_name");

const init = () => {
  academic_year_title.html(`Academic Years - ${school}`);
  year_heading.html(`Academic Years (Academic Periods).`);

  const alert = $("#alert").html(`
      <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>This is the Academic year window. It contains all the academic years in the school.</strong>
      <hr>
        <p class="mb-0">Click on add year to add a new Academic year or click on one of the years to view more details</p>
      </div>
    `);
};

init();

// variable holding the year DataTable.
const year_table = $("#year_table").DataTable({
  ajax: {
    url: "./queries/fetch_all_academic_years.php",
    dataSrc: "",
    type: "GET",
  },
  columnDefs: [
    {
      targets: 0,
      data: "created_at",
    },
    {
      targets: 1,
      data: {
        year_id: "year_id",
        year_name: "year_name",
      },
      render: function (data) {
        return `<a href="./page/view_academic_year?year_id=${data.year_id}">${data.year_name}</a>`;
      },
    },
  
    {
      targets: 2,
      data: {
        status: "status",
      },
      render: function (data) {
        if (data.status == "1") {
          return `<span class="badge badge-pill badge-success">Active</span>`;
        } else {
          return `<span class="badge badge-pill badge-danger">Closed</span>`;
        }
      },
    },
    {
      targets: 3,
      data: "term_count",
      width: "15%",
    },
    {
      targets: 4,
      orderable: false,
      width: "5%",
      data: {
        year_id: "year_id",
        status: "status",
      },
      render: function (data) {
        return ` 
                <a class="text-primary" onClick="makeYearInactive(${data.year_id}, ${data.status})">
                  <i class="fas fa-edit"></i>
                </a>

                <a style = "color:red" onClick="deleteAcademicYear(${data.year_id})">
                    <i class="fas fa-trash"></i>
                </a>`;
      },
    },
  ],
});

const toast = {
  question: function () {
    return new Promise(function (resolve) {
      iziToast.question({
        title: "WARNING",
        icon: "fa fa-exclamation-triangle",
        message: "Are you Sure you want to delete this Academic Year?",
        timeout: 20000,
        close: false,
        transitionIn: "bounceInLeft",
        position: "center",
        overlay: true,
        buttons: [
          [
            "<button><b>YES</b></button>",
            function (instance, toast, button, e, inputs) {
              instance.hide(
                {
                  transitionOut: "fadeOut",
                },
                toast,
                "button"
              );
              resolve();
            },
            false,
          ],
          [
            "<button>NO</button>",
            function (instance, toast, button, e, inputs) {
              instance.hide(
                {
                  transitionOut: "fadeOut",
                },
                toast,
                "button"
              );
            },
          ],
        ],
      });
    });
  },
  warning: function () {
    return new Promise(function (resolve) {
      iziToast.error({
        title: "WARNING",
        icon: "fa fa-exclamation-triangle",
        message: "Are you Sure you want to change the status of this year?",
        timeout: 20000,
        close: false,
        transitionIn: "bounceInLeft",
        position: "center",
        buttons: [
          [
            "<button><b>YES</b></button>",
            function (instance, toast, button, e, inputs) {
              instance.hide(
                {
                  transitionOut: "fadeOut",
                },
                toast,
                "button"
              );
              resolve();
            },
            false,
          ],
          [
            "<button>NO</button>",
            function (instance, toast, button, e, inputs) {
              instance.hide(
                {
                  transitionOut: "fadeOut",
                },
                toast,
                "button"
              );
            },
          ],
        ],
      });
    });
  },
};

const makeYearInactive = (year_id, status) => {
  let s;

  if (status == 1) {
    s = 0;
  } else {
    s = 1;
  }

  toast.warning().then(function () {
    $.ajax({
      url: "./queries/makeYearInactive.php",
      type: "POST",
      data: {
        year_id: year_id,
        status: s,
      },
    }).done((response) => {
      const l = JSON.parse(response);

      if (l.success == true) {
        iziToast.success({
          type: "success",
          message: l.message,
          onClosing: () => {
            year_table.ajax.reload(null, false);
          },
        });
      } else {
        iziToast.danger({
          type: "danger",
          message: l.message,
          onClosing: () => {
            year_table.ajax.reload(null, false);
          },
        });
      }
    });
  });
};

const deleteAcademicYear = (data) => {
  toast.question().then(() => {
    $.ajax({
      url: "./queries/delete_academic_year.php",
      type: "POST",
      data: {
        year_id: data,
      },
    })
      .done(function (response) {
        var r = JSON.parse(response);
        if (r.success === true) {
          iziToast.success({
            type: "Success",
            message: r.message,
            transitionIn: "bounceInLeft",
            position: "bottomLeft",
            overlay: true,
            messageColor: "black",
            onClosing: function () {
              year_table.ajax.reload(null, false);
            },
          });
        } else {
          iziToast.error({
            type: "Error",
            message: r.message,
            transitionIn: "bounceInLeft",
            position: "bottomLeft",
            overlay: true,
            messageColor: "black",
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
};

year_form.validate({
  rules: {
    year_name: {
      required: true,
    },
  },
  messages: {
    year_name: {
      required: "Academic year name is manadatory",
    },
  },
  errorClass: "alert alert-danger",
  submitHandler: function (form) {
    $.ajax({
      url: "./queries/add_academic_year.php",
      type: "POST",
      data: $(form).serialize(),
    }).done(function (response) {
      var r = JSON.parse(response);
      if (r.success === true) {
        iziToast.success({
          message: r.message,
          position: "bottomLeft",
          type: "Success",
          transitionIn: "bounceInLeft",
          overlay: true,
          zindex: 999,
          messageColor: "black",
          onClosing: function () {
            year_table.ajax.reload(null, false);
            $("#year_form").each(function () {
              this.reset();
            });
          },
          progressBar: false,
        });
      } else {
        iziToast.error({
          message: r.message,
          position: "bottomLeft",
          type: "Error",
          overlay: true,
          zindex: 999,
          transitionIn: "bounceInLeft",
          progressBar: false,
          messageColor: "black",
        });
      }
    });
  },
  invalidHandler: function (event, validator) {
    var errors = validator.numberOfInvalids();
    if (errors) {
      var message =
        errors == 1 ? "You missed 1 field" : `You missed ${errors} fields`;
      $("div.errors span").html(message);
      $("div.errors").show();
    } else {
      $("div.errors").hide();
    }
  },
});

setInterval(() => {
  year_table.ajax.reload(null, false);
}, 100000);
