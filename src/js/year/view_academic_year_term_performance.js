const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const year_id = urlParams.get("year_id");
const term_id = urlParams.get("term_id");

const init = () => {
  $.ajax({
    url: "../queries/get_academic_year_term_performance.php",
    data: {
      year_id: year_id,
      term_id: term_id,
    },
    type: "GET",
  }).done((resp) => {
    const arr = JSON.parse(resp);
    arr.forEach((item) => {
      heading.html(`${item.year_name} - ${item.name}`);
      year_title.html(`${item.year_name} - ${item.name}`);
      bread_list_year.html(`${item.year_name}`);
      a.href = `view_academic_year?year_id=${year_id}`;
      bread_list_term.html(item.name);
    });
  });
};

init();

const term_year_table = $("#term_year_table").DataTable({
  ajax: {
    url: "../queries/get_classes.php",
    type: "GET",
    dataSrc: "",
  },
  columnDefs: [
    {
      targets: 0,
      data: "ClassName",
    },
    {
      targets: 1,
      data: "ClassNameNumeric",
    },
    {
      targets: 2,
      data: "id",
      render: (data) => {
        return `<a href="${data}"><span><i class="fas fa-print"></i></span></a>`;
      },
    },
  ],
});

setInterval(() => {
  term_year_table.ajax.reload(null, false);
}, 1000000);

const heading = $("#heading");
const a = document.getElementById("bread_list_year");
const year_title = $("#year_title");
const bread_list_year = $("#bread_list_year");
const bread_list_term = $("#bread_list_term");
