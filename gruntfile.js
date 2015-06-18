module.exports = function(grunt){


    // Configure Tasks
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

            wordpressdeploy: {
                options: {
                    backup_dir: "backups/",
                    rsync_args: ['--verbose', '--progress', '-rlpt', '--compress', '--omit-dir-times', '--delete'],
                    exclusions: ['Gruntfile.js', '.git/', 'tmp/*', 'backups/','wp-config.php', 'composer.json', 'composer.lock', 'README.md', '.gitignore', 'package.json', 'node_modules']
                },
                local: {
                    "title": "local",
                    "database": "add db",
                    "user": "root",
                    "pass": "root",
                    "host": "localhost",
                    "url": "http://localhost:8888",
                    "path": "path/to/directory"
                },
                staging: {
                    "title": "staging",
                    "database": "staging db name",
                    "user": "staging db user",
                    "pass": "staging db password",
                    "host": "ip.add.ress.",
                    "url": "staging url",
                    "path": "absolute path to directory on server",
                    "ssh_host": "cpanelusername@ip.add.ress"
                },
                prod: {
                    "title": "prod",
                    "database": "prod db name",
                    "user": "prod db user",
                    "pass": "proddb password",
                    "host": "ip.add.ress.",
                    "url": "staging url",
                    "path": "absolute path to directory on server",
                    "ssh_host": "cpanelusername@ip.add.ress"
                }

        },
        uglify : {
            build :{
                src :'src/js/**/*.js', //where the working js file lives (* is a wildcard)
                dest: 'js/scripts.min.js' // where the final minified concatenated file lives (output file)

            },
            dev: {
                options: {
                    beautify: true,
                    mangle: false,
                    compress: false,
                    preserveComments: 'all'
                },
                files: {
                    'js/scripts.min.js': ['src/js/vendor/modernizr.custom.js', 'src/js/vendor/jquery.dlmenu.js', 'src/js/**/*.js']
                }
            }
        },
        sass: {                  // Task
            dev: {
                options: {
                   lineNumbers:true,
                   sourceComments: 'true',
                    sourceMap: 'style.css.map',
                   outputStyle:'expanded'
                },
                files: {
                    'style.css' : 'src/sass/style.scss'
                }
            },
            build: {
                options: {
                    outputStyle:'compressed'
                },
                files: {
                    'style.css' : 'src/sass/style.scss'
                }
            }
        },

        watch: {

          js: {
              files: ['src/js/**/*.js'],
              tasks: ['uglify:dev'],
              options : {
                  livereload : 35729
              }
          },
          css : {
              files:['src/sass/**/*.scss'],
              tasks: ['sass:dev'],
              options : {
                  livereload : 35729
              }
          },
          php: {
              files: ['**/*.php'],
              options: {
                  livereload: 35729
              }
          }

        }
    });


    // Load the Plugins
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-wordpress-deploy');
    grunt.loadNpmTasks('grunt-mysql-dump');

    // Register Tasks
    grunt.registerTask('default', ['uglify:dev', 'sass:dev']);
    grunt.registerTask('build', ['uglify:build', 'sass:build']);

    grunt.registerTask('deployfiles',
        function(target){
            grunt.option('target',target);
            if(target!==''){
                grunt.task.run('push_files:'+target);
            }
            else{
                grunt.log.error('Please provide a target for deployment! It is dangerous to deploy with closed eyes.');
            }
        });

    grunt.registerTask('deploydb',
        function(target){
            grunt.option('target',target);
            if(target!==''){
                grunt.task.run('push_db:'+target);
            }
            else{
                grunt.log.error('Please provide a target for deployment! It is dangerous to deploy with closed eyes.');
            }
        });

};