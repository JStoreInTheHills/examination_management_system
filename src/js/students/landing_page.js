sessionStorage.clear();

const title = $("#title");

title.html(`Students || Munawwarah`);

$("#login_form").validate({
  rules: {
    name: "required",
    rollid: "required",
  },

  invalidHandler: function (event, validator) {
    var errors = validator.numberOfInvalids();
    if (errors) {
      var message =
        errors == 1 ? "You missed 1 field" : `You missed ${errors} fields`;
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

  errorClass: "text-danger",

  submitHandler: function (form) {
    $.ajax({
      url: "./queries/login_attempt.php",
      type: "POST",
      data: $(form).serialize(),
    }).done((resp) => {
      const s = JSON.parse(resp);
      if (s.success === true) {
        setConstantsAndAlerts(s);

        document.location = `./pages/details`;
      } else {
        $("#toast").empty().append(
          `<div class="alert alert-danger" role="alert">
                <h4 class="alert-heading"><span><i class="fas fa-exclamation-triangle"></i></span>
                  Access to the Portal has been restrained
                 </h4>
                <hr>
                <p class="mb-0">${s.message}</p>
              </div>`
        );
      }
    });
  },
});
const setConstantsAndAlerts = (s) => {
  $("#toast").empty().append(`<div class="alert alert-success" role="alert"> 
                  <h4 class="alert-heading">
                    ${s.message}
                  </h4>
            </div>`);

  sessionStorage.setItem("students_id", s.uuid);
  sessionStorage.setItem("class_id", s.class_id);
};
