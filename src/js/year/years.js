// $(document).ready(() => {
// Official js page for the year file.

// variable holding the year input form field.
const year_form = $("#year_form");

const year_heading = $("#year_heading");

const academic_year_title = $("#academic_year_title");

const school = sessionStorage.getItem("school");

const init = () => {
  academic_year_title.html(`Academic Years - ${school}`);
  year_heading.html(`Academic Years `);

  const alert = $("#alert").html(`
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>This is the Academic year window. It contains all the academic years in the school.</strong>
      <hr>
        <p class="mb-0">Click on add year to add a new Academic year or click on one of the years to view more details</p>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
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
      targets: 0,
      data: "created_at",
    },
    {
      targets: 2,
      orderable: false,
      data: "year_id",
      render: function (data) {
        var string = `<a style = "color:red"  onClick="deleteAcademicYear(${data})"><i class="fas fa-trash"></i></a>`;
        return string;
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
            onClosing: function () {
              year_table.ajax.reload(null, false);
            },
          });
        } else {
          iziToast.error({
            type: "Error",
            message: r.message,
            transitionIn: "bounceInLeft",
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
      minlength: 4,
      number: true,
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
          position: "topRight",
          type: "Success",
          transitionIn: "bounceInLeft",
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
          position: "topRight",
          type: "Error",
          transitionIn: "bounceInLeft",
          progressBar: false,
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
// });
