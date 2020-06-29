var user_table = $("#users_table").DataTable({
  ajax: {
    url: "../queries/get_all_users.php",
    type: "get",
    dataSrc: "",
  },
  columnDefs: [
    {
      targets: 0,
      data: "UserName",
    },
    {
      targets: 1,
      data: "email",
    },
    {
      targets: 2,
      data: "updationDate",
    },
    {
      targets: 3,
      data: "status",
      render: function (data) {
        if (data === "1") {
          return `<span class="badge badge-pill badge-success">Active</span>`;
        } else {
          return `<span class="badge badge-pill badge-danger">InActive</span>`;
        }
      },
    },
    {
      targets: 4,
      data: "id",
      orderable: false,
      render: function (data) {
        return `<a style="color:red"> <i class="fas fa-trash"></i> </a>
                <a onClick="makeActive(${data})"> <i class="fas fa-edit"></i></a>
        `;
      },
    },
  ],
});

var toast = {
  question: function () {
    return new Promise(function (resolve) {
      iziToast.question({
        title: "Warning",
        message: "Are you Sure you want to make the User Active?",
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

function makeActive(user_id) {
  toast.question().then(function () {
    $.ajax({
      url: "../queries/make_user_active.php",
      type: "get",
      data: {
        user_id: user_id,
      },
      dataSrc: "",
    }).done(function (response) {
      let r = JSON.parse(response);

      if (r.success === true) {
        iziToast.success({
          type: "Success",
          message: r.message,
          onClosing: function () {
            user_table.ajax.reload(null, false);
          },
        });
      } else {
        iziToast.error({
          type: "Error",
          message: r.message,
        });
      }
    });
  });
}

$("#add_user").on("click", function (e) {
  e.preventDefault();
  $("#user_add_card").show();
  $("#main_content").toggle();
});

$("#user_form").on("submit", function (e) {
  e.preventDefault();
  let formData = {
    full_name: $("#user_name").val(),
    email: $("#email").val(),
    password: $("#password").val(),
  };

  if (formData.password.length < 8) {
    // console.log("Password Must be Greater than 8 digits");
    $("#password").css("form-control.is-invalid");
  } else {
    $.ajax({
      url: "./queries/add_new_user.php",
      type: "GET",
      dataSrc: "",
    }).done(function (response) {
      console.log("Added Successfully");
    });
  }
});

$("#cancel_add").on("click", function (e) {
  e.preventDefault();
  $("#user_add_card").toggle();
  $("#main_content").show();
});
