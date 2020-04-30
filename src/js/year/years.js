$(function () {
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
        data: "year_id",
        render: function (data) {
          var string = `
                    <a style = "color:red"  onClick="del()"><i class="fas fa-trash"></i></a>
        
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
                         url : './queries/delete_academic_year.php',
                         type : 'POST',
                         data : {
                           year_id : ${data},
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
    year_table.ajax.reload(null, false);
  }, 100000);

  $("#year_form").on("submit", function (e) {
    e.preventDefault();
    var formData = {
      year_name: $("#year_name").val(),
    };
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
          onClosing: function () {
            year_table.ajax.reload(null, false);
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
  });
});
