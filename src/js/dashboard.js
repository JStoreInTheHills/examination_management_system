function greet() {
  iziToast.success({
    type: "Success",
    position: "topRight",
    transitionIn: "BounceInRight",
    message: "Welcome to Al Madrasatul Munnawarah al Islamiyyah.",
  });
}

// greet();
function get_students() {
  $.ajax({
    url: "dashboard/queries/get_students.php",
    type: "GET",
  }).done(function (response) {
    var j = JSON.parse(response);

    $("#all_students").empty().append(j[0].students);
  });
}
get_students();

function get_all_teachers() {
  $.ajax({
    url: "dashboard/queries/get_teachers.php",
    type: "GET",
  }).done(function (response) {
    let t = JSON.parse(response);
    $("#all_teachers").empty().append(t[0].teachers_id);
  });
}

get_all_teachers();

function get_all_class() {
  $.ajax({
    url: "dashboard/queries/get_classes.php",
    type: "GET",
  }).done(function (response) {
    let j = JSON.parse(response);
    $("#all_classes").empty().append(j[0].classes);
  });
}
get_all_class();

setInterval(() => {
  get_students();
  get_all_class();
  get_all_teachers();
}, 1000000);
