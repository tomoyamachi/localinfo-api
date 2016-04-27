var gulp = require('gulp');
var aglio = require('gulp-aglio');
var ApiMock = require('api-mock');

gulp.task('api-blueprint', function () {
    gulp.src('data/api-blueprint/v1/*.md')
        .pipe(aglio({ template: 'default' }))
        .pipe(gulp.dest('var/docs/api/v1'));
});

gulp.task('api-mock', function () {
    var server = new ApiMock ( {
        blueprintPath: 'data/api-blueprint/v1/index.md',
        options: {
            port: 5557
        }
    });
    server.run();
});
