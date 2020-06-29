var year_table = $("#year_table").DataTable({
  ajax: {
    url: "./queries/fetch_all_academic_years.php",
    dataSrc: "",
    type: "GET",
  },
  columnDefs: [
    {
      targets: 0,
      data: "year_name",
      render: function (data) {
        return `<a href="./page/view_academic_year.php?year_name=${data}">${data}</a>`;
      },
    },
    {
      targets: 1,
      data: "created_at",
    },
    {
      targets: 2,
      orderable: false,
      data: "year_id",
      render: function (data) {
        var string = `<a style = "color:red"  onClick="del(${data})"><i class="fas fa-trash"></i></a>`;
        return string;
      },
    },
  ],
});

var toast = {
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

function del(data) {
  toast.question().then(function () {
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
}

$("#year_form").on("submit", function (e) {
  e.preventDefault();

  let formData = {
    year_name: $("#year_name").val(),
  };

  if (formData.year_name.length < 4) {
    iziToast.error({
      position: "topRight",
      type: "Error",
      message: "Incorrect Year Name",
      transitionIn: "bounceInLeft",
    });
  } else {
    $.ajax({
      url: "./queries/add_academic_year.php",
      type: "POST",
      data: formData,
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
        });
      } else {
        iziToast.error({
          message: r.message,
          position: "topRight",
          type: "Error",
        });
      }
    });
  }
});

setInterval(function () {
  year_table.ajax.reload(null, false);
}, 100000);
