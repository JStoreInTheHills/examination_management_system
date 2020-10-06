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
