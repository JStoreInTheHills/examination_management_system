var stream_table = $("#stream_table").DataTable({
  ajax: {
    order: [[0, "desc"]],
    url: "./queries/get_all_streams.php",
    type: "GET",
    dataSrc: "",
  },
  columnDefs: [
    {
      targets: 0,
      data: "name",
      render: function (data) {
        return `<a href="./page/view_stream.php?stream_name=${data}">${data}</a>`;
      },
    },
    {
      targets: 1,
      data: "created_at",
    },
    {
      targets: 2,
      data: "number_of_classes",
      render: function (data) {
        if (data > 1) {
          return `${data} streams`;
        } else {
          return `${data} stream`;
        }
      },
    },
    {
      targets: 3,
      orderable: false,
      data: "stream_id",
      render: function (data) {
        return `
            <a style = "color:red" onClick="deleteStream(${data})"><i class="fas fa-trash"></i></a>
        `;
      },
    },
  ],
});

// Submit Class Form
$("#stream_form").on("submit", function (e) {
  e.preventDefault();

  let formData = {
    stream_name: $("#stream_name").val(),
    desc: $("#desc").val(),
  };

  if (formData.stream_name.length <= 2) {
    iziToast.error({
      title: "Error",
      transitionIn: "fadeInUp",
      position: "topRight",
      message: "Class Name Cannot Be Less Than One Character",
    });
  } else {
    $.ajax({
      url: "./queries/add_stream.php",
      method: "POST",
      data: formData,
    }).done(function (response) {
      var s = JSON.parse(response);
      if (s.success === true) {
        iziToast.success({
          title: "Success",
          position: "topRight",
          message: s.message,
          onClosing: function () {
            stream_table.ajax.reload(null, false);
            $("#stream_form").each(function () {
              this.reset();
            });
          },
        });
      } else {
        iziToast.error({
          title: "Error",
          position: "topRight",
          message: s.message,
        });
      }
    });
  }
});

// Function to get all the classes in the system.
function all_classes() {
  $.ajax({
    url: "../utils/get_all_streams.php",
    method: "GET",
  }).done(function (response) {
    let res = JSON.parse(response);
    $("#all_classes").append(`${res[0].streams}`);
  });
}
all_classes();

// Question Toast.
var toast = {
  question: function () {
    return new Promise(function (resolve) {
      iziToast.question({
        title: "Warning! ",
        message: "Are you Sure you want to delete?",
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

// Function to delete a stream.
function deleteStream(stream_id) {
  toast.question().then(function () {
    $.ajax({
      url: "./queries/delete_stream.php",
      type: "POST",
      data: {
        stream_id: stream_id,
      },
    })
      .done(function (response) {
        var r = JSON.parse(response);
        if (r.success === true) {
          iziToast.success({
            type: "Success",
            message: r.message,
            onClosing: function () {
              stream_table.ajax.reload(null, false);
            },
          });
        } else {
          iziToast.error({
            type: "Error",
            message: r.message,
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

// Refresh the stream table.
setInterval(function () {
  stream_table.ajax.reload(null, false);
}, 100000);
