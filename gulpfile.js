"use strict";

// Load plugins
const autoprefixer = require("gulp-autoprefixer");
const browsersync = require("browser-sync").create();
const cleanCSS = require("gulp-clean-css");
const del = require("del");
const gulp = require("gulp");
const babel = require("gulp-babel");
const header = require("gulp-header");
const merge = require("merge-stream");
const plumber = require("gulp-plumber");
const rename = require("gulp-rename");
const sass = require("gulp-sass");
const uglify = require("gulp-uglify");
const concat = require("gulp-concat");
var concatCss = require("gulp-concat-css");

// Load package.json for banner
const pkg = require("./package.json");
const gulpConcatCss = require("gulp-concat-css");

// Set the banner content
const banner = [
  "/*!\n",
  " * Start Bootstrap - <%= pkg.title %> v<%= pkg.version %> (<%= pkg.homepage %>)\n",
  " * Copyright 2013-" + new Date().getFullYear(),
  " <%= pkg.author %>\n",
  " * Licensed under <%= pkg.license %> (https://github.com/BlackrockDigital/<%= pkg.name %>/blob/master/LICENSE)\n",
  " */\n",
  "\n",
].join("");

// // BrowserSync
// function browserSync(done) {
//   browsersync.init({
//     server: {
//       baseDir: "./"
//     },
//     port: 3000
//   });
//   done();
// }

// // BrowserSync reload
// function browserSyncReload(done) {
//   browsersync.reload();
//   done();
// }

// Clean vendor
function clean() {
  return del(["./vendor/"]);
}

// Bring third party dependencies from node_modules into vendor directory
function modules() {
  // Bootstrap JS
  var bootstrapJS = gulp
    .src("./node_modules/bootstrap/dist/js/*")
    .pipe(gulp.dest("./vendor/bootstrap/js"));
  // Bootstrap SCSS
  var bootstrapSCSS = gulp
    .src("./node_modules/bootstrap/scss/**/*")
    .pipe(gulp.dest("./vendor/bootstrap/scss"));
  // ChartJS
  var chartJS = gulp
    .src("./node_modules/chart.js/dist/*.js")
    .pipe(gulp.dest("./vendor/chart.js"));

  var izitoast = gulp
    .src([
      "./node_modules/izitoast/dist/js/*",
      "./node_modules/izitoast/dist/css/*",
    ])
    .pipe(gulp.dest("./vendor/izitoast/"));

  // dataTables
  var dataTables = gulp
    .src([
      "./node_modules/datatables.net/js/*.js",
      "./node_modules/datatables.net-bs4/js/*.js",
      "./node_modules/datatables.net-bs4/css/*.css",
    ])
    .pipe(gulp.dest("./vendor/datatables"));

  // Font Awesome
  var fontAwesome = gulp
    .src("./node_modules/@fortawesome/**/*")
    .pipe(gulp.dest("./vendor"));

  var progressbar = gulp
    .src("./node_modules/progressbar.js/dist/*.js")
    .pipe(gulp.dest("./vendor/progressbar"));

  var nprogress = gulp
    .src("./node_modules/nprogress/**")
    .pipe(gulp.dest("./vendor/nprogress"));

  // select2
  var select2js = gulp
    .src("./node_modules/select2/**/*")
    .pipe(gulp.dest("./vendor/select2"));

  // Select2 bootstrap4

  var select2 = gulp
    .src("./node_modules/@ttskch/**/*")
    .pipe(gulp.dest("./vendor"));

  // jQuery Easing
  var jqueryEasing = gulp
    .src("./node_modules/jquery.easing/*.js")
    .pipe(gulp.dest("./vendor/jquery-easing"));

  var datePicker = gulp
    .src("./node_modules/@chenfengyuan/datepicker/dist/*")
    .pipe(gulp.dest("./vendor/datepicker"));
  // jQuery
  var jquery = gulp
    .src([
      "./node_modules/jquery/dist/*",
      "!./node_modules/jquery/dist/core.js",
    ])
    .pipe(gulp.dest("./vendor/jquery"));

  var jquery_validation = gulp
    .src("./node_modules/jquery-validation/dist/*.js")
    .pipe(gulp.dest("./vendor/jquery-validation"));

  return merge(
    bootstrapJS,
    bootstrapSCSS,
    chartJS,
    dataTables,
    fontAwesome,
    jquery,
    jqueryEasing,
    izitoast,
    datePicker,
    select2,
    select2js,
    progressbar,
    nprogress,
    jquery_validation
  );
}

