/**
 * This is the official js page for the stream class.
 */

$(document).ready(() => {
  const stream_form = $("#stream_form");
  const class_count = $("#all_classes");
  const page_heading = $("#page_heading");

  // Updation of the class heading.
  page_heading.html(
    `<span><i class="fas fa-book-reader"></i></span> Overview of all Classes.`
  );
  // This is the stream datatable.
  const stream_table = $("#stream_table").DataTable({
    ajax: {
      order: [[0, "desc"]],
      url: "./queries/get_all_streams.php",
      type: "GET",
      dataSrc: "",
    },
    columnDefs: [
      {
        targets: 0,
        data: {
          name: "name",
          stream_id: "stream_id",
        },
        render: function (data) {
          return `<a href="./page/view_stream?stream_id=${data.stream_id}">${data.name}</a>`;
        },
      },
      {
        targets: 1,
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
        targets: 2,
        data: "created_at",
      },
      {
        targets: 3,
        orderable: false,
        data: "stream_id",
        width: "10%",
        render: function (data) {
          return `
            <a style = "color:red" onClick="deleteStream(${data})"><i class="fas fa-trash"></i></a>
        `;
        },
      },
    ],
  });

  // Submit Class Form
  stream_form.submit((e) => {
    const formData = {
      stream_name: $("#stream_name").val(),
      desc: $("#desc").val(),
    };

    if (formData.stream_name.length <= 2) {
      iziToast.error({
        title: "Error",
        transitionIn: "bounceInLeft",
        position: "topRight",
        message: "Class Name Cannot Be Less Than Two Character",
      });
    } else {
      $.ajax({
        url: "./queries/add_stream.php",
        method: "POST",
        data: formData,
      }).done((response) => {
        const s = JSON.parse(response);
        if (s.success === true) {
          iziToast.success({
            title: "Success",
            progressBar: false,
            position: "topRight",
            transitionIn: "bounceInLeft",
            message: s.message,
            onClosing: function () {
              stream_table.ajax.reload(null, false);
              all_classes();
              $("#stream_form").each(function () {
                this.reset();
              });
            },
          });
        } else {
          iziToast.error({
            title: "Error",
            progressBar: false,
            position: "topRight",
            message: s.message,
            transitionIn: "bounceInLeft",
          });
        }
      });
    }

    e.preventDefault();
  });

  // Function to get all the classes in the system.
  const all_classes = () => {
    $.ajax({
      url: "../utils/get_all_streams.php",
      method: "GET",
    }).done(function (response) {
      const res = JSON.parse(response);
      res.forEach((i) => {
        class_count.append(`${i.streams}`);
      });
    });
  };
  all_classes();

  // Question Toast.
  const toast = {
    question: () => {
      return new Promise((resolve) => {
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
  const deleteStream = (stream_id) => {
    toast.question().then(() => {
      $.ajax({
        url: "./queries/delete_stream.php",
        type: "POST",
        data: {
          stream_id: stream_id,
        },
      })
        .done((response) => {
          const r = JSON.parse(response);
          if (r.success === true) {
            iziToast.success({
              type: "Success",
              message: r.message,
              position: "topRight",
              progressBar: false,
              transitionIn: "bounceInLeft",
              onClosing: () => {
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
  };

  // Refresh the stream table.
  setInterval(function () {
    stream_table.ajax.reload(null, false);
  }, 1000000);
});
