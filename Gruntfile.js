module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		stylus: {
			compile: {
				src: [ 'web/css/style.styl' ],
				dest: 'web/css/style.css',
				options: {
					'include css': true
				}
			}
		},

		cssmin: {
			css: {
				src: 'web/css/style.css',
				dest: 'web/css/style.css'
			}
		},

		watch: {
			stylus: {
				files: [ 'web/css/*.styl' ],
				tasks: [ 'stylus' ]
			},

			cssmin: {
				files: [ 'web/css/style.css' ],
				tasks: [ 'cssmin' ]
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-stylus');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('default', [ 'stylus', 'cssmin', 'watch' ]);
};
