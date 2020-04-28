var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);

var year_name = urlParams.get('year_name');

var class_end_year_table = $('#class_end_year_table');

$('#heading').append(year_name);

class_end_year_table.DataTable({
    ajax : {
        url : './../queries/fetch_class_end_year_result.php',
        dataSrc : "",
        type : "GET",
        data : {
            year_name : year_name,
        },
    },
    columnDefs : [
        {
            targets : 0,
            data : "ClassName",
            render : function(data){
                return `<a href="./view_class_academic_year_performance.php?class_name=${data}&academic_year=${year_name}">${data}</a>`;
            }
        },
        {
            targets : 1,
            data : "ClassNameNumeric",
        },
        {
            targets : 2,
            data : "name",
        },
        {
            targets : 3, 
            data : "id",
            render : function(data){
                return `${data}`;
            }
        }

    ]
});

setInterval(function(){
    class_end_year_table.ajax.reload(null, false);
}, 100000)
