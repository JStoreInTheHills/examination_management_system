sessionStorage.clear();

const title = $("#title");

title.html(`Teachers || Munawwarah`);

const login_form = $("#login_form");

login_form.validate({
  rules: {
    email: {
      required: true,
      email: true,
    },
    password: "required",
  },

  messages: {
    email: {
      required: "Your email is required to login to the system.",
      email:
        "Your email address must be in the format of name@almunnawarah.ac.ke",
    },
    password: "Use the password assigned to you by the Examination officer.",
  },

  errorClass: "text-danger",

  invaidHandler: (event, validator) => {
    const errors = validator.numberOfInvalids();
    if (errors) {
      var message =
        errors == 1 ? `You missed 1 field` : `You missed ${errors} fields`;
      $("#toast").html(`<div class="alert alert-danger" role="alert">
            <h4 class="alert-heading"><span><i class="fas fa-exclamation-triangle"></i></span>
            ${message}
             </h4>
            <hr>
            <p class="mb-0">${message}</p>
          </div>`);
      $("#toast").show();
    } else {
      $("#toast").hide();
    }
  },

  submitHandler: (form) => {
    $.ajax({
      url: "/admin/login_attempt.php",
      type: "POST",
      data: $(form).serialize(),
      dataSrc: "",
    }).done((resp) => {
      const s = JSON.parse(resp);

      // check if the response is true and set defaults and data in the local storage.
      if (s.success === true) {
        const last_page = sessionStorage.getItem("last_page");

        // Setting the local storage with data.
        setLocalStorageData(s);

        // If response is success toastr greeen.
        responseIsSuccess(s);
        //Function to check if the logged in user is a teacher or administrator.
        checkIfTeacher(s, last_page);

        // If the response is false toastr to error.
      } else {
        responseIsError();
      }
    });
  },
});

function responseIsError() {
  $("#toast").empty().append(
    `<div class="alert alert-danger" role="alert">
              <h4 class="alert-heading"><span><i class="fas fa-exclamation-triangle"></i></span>
              User Not Found.
              </h4>
              <hr>
              <p class="mb-0">Contact the Examination Officer for assistance</p>
            </div>`
  );
}

function setLocalStorageData(s) {
  const role = sessionStorage.setItem("_token", s.role);
  const uuid = sessionStorage.setItem("uuid", s.uuid);
}

function responseIsSuccess(s) {
  $("#toast")
    .empty()
    .append(
      `<div class="alert alert-success" role="alert">${s.message}.</div>`
    );
}

function checkIfTeacher(s, last_page) {
  if (s.role === "Teacher") {
    $.ajax({
      url: "/admin/queries/get_login_teacher.php",
      type: "POST",
      data: {
        uuid: s.uuid,
      },
    }).done((response) => {
      const arr = JSON.parse(response);
      let id;
      if (arr.success === true) {
        id = arr.data;
        // const new_teachers_id = sessionStorage.setItem('teachers_token', id);
        document.location = `/teachers/pages/view_teacher?teachers_id=${id}`;
      } else {
        console.log(`${arr.success}`);
      }
    });
  } else if (last_page == null) {
    document.location = "/";
  } else {
    document.location = last_page;
  }
}
