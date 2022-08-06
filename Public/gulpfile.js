var gulp = require('gulp');
var slim = require("gulp-slim");
var rename = require("gulp-rename");
var sass = require('gulp-sass');

gulp.task('default', ['slim', 'move_images', 'move_icons', 'move_bower', 'compile_scss', 'move_js', 'move_other_files', 'watch']);
 
gulp.task('slim', function(){

  gulp.src("/Public/source/**/[^_]*.slim")
    .pipe(slim({ chdir: true, pretty: true, include: true }))
    .pipe(rename(function (file) {
      if((file.basename === 'index') && (file.dirname === 'layouts')){
        file.basename = 'index';
      }else{
        file.basename = file.dirname + '_' + file.basename;
      }
      file.dirname = '.';
    }))
    .pipe(gulp.dest("/Public/dist/"));
});



gulp.task('move_icons', function(){
  gulp.src("/Public/source/icon_fonts_assets/**/*")
    .pipe(gulp.dest("/Public/dist/icon_fonts_assets/"));
});


gulp.task('move_images', function(){
  gulp.src("/Public/source/img/**/*")
    .pipe(gulp.dest("/Public/dist/img/"));
});

gulp.task('move_js', function(){
  gulp.src("/Public/source/js/**/*")
    .pipe(gulp.dest("/Public/dist/js/"));
});


gulp.task('move_bower', function(){
  gulp.src("/Public/source/bower_components/**/*")
    .pipe(gulp.dest("/Public/dist/bower_components/"));
});


gulp.task('compile_scss', function(){
  gulp.src("/Public/source/scss/**/main.scss")
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest("/Public/dist/css/"));
});

gulp.task('watch', function () {
  //gulp.watch('/Public/source/scss/**/*.scss', ['compile_scss']);
});



gulp.task('move_other_files', function(){
  gulp.src(["/Public/source/*.html", "/Public/source/*.png"])
    .pipe(gulp.dest("/Public/dist/"));
});