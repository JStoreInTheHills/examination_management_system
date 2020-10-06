$(document).ready(() => {
  // The default js page for the users of the system.

  // Pointer to the firstname input field.
  const firstname = $("#firstname");
  const username = $("#username");
  const lastname = $("#lastname");
  const email = $("#email");
  const password = $("#password");
  const userform = $("#user_form");
  const repeatPassword = $("#repeatPassword");

  // Variable holding the check box value.
  const roleFlag = $("#role_select");

  // Varible holding the user datatables.
  const user_table = $("#users_table").DataTable({
    ajax: {
      url: "../queries/get_all_users.php",
      type: "get",
      dataSrc: "",
    },
    columnDefs: [
      {
        targets: 0,
        data: {
          firstname: "firstname",
          lastname: "lastname",
        },
        render: function (data) {
          return `<a>${data.firstname} ${data.lastname}</a>`;
        },
      },
      {
        targets: 1,
        data: "email",
      },
      {
        targets: 2,
        data: "created_at",
      },
      {
        targets: 3,
        data: "role_name",
      },
      {
        targets: 4,
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
        targets: 5,
        data: {
          id: "id",
          status: "status",
        },
        orderable: false,
        render: function (data) {
          return `
        <a onClick="makeActive(${data.id}, ${data.status})"> <i class="fas fa-edit"></i></a>

        <a style="color:red"> <i class="fas fa-trash"></i> </a>
        `;
        },
      },
    ],
  });

  // Variable of Object type holding the toasts.
  const toast = {
    question: function () {
      return new Promise(function (resolve) {
        iziToast.question({
          title: "Warning",
          message: "Are you sure you want to change this user status?",
          timeout: 20000,
          close: false,
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

  const makeActive = (user_id, status) => {
    toast.question().then(() => {
      $.ajax({
        url: "../queries/make_user_active.php",
        type: "get",
        data: {
          user_id: user_id,
          status: status,
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
  };

  const populateRoles = () => {
    $.ajax({
      url: "/roles/queries/get_all_roles.php",
      dataSrc: "",
      type: "GET",
    })
      .done((response) => {
        const result = JSON.parse(response);
        result.forEach((item) => {
          roleFlag.append(
            `<option value="${item.role_id}">${item.role_name}</option>`
          );
        });
      })
      .fail((er) => {
        console.log(er);
      });
  };

  populateRoles();

  userform.submit((e) => {
    const formData = {
      firstname: firstname.val(),
      username: username.val(),
      lastname: lastname.val(),
      email: email.val(),
      password: password.val(),
      repeatPassword: repeatPassword.val(),
      role_id: roleFlag.val(),
    };

    console.log(formData);

    if (typeof formData !== "object") {
      console.log("Using form data that is not of supported format");
    } else if (formData.password.length < 8) {
      iziToast.error({
        type: "Error",
        message: "Password should be greater than eight characters",
        position: "center",
      });
    } else if (formData.password !== formData.repeatPassword) {
      iziToast.error({
        type: "Error",
        message: "Password dont match",
        position: "center",
      });
    } else {
      $.ajax({
        url: "../queries/add_user.php",
        type: "POST",
        dataSrc: "",
        data: formData,
      }).done((response) => {
        const arr = JSON.parse(response);
        if (arr.success == true) {
          iziToast.success({
            type: "Success",
            message: arr.message,
            position: "topRight",
            transitionIn: "bounceInRight",
            onClosed: () => {
              $("#user_form").each(function () {
                this.reset();
              });
            },
          });
        } else {
          iziToast.error({
            type: "Error",
            message: arr.message,
            position: "topRight",
            transitionIn: "bounceInRight",
          });
        }
      });
    }

    // if (formData.password.length < 8) {
    //   // console.log("Password Must be Greater than 8 digits");
    //   $("#password").css("form-control.is-invalid");
    // } else {
    //   $.ajax({
    //     url: "../queries/add_user.php",
    //     type: "POST",
    //     dataSrc: "",
    //   }).done(function (response) {
    //     console.log("Added Successfully");
    //   });
    // }
    e.preventDefault();
  });

  setInterval(() => {
    populateRoles();
    user_table.ajax.reset;
  }, 10000000);
});
