$(function(){
    var year_table = $('#year_table').DataTable({
        ajax : {
            url : './queries/fetch_all_academic_years.php',
            dataSrc : '',
            type : 'GET',
        },
        columnDefs : [
            {
                targets : 0,
                data : 'year_name',
                render : function(data){
                    return `<a href="./page/view_academic_year.php?year_name=${data}">${data}</a>`;
                }
            },
            {
                targets : 1,
                data : 'created_at',
            },
            {
                targets : 2,
                data : 'year_id',
                render : function(data){
                    return `${data}`;
                }
            }
        ]
    });

    setInterval(function(){
        year_table.ajax.reload(null, false);
    }, 100000);
    
    $('#year_form').on('submit', function(e){
        e.preventDefault();
        var formData = {
            year_name : $('#year_name').val(),
        }
        $.ajax({
            url : './queries/add_academic_year.php',
            type : 'POST',
            data : formData,
        }).done(function(response){
            var r = JSON.parse(response);
            if(r.success === true){
                iziToast.success({
                    message : r.message,
                    position : "topRight",
                    type : "Success",
                    onClosing : function(){
                        year_table.ajax.reload(null, false)
                    }
                }); 
            }else{
                iziToast.error({
                    message : r.message,
                    position : "topRight",
                    type : "Error",
                })
            }
        });
    });

    

})