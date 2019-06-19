var gulp = require('gulp');
var useref = require('gulp-useref');
var uglify = require('gulp-uglify');
var gulpIf = require('gulp-if');
var pleeease = require('gulp-pleeease');
var del = require('del');
var runSequence = require('run-sequence');
var gutil = require( 'gulp-util' );
var ftp = require( 'vinyl-ftp' );

var PleeeaseOptions = {
    "autoprefixer": {"browsers": ["last 4 versions", "ios 6"]},
    "rem": true,
    "minifier": true
};

gulp.task('clean:dist', function() {
    return del.sync('dist');
});

gulp.task('images', function(){
    return gulp.src('_site/img/**/*.+(png|jpg|gif|svg|GIF|JPG|PNG)')
    .pipe(gulp.dest('dist/img'))
});

gulp.task('useref', function(){
    return gulp.src('_site/*.htm')
    .pipe(useref())
    .pipe(gulpIf('*.js', uglify()))
    .pipe(gulpIf('*.css', pleeease(PleeeaseOptions)))
    .pipe(gulp.dest('dist'))
});

gulp.task('fonts', function(){
    return gulp.src('_site/font/**/*')
    .pipe(gulp.dest('dist/font'))
});

gulp.task('php', function(){
    return gulp.src('_site/*.php')
    .pipe(gulp.dest('dist'))
});

gulp.task('build', function (callback) {
    runSequence('clean:dist', 
        ['useref', 'images', 'fonts', 'php'],
        callback
    )
});

gulp.task( 'deploy', function () {

	var conn = ftp.create( {
		host:     '',
		user:     '',
		password: '',
		parallel: 10,
		log:      gutil.log
	} );

	var globs = [
		// 'dist'
	];

	// using base = '.' will transfer everything to /public_html correctly
	// turn off buffering in gulp.src for best performance

	return gulp.src( 'test/**', { base: 'test', buffer: false } )
		.pipe( conn.newer( '/christos/public' ) ) // only upload newer files
		.pipe( conn.dest( '/christos/public' ) );

} );