const login_form = $("#login_form");
const idInput = $("#exampleInputId");
const passInput = $("#exampleInputPassword");

login_form.submit((event) => {
  const id = idInput.val();
  const password = passInput.val();

  if (id === "" && password === "") {
    idInput.addClass("border border-danger");
    passInput.addClass("border border-danger");
    $("#email_label").addClass("text-danger");
    $("#pass_label").addClass("text-danger");
  } else {
    const formData = {
      id: id,
      password: password,
    };

    $.ajax({
      url: "./queries/login_attempt.php",
      type: "GET",
      data: formData,
    }).done((response) => {
      const s = JSON.parse(response);

      if (s.success === true) {
        const last_page = sessionStorage.getItem("last_page");
        const role = sessionStorage.setItem("_token", s.role);

        $("#toast").html(`<div class="alert alert-success" role="alert">
                        Redirecting.. Please Wait.</div>`);

        if (s.role === "Teacher") {
          document.location = "./teacher_module/teachers_module.php";
        } else if (last_page == null) {
          document.location = "./index";
        } else {
          document.location = last_page;
        }
      } else {
        $("#toast").addClass("ff");
        $("#toast").html(
          `<div class="alert alert-danger" role="alert"> 
          <h3 class="alert-heading"><span><i class="fas fa-exclamation-triangle"></i></span>  WARNING!</h3>
          <p>User Not Found.</p>
          <hr>
          <p class="mb-0">Kindly contact Examination Administrator.</p></div>
          `
        );
      }
    });
  }
  event.preventDefault();
});