function customJs() {
  var dashboard = gulp
    .src("./src/js/dashboard.js")
    .pipe(gulp.dest("./dist/js/dashboard"));

  var utils = gulp.src("./src/js/utils.js").pipe(gulp.dest("./dist/js/utils"));

  var terms = gulp.src("./src/js/terms/*").pipe(gulp.dest("./dist/js/terms"));

  var classes = gulp
    .src("./src/js/class/*")
    .pipe(gulp.dest("./dist/js/classes"));

  var exam = gulp.src("./src/js/exam/*").pipe(gulp.dest("./dist/js/exams"));

  var webfonts = gulp
    .src("./vendor/fontawesome-free/webfonts/*")
    .pipe(gulp.dest("./dist/webfonts"));

  var result = gulp
    .src("./src/js/result/*")
    .pipe(gulp.dest("./dist/js/results"));
  var stream = gulp
    .src("./src/js/stream/*")
    .pipe(gulp.dest("./dist/js/streams"));
  var student = gulp
    .src("./src/js/students/*")
    .pipe(gulp.dest("./dist/js/students"));
  var year = gulp.src("./src/js/year/*").pipe(gulp.dest("./dist/js/years"));

  var subjects = gulp
    .src("./src/js/subjects/*")
    .pipe(gulp.dest("./dist/js/subjects"));

  var teacher = gulp
    .src("./src/js/teachers/*")
    .pipe(gulp.dest("./dist/js/teachers"));

  var admin = gulp.src("./src/js/admin/*").pipe(gulp.dest("./dist/js/admin"));

  return merge(
    result,
    classes,
    exam,
    stream,
    student,
    subjects,
    year,
    teacher,
    dashboard,
    admin,
    utils,
    terms,
    webfonts
  );
}

// CSS task
function scss() {
  return gulp
    .src("./scss/**/*.scss")
    .pipe(plumber())
    .pipe(
      sass({
        outputStyle: "expanded",
        includePaths: "./node_modules",
      })
    )
    .on("error", sass.logError)
    .pipe(
      autoprefixer({
        cascade: false,
      })
    )
    .pipe(
      header(banner, {
        pkg: pkg,
      })
    )
    .pipe(cleanCSS())
    .pipe(gulp.dest("dist/css"));
  // .pipe(browsersync.stream());
}

// JS task
function js() {
  return gulp
    .src([
      "./vendor/jquery/jquery.min.js",
      "./vendor/bootstrap/js/bootstrap.bundle.min.js",
      "./vendor/jquery-easing/jquery.easing.min.js",
      "./src/js/sb-admin-2.min.js",
      "./vendor/izitoast/iziToast.min.js",
      "./vendor/datepicker/datepicker.min.js",
      "./vendor/datatables/jquery.dataTables.min.js",
      "./vendor/datatables/dataTables.bootstrap4.min.js",
      "./vendor/chart.js/Chart.min.js",
      "./vendor/select2/dist/js/select2.min.js",
      "./vendor/progressbar/progressbar.min.js",
      "./vendor/nprogress/nprogress.js",
      "./vendor/jquery-validation/jquery.validate.min.js",
    ])
    .pipe(concat("main.js"))
    .pipe(uglify())
    .pipe(
      header(banner, {
        pkg: pkg,
      })
    )
    .pipe(
      rename({
        suffix: ".min",
      })
    )
    .pipe(gulp.dest("dist/js"));
  // .pipe(browsersync.stream());
}

// CSS task
function css() {
  return gulp
    .src([
      "./vendor/fontawesome-free/css/all.min.css",
      "./vendor/izitoast/iziToast.min.css",
      "./vendor/datepicker/datepicker.min.css",
      "./vendor/datatables/dataTables.bootstrap4.min.css",
      "./vendor/select2-bootstrap4-theme/dist/*.css",
      "./vendor/select2/dist/css/select2.css",
      "./src/css/*.css",
      "./vendor/nprogress/nprogress.css",
    ])
    .pipe(cleanCSS())
    .pipe(concatCss("main.css"))
    .pipe(
      header(banner, {
        pkg: pkg,
      })
    )
    .pipe(
      rename({
        suffix: ".min",
      })
    )
    .pipe(gulp.dest("dist/css"));
  // .pipe(browsersync.stream());
}

// Watch files
function watchFiles() {
  gulp.watch(["./scss/**/*", "./src/css/*"], css);
  gulp.watch(["./js/**/*", "!./js/**/*.min.js"], js);
  gulp.watch(["./src/js/**/*"], customJs);
  // gulp.watch("./**/*.html", browserSyncReload);
}

// Define complex tasks
const vendor = gulp.series(clean, modules);
const build = gulp.series(vendor, gulp.parallel(css, js, customJs));
const watch = gulp.series(build, gulp.parallel(watchFiles));

// Export tasks
exports.scss = scss;
exports.css = css;
exports.js = js;
exports.customJs = customJs;
exports.clean = clean;
exports.vendor = vendor;
exports.build = build;
exports.watch = watch;
exports.default = build;
