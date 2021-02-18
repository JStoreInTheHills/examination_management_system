// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Nunito"),
  '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#000000";

var myLocation = window.location;

var ActiveSessionPage = window.sessionStorage;

ActiveSessionPage.setItem("last_page", myLocation);

var url = myLocation;

$('ul.navigation a[href="' + url + '"]')
  .parent()
  .addClass("active");

$("ul.navigation a")
  .filter(function () {
    return this.href == url;
  })
  .parent()
  .addClass("active");

// ajax call to trigger the nprogress to fire.
$(document).ajaxStart(() => {
  NProgress.start();
});

$(document).ajaxComplete(() => {
  NProgress.done();
});

$("#index_heading").val(sessionStorage.getItem("school_name"));

function goBack() {
  window.history.go(-1);
  return false;
}
// Function to toogle the sidebar
const toggle = () => {
  $("body").toggleClass("sidebar-toggled");
  $(".sidebar").toggleClass("toggled");
  if ($(".sidebar").hasClass("toggled")) {
    $(".sidebar .collapse").collapse("hide");
  }
};
toggle();
