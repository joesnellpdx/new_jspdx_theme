'use strict';
module.exports = function(grunt) {

    // load all grunt tasks
    require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        copy: {
            readme: {
                src: 'readme.txt',
                dest: 'README.md'
            },
            //grunticonCSStoSASS: {
            //    files: [
            //        {
            //            expand: true,
            //            cwd: 'assets/grunticon/output/',
            //            src: ['**/*.css'],
            //            dest: 'assets/scss/component/',
            //            rename: function(dest, src) {
            //                return dest + "_" + src.replace(/\.css$/, ".scss");
            //            }
            //        }
            //    ]
            //}
        },
        //curl: {
        //    'google-fonts-source': {
        //        src: 'https://www.googleapis.com/webfonts/v1/webfonts?key=*******',
        //        dest: 'assets/vendor/google-fonts-source.json'
        //    }
        //},
        //makepot: {
        //    target: {
        //        options: {
        //            include: [
        //
        //            ],
        //            type: 'wp-theme' // or `wp-theme`
        //        }
        //    }
        //},
        postcss: {
            options: {
                map: {
                    inline: false
                },

                processors: [
                    require('pixrem')(), // add fallbacks for rem units
                    require('autoprefixer')({browsers: 'last 2 versions'}),
                ]
            },
            dist: {
                src: '*.css',

            },
        },
        // javascript linting with jshint
        jshint: {
            options: {
                //jshintrc: '.jshintrc',
                "force": true,
                expr: true,
                globals: {
                    jQuery: true,
                    console: true,
                    module: true,
                    document: true
                }
            },
            all: [
                'Gruntfile.js',
                'assets/js/source/init.js',
                'assets/js/source/plugin-control.js',
                'assets/js/source/admin.js'
            ]
        },
        sass: {
            dist: {
                options: {
                    banner: '/*! <%= pkg.name %> <%= pkg.version %> filename.min.css <%= grunt.template.today("yyyy-mm-dd h:MM:ss TT") %> */\n',
                    style: 'compressed'
                },
                files: [{
                    expand: true,
                    cwd: 'assets/scss',
                    src: [
                        '*.scss'
                    ],
                    dest: 'assets/css',
                    ext: '.css'
                }]
            },
        },
        uglify: {
            admin: {
                options: {
                    banner: '/*! <%= pkg.name %> <%= pkg.version %> filename.min.js <%= grunt.template.today("yyyy-mm-dd h:MM:ss TT") %> */\n',
                    report: 'gzip'
                },
                files: {
                    'assets/js/admin.min.js' : [
                        'assets/js/source/admin.js'
                    ]
                }
            },
            plugins: {
                options: {
                    banner: '/*! <%= pkg.name %> <%= pkg.version %> filename.js <%= grunt.template.today("yyyy-mm-dd h:MM:ss TT") %> */\n',
                    beautify: true,
                    compress: false,
                    mangle: false
                },
                files: {
                    'assets/js/source/plugins.js' : [
                        // 'assets/js/vendor/matchmedia.js',
                        // 'assets/js/vendor/doubletaptogo.js',
                        // 'assets/js/vendor/picturefill.js',
                         'assets/js/vendor/js-cookie.js',
                        'assets/js/vendor/jquery.flexslider.js',
                        'assets/js/vendor/jquery.fitvids.js',
                        'assets/js/vendor/transformicons.js',
                        'assets/js/source/plugin-control.js'
                    ]
                }
            },
            main: {
                options: {
                    banner: '/*! <%= pkg.name %> <%= pkg.version %> filename.min.js <%= grunt.template.today("yyyy-mm-dd h:MM:ss TT") %> */\n',
                    report: 'gzip'
                },
                files: {
                    'assets/js/init.min.js': [
                        'assets/js/source/plugins.js',
                        'assets/js/source/init.js'
                    ]
                }
            }
        },
        svgmin: {
            options: {
                plugins: [
                    { removeViewBox: false },
                    { removeUselessStrokeAndFill: false }
                ]
            },
            prod: {
                files: [{
                    expand: true,
                    cwd: 'assets/grunticon/svgs',
                    src: ['*.svg'],
                    dest: 'assets/grunticon/source'
                }]
            }
        },
        grunticon: {
            myIcons: {
                files: [{
                    expand: true,
                    cwd: 'assets/grunticon/source',
                    src: ['*.svg', '*.png'],
                    dest: "assets/grunticon/output"
                }],
                options: {
                    // CSS filenames
                    datasvgcss: "icons.data.svg.css",
                    datapngcss: "icons.data.png.css",
                    urlpngcss: "icons.fallback.css",

                    // preview HTML filename
                    previewhtml: "preview.html",

                    // grunticon loader code snippet filename
                    loadersnippet: "grunticon.loader-file.js",

                    corsEmbed: false,
                    enhanceSVG: true,

                    // folder name (within dest) for png output
                    //pngfolder: "png",

                    //pngpath: "assets/grunticon/output/png",

                    pngpath: "png",

                    // prefix for CSS classnames
                    cssprefix: ".srbt-icon-",

                    //primarily for pngs
                    defaultWidth: "400px",
                    defaultHeight: "300px",

                    // define vars that can be used in filenames if desirable, like foo.colors-primary-secondary.svg
                    colors: {
                        primary: "red",
                        secondary: "#666"
                    },

                    dynamicColorOnly: true,

                    cssbasepath: "assets/grunticon/output/",
                    tmpPath: "assets/grunticon/svgs/",
                    tmpDir: "grunticon-tmp-files",

                    //customselectors: {
                    //    "*": [".icon-$1:before", ".icon-$1-what", ".hey-$1"]
                    //},

                    //compressPNG: true

                }
            }
        },

        // image optimization
        imagemin: {
            prod: {
                options: {
                    optimizationLevel: 7,
                    progressive: true
                },
                files: [{
                    expand: true,
                    cwd: 'assets/images/',
                    src: '**/*',
                    dest: 'assets/images/'
                }]
            }
        },
        clean: {
            prod: ['assets/grunticon/source/**/*', '!assets/grunticon/source/*.svn', '!assets/grunticon/source/**/*.svn', 'assets/grunticon/output/*', '!assets/grunticon/output/*.svn', '!assets/grunticon/output/**/*.svn', 'assets/grunticon/output/png/*.png', '!assets/grunticon/output/png', '!assets/grunticon/output/png/*.svn']
        },

        // watch for changes and trigger sass, jshint, uglify and livereload
        watch: {
            sass: {
                files: ['assets/scss/**/*.{scss,sass}'],
                tasks: ['sass', 'postcss']
            },
            js: {
                files: '<%= jshint.all %>',
                tasks: ['clean', 'svgmin', 'jshint', 'uglify',  'grunticon', 'copy']
            },
            livereload: {
                options: { livereload: true },
                files: ['style.css', 'assets/js/*.js', '*.html', '*.php', 'assets/images/**/*.{png,jpg,jpeg,gif,webp,svg}']
            },
            grunticon: {
                files: ['assets/grunticon/svgs/*.svg'],
                tasks: ['clean', 'svgmin', 'grunticon', 'copy']
            }
        }

    });


    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-curl');
    grunt.loadNpmTasks('grunt-wp-i18n');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-svgmin');
    grunt.loadNpmTasks('grunt-grunticon');


    // register task
    grunt.registerTask('default', [
        'watch',
        'clean',
        'makepot',
        'jshint',
        'uglify:prod',
        'sass:prod',
        'svgmin:prod',
        'grunticon:myIcons',
        'copy',
        'postcss:dist',
    ]);

    grunt.registerTask('googlefonts', [
        'curl:google-fonts-source'
    ]);
};