// $(document).ready(() => {

// variable holding the term form DOM element.
const term_form = $("#term_form");

// toast for
const toast = {
  question: () => {
    return new Promise((resolve) => {
      iziToast.question({
        title: "Warning",
        icon: "fas fa-exclamation",
        message: `You are about to delete a Term. Are you Sure?`,
        timeout: 20000,
        position: "center",
        close: false,
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
            "<button><b>NO</b></button>",
            function (instance, toast, button, e, inputs) {
              instance.hide({ transitionOut: "fadeOut" }, toast, "button");
            },
          ],
        ],
      });
    });
  },
};

const terms_table = $("#terms_table").DataTable({
  order: [[1, "DESC"]],
  ajax: {
    url: "./queries/get_all_terms.php",
    dataSrc: "",
    type: "GET",
  },
  columnDefs: [
    {
      targets: 0,
      data: "name",
    },
    {
      targets: 1,
      data: "created_at",
    },
    {
      targets: 2,
      data: "created_by",
    },
    {
      targets: 3,
      orderable: false,
      width: "5%",
      data: "id",
      render: (data) => {
        return `<a class="fas fa-trash" style="color:red" onclick="deleteTerm(${data})"></a>
                <a class="fas fa-edit" href=""></a>
        `;
      },
    },
  ],
});

function deleteTerm(term_id) {
  toast.question().then(() => {
    $.ajax({
      url: "./queries/delete_term.php",
      type: "POST",
      data: {
        term_id: term_id,
      },
    })
      .done((response) => {
        const j = JSON.parse(response);
        if (j.success == true) {
          iziToast.success({
            type: "Success",
            position: "topRight",
            transitionIn: "bounceInLeft",
            message: j.message,
            onClosing: () => {
              terms_table.ajax.reload(null, false);
            },
          });
        } else {
          iziToast.error({
            type: "Error",
            position: "topRight",
            transitionIn: "bounceInLeft",
            message: j.message,
            onClosing: () => {
              terms_table.ajax.reload(null, false);
            },
          });
        }
      })
      .fail((error) => {
        console.log(error);
      });
  });
}

term_form.validate({
  rules: {
    term_name: {
      required: true,
      minlength: 4,
    },
  },
  messages: {
    term_name: {
      required: "Term name is required",
    },
  },

  errorClass: "alert alert-danger",
  validClass: "success",

  submitHandler: function (form) {
    $.ajax({
      url: "./queries/add_new_term.php",
      type: "POST",
      data: $(form).serialize(),
    })
      .done((response) => {
        const res = JSON.parse(response);
        if (res.success == true) {
          iziToast.success({
            type: "Success",
            position: "topRight",
            transitionIn: "bounceInRight",
            message: res.message,
          });
        } else {
          iziToast.error({
            type: "Error",
            position: "topRight",
            transitionIn: "bounceInRight",
            message: res.message,
          });
        }
      })
      .fail((e) => {
        iziToast.error({
          type: "Error",
          position: "topRight",
          transitionIn: "bounceInRight",
          message: e,
        });
      });
  },

  invalidHandler: function (event, validator) {
    const errors = validator.numberOfInvalids();
    if (errors) {
      const message =
        errors == 1 ? "You missed 1 field" : `You missed ${errors} fields`;
      $("div.errors span").html(message);
      $("div.errors").show();
    } else {
      $("div.errors").hide();
    }
  },
});

setInterval(() => {
  terms_table.ajax.reload(null, false);
}, 100000);
// });
