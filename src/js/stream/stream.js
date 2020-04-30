var stream_table = $("#stream_table").DataTable({
  ajax: {
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
          return `
          ${data} classes`;
        } else {
          return `${data} class`;
        }
      },
    },
    {
      targets: 3,

      data: "stream_id",
      render: function (data) {
        var string = `
            <a style = "color:red" onClick="del()"><i class="fas fa-trash"></i></a>

            <script type='text/javascript'>

            var toast = {
              question: function () {
                return new Promise(function (resolve) {
                  iziToast.question({
                    title: "Question",
                    message: "Are you Sure?",
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
        

            function del(){
              toast.question().then(function (){
               $.ajax({
                 url : './queries/delete_stream.php',
                 type : 'POST',
                 data : {
                   stream_id : ${data},
                 },
               }).done(function(response){
                 var r = JSON.parse(response);
                 if(r.success === true){
                  iziToast.success({
                    type : "Success",
                    message : r.message,
                  });
                 }else {
                  iziToast.error({
                    type : "Error",
                    message :r.message,
                  });
                 }
               }).fail(function(response){
                 iziToast.error({
                   type : "Error",
                   message : "Error Check Again",
                 });
               });
              });
            }

            
        </script>
        `;
        return string;
      },
    },
  ],
});
setInterval(function () {
  stream_table.ajax.reload(null, false);
}, 100000);

$("#add_stream").on("click", function (e) {
  e.preventDefault();
  $("#stream_add_card").show();
  $("#stream_main_content").toggle();
  stream_table.ajax.reload(null, false);
});
$("#stream_form").on("submit", function (e) {
  e.preventDefault();
  var formData = {
    stream_name: $("#stream_name").val(),
  };
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
});
$("#cancel_stream_form_add").on("click", function (e) {
  e.preventDefault();
  $("#stream_add_card").toggle();
  $("#stream_main_content").show();
});
