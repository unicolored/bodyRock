// matching one level down:
// 'test/spec/{,*/}*.js'
// recursively match all subfolders:
// 'test/spec/**/*.js'
module.exports = function( grunt ) {
    'use strict';
    // Module qui affiche le temps d'éxécution de chaque tâche.
    // Utile pour détecter des anomalies et vérifier la performance des tâches.
    require( 'time-grunt' )( grunt );
    // Config
    grunt.initConfig( {
        //////////// Package settings /* VARIABLES DU PROJET */
        developper: grunt.file.readJSON( 'cfg_developper.json' ),
        wp: grunt.file.readJSON( 'cfg_wordpress.json' ),
        paths: grunt.file.readJSON( 'cfg_paths.json' ),
        pkg: grunt.file.readJSON( 'package.json' ),
        /*
        ########   ## ##       ######   ######   ######
        ##         ## ##      ##    ## ##    ## ##    ##
        ##       #########    ##       ##       ##
        ######     ## ##      ##        ######   ######
        ##       #########    ##             ##       ##
        ##         ## ##      ##    ## ##    ## ##    ##
        ########   ## ##       ######   ######   ######
        */
        /****************************/
        // GENERATION DU CSS
        less: {
            options: {
                compress: false,
                yuicompress: false,
            },
            // COMPILATION des deux fichiers .less principaux : bootstrap et style
            wordpress: {
                files: {
                    '<%= paths.themepath %>css/styles-login.css': '<%= paths.devpath %>less/login-style.less'
                }
            },
            devstyle: {
                files: {
                    '<%= paths.themepath %>style.dev.css': '<%= paths.devpath %>less/style.less',
                }
            }
        },
        // AUTOPREFIXER
        autoprefixer: {
            options: {
                browsers: [ 'last 2 versions', 'ie 8', 'ie 9' ]
            },
            theme: {
                src: '<%= paths.themepath %>style.dev.css',
                dest: '<%= paths.themepath %>style.ap.css'
            },
        },
        // MINIFICATION
        cssmin: {
            dev2theme: {
                // COMPILATION CSS rapide pour le développement
                // Appellée par watch:lessedited après édition d'un fichier dev/less/*/*.less
                options: {
                    banner: '/*\nTheme Name: <%= wp.themename %>\nTheme URI: <%= wp.themeuri %>\nDescription: <%= pkg.description %>\nAuthor: <%= wp.themeauthor %>\nAuthorURI: <%= wp.themeauthoruri %>\nVersion: <%= pkg.version %>\nText Domain: <%= wp.themetextdomain %>\n*/'
                },
                files: {
                    '<%= paths.themepath %>style.css': [ '<%= paths.themepath %>style.ap.css' ]
                }
            }
        },
        /*
        ########   ## ##            ##  ######
        ##         ## ##            ## ##    ##
        ##       #########          ## ##
        ######     ## ##            ##  ######
        ##       #########    ##    ##       ##
        ##         ## ##      ##    ## ##    ##
        ########   ## ##       ######   ######
        */
        /*************************************************************************************************************************************************/
        // NORMALISE le code pour un développement plus aisé
        jsbeautifier: {
            options: {
                js: {
                    spaceInParen: true,
                    wrapLineLength: 0,
                    preserveNewlines: false,
                    keepArrayIndentation: true,
                    keepFunctionIndentation: true,
                }
            },
            scripts: {
                src: [ '<%= paths.devpath %>js/scripts.js' ],
            },
            grunt: {
                src: [ 'Gruntfile.js' ]
            }
        },
        jshint: {
            options: {
                reporter: require( 'jshint-stylish' ),
            },
            all: [ '<%= paths.devpath %>js/scripts.js' ],
            grunt: [ 'Gruntfile.js' ]
        },
        uglify: {
            options: {
                preserveComments: 'some',
                compress: {
                    'drop_console': true
                },
                banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' + '<%= grunt.template.today("yyyy-mm-dd") %> */ '
            },
            'my_target': {
                files: {
                    '<%= paths.themepath %>js/scripts.min.js': [ '<%= paths.devpath %>js/scripts.js' ],
                }
            },
        },
        /*
        ########   ## ##       ######   #######  ##    ##  ######     ###    ########
        ##         ## ##      ##    ## ##     ## ###   ## ##    ##   ## ##      ##
        ##       #########    ##       ##     ## ####  ## ##        ##   ##     ##
        ######     ## ##      ##       ##     ## ## ## ## ##       ##     ##    ##
        ##       #########    ##       ##     ## ##  #### ##       #########    ##
        ##         ## ##      ##    ## ##     ## ##   ### ##    ## ##     ##    ##
        ########   ## ##       ######   #######  ##    ##  ######  ##     ##    ##
        */
        /*************************************************************************************************************************************************/
        // STATIC
        // Concaténation devant être appellée par sécurité avant un build
        'bower_concat': {
            options: {
                sourceMap: false
            },
            all: {
                options: {
                    sourceMap: false,
                },
                dest: '<%= paths.temppath %>js/tmp/bower_concat.js',
                // Je ne charge pas les css de bower actuellement
                // mais la feuille est générée tout de même
                cssDest: '<%= paths.temppath %>bower_concat.css',
                include: [ 'es5-shim', 'modernizr' ],
                dependencies: {},
                bowerOptions: {
                    relative: false
                },
                mainFiles: {}
            },
        },
        // CONCATENATION JS
        concat: {
            options: {
                separator: ' ',
                stripBanners: true,
                banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' + '<%= grunt.template.today("dd-mm-yyyy") %> [FR] */',
                process: function( src, filepath ) {
                    return '\n//####' + filepath + '\n' + src;
                },
                nonull: true,
            },
            dist: {
                files: {
                    '<%= paths.themepath %>js/bower.js': [ '<%= paths.temppath %>js/tmp/bower_concat.js' ]
                }
            }
        },
        /*
        ########   ## ##       ######  ##       ########    ###    ##    ##
        ##         ## ##      ##    ## ##       ##         ## ##   ###   ##
        ##       #########    ##       ##       ##        ##   ##  ####  ##
        ######     ## ##      ##       ##       ######   ##     ## ## ## ##
        ##       #########    ##       ##       ##       ######### ##  ####
        ##         ## ##      ##    ## ##       ##       ##     ## ##   ###
        ########   ## ##       ######  ######## ######## ##     ## ##    ##
        */
        /*************************************************************************************************************************************************/
        // Empties folders to start fresh
        clean: {
            //serve: {
            //src: [ '<%= paths.temppath %>*', '<%= paths.libspath %>**/*.md', '<%= paths.libspath %>**/*LICENSE', '<%= paths.libspath %>**/*.txt', '<%= paths.libspath %>**/*.json', '<%= paths.libspath %>**/*.hbs', '<%= paths.libspath %>**/*.gzip', '<%= paths.libspath %>**/*.map', '<%= paths.libspath %>**/*.coffee', '<%= paths.libspath %>**/CHANGES', '<%= paths.libspath %>**/Makefile', ]
            //},
            //images: {
            //  src: [ '<%= paths.themepath %>img/**/*.jpg', '<%= paths.themepath %>img/**/*.png', '<%= paths.themepath %>img/**/*.gif', '<%= paths.themepath %>img/**/*.ico', '<%= paths.themepath %>img/**/*.webp' ]
            //},
            yesimlocal: {
                src: [ './dev/yesimlocal.php' ]
            }
        },
        /*
        ########   ## ##      ########  ######## ########  ##        #######  ##    ##
        ##         ## ##      ##     ## ##       ##     ## ##       ##     ##  ##  ##
        ##       #########    ##     ## ##       ##     ## ##       ##     ##   ####
        ######     ## ##      ##     ## ######   ########  ##       ##     ##    ##
        ##       #########    ##     ## ##       ##        ##       ##     ##    ##
        ##         ## ##      ##     ## ##       ##        ##       ##     ##    ##
        ########   ## ##      ########  ######## ##        ########  #######     ##
        */
        /*************************************************************************************************************************************************/
        gitpush: {
            originmaster: {
                options: {
                    verbose: true,
                    remote: 'origin',
                    //cwd: 'ssh+git://133080@git.dc0.gpaas.net'
                }
            }
        },
        /*************************************************************************************************************************************************/
        /*************************************************************************************************************************************************/
        /*************************************************************************************************************************************************/
        /*
        ########   ## ##      ##      ##    ###    ########  ######  ##     ##
        ##         ## ##      ##  ##  ##   ## ##      ##    ##    ## ##     ##
        ##       #########    ##  ##  ##  ##   ##     ##    ##       ##     ##
        ######     ## ##      ##  ##  ## ##     ##    ##    ##       #########
        ##       #########    ##  ##  ## #########    ##    ##       ##     ##
        ##         ## ##      ##  ##  ## ##     ##    ##    ##    ## ##     ##
        ########   ## ##       ###  ###  ##     ##    ##     ######  ##     ##
        */
        // SURVEILLANCE
        // WATCH : Cette tâche en appelle d'autres dès qu'elle détecte des changements sur les fichiers définis
        // Watches files for changes and runs tasks based on the changed files
        watch: {
            options: {
                nospawn: true,
                livereload: true, // activation du reload
                port: 9002
            },
            // Gruntfile.js mise à jour, je reload
            mygruntfile: {
                options: {
                    livereload: false // activation du reload
                },
                files: [ 'Gruntfile.js' ],
                tasks: [ 'jshint:grunt', 'jsbeautifier:grunt' ],
            },
            // STYLES
            lessEdited: { // Au changement d'un fichier .less, on appelle la tâche de compilation
                files: [ '<%= paths.devpath %>less/{,*/,*/*/}*.less' ],
                tasks: [ 'reloadCss' ],
            },
            // SCRIPTS
            scriptsEdited: {
                options: {
                    nospawn: true,
                    livereload: true // activation du reload
                },
                // Au changement d'un fichier .less, on appelle la tâche de compilation
                files: [ '<%= paths.devpath %>js/scripts.js' ], // which files to watch
                tasks: [ 'reloadJs' ],
            },
            // LIVERELOAD : fichiers modifiés qui n'appellent pas d'autres tâches que le reload
            livereload: {
                files: [ '<%= paths.themepath %>{,*/,*/*/,*/*/*/}*.php' ]
            },
        },
        /*
        ########   ## ##       ######   #######  ##    ## ##    ## ########  ######  ########
        ##         ## ##      ##    ## ##     ## ###   ## ###   ## ##       ##    ##    ##
        ##       #########    ##       ##     ## ####  ## ####  ## ##       ##          ##
        ######     ## ##      ##       ##     ## ## ## ## ## ## ## ######   ##          ##
        ##       #########    ##       ##     ## ##  #### ##  #### ##       ##          ##
        ##         ## ##      ##    ## ##     ## ##   ### ##   ### ##       ##    ##    ##
        ########   ## ##       ######   #######  ##    ## ##    ## ########  ######     ##
        */
        /*************************************************************************************************************************************************/
        // SERVEUR : configuration de connect
        connect: {
            options: {
                protocol: 'http',
                port: 9002,
                hostname: 'bodyrock.fromscratch.xyz',
                livereload: 35729,
                base: '',
                //key: grunt.file.read( 'ssl/gh/ca.key' ).toString(),
                //cert: grunt.file.read( 'ssl/gh/ca.crt' ).toString()
            },
            livereload: {
                options: {
                    open: 'http://bodyrock.fromscratch.xyz/',
                    //open:true,
                    //protocol: 'http',
                    base: '<%= paths.mainsitepath %>',
                    //key: grunt.file.read( 'ssl/gh/ca.key' ).toString(),
                    //cert: grunt.file.read( 'ssl/gh/ca.crt' ).toString()
                }
            }
        },
        /*************************************************************************************************************************************************/
        /*************************************************************************************************************************************************/
        /*************************************************************************************************************************************************/
        /*
        ########   ## ##       ######   #######  ########  ##    ##
        ##         ## ##      ##    ## ##     ## ##     ##  ##  ##
        ##       #########    ##       ##     ## ##     ##   ####
        ######     ## ##      ##       ##     ## ########     ##
        ##       #########    ##       ##     ## ##           ##
        ##         ## ##      ##    ## ##     ## ##           ##
        ########   ## ##       ######   #######  ##           ##
        */
        // BODYROCK
        copy: {
            libsFonts: {
                files: [
      // makes all src relative to cwd
                    {
                        src: '<%= paths.devpath %>fonts/icomoon.eot',
                        dest: '<%= paths.themepath %>fonts/icomoon.<%= pkg.version %>.eot'
                    },
                    {
                        src: '<%= paths.devpath %>fonts/icomoon.woff',
                        dest: '<%= paths.themepath %>fonts/icomoon.<%= pkg.version %>.woff'
                    },
                    {
                        src: '<%= paths.devpath %>fonts/icomoon.ttf',
                        dest: '<%= paths.themepath %>fonts/icomoon.<%= pkg.version %>.ttf'
                    },
                    {
                        src: '<%= paths.devpath %>fonts/icomoon.svg',
                        dest: '<%= paths.themepath %>fonts/icomoon.<%= pkg.version %>.svg'
                    } ],
            },
            changelog: {
                files: [
      // makes all src relative to cwd
                    {
                        src: 'CHANGELOG.md',
                        dest: 'changelogs/CHANGELOG-<%= pkg.version %>.md'
      },
    ],
            },
            versioning: {
                files: [
      // makes all src relative to cwd
                    {
                        src: '<%= paths.themepath %>style.css',
                        dest: '<%= paths.themepath %>style.<%= pkg.version %>.css',
      },
                    {
                        src: '<%= paths.themepath %>js/scripts.min.js',
                        dest: '<%= paths.themepath %>js/scripts.<%= pkg.version %>.min.js',
      },
    ],
            },
            yesimlocal: {
                files: [
      // makes all src relative to cwd
                    {
                        src: 'assets/yesimlocal.php',
                        dest: '<%= paths.devpath %>yesimlocal.php',
      }
    ],
            }
        }
    } );
    /****************************/
    /****************************/
    /****************************/
    /****************************/
    /****************************/
    /****************************/
    /*
    ##         ## ##      ########    ###     ######  ##    ##  ######
    ##         ## ##         ##      ## ##   ##    ## ##   ##  ##    ##
    ##       #########       ##     ##   ##  ##       ##  ##   ##
    ##         ## ##         ##    ##     ##  ######  #####     ######
    ##       #########       ##    #########       ## ##  ##         ##
    ##         ## ##         ##    ##     ## ##    ## ##   ##  ##    ##
    ########   ## ##         ##    ##     ##  ######  ##    ##  ######
    /****************************/
    // Import des modules inclus dans package.json
    require( 'load-grunt-tasks' )( grunt );
    // TESTS
    grunt.registerTask( 'test', [ 'connect:test', 'karma' ] );
    grunt.registerTask( 'mochatest', function() {
        grunt.task.run( [ 'phantom', 'mocha' ] );
    } );
    // TRANSITION dev/prod
    grunt.registerTask( 'dev', function( target ) {
        switch ( target ) {
            default:
            /*
            Preparation du mode développement
            - copie du fichier yesimlocal.php dans /dev/
            - suppression du manifest.xml et du .appcache dans /htdocs/
            */
                grunt.task.run( [ 'copy:yesimlocal', 'clean:webapp' ] );
            break;
            case 'prod':
                /*
                Préparation du mode production
                - suppression du fichier imlocal.php dans /dev/
                - copie des fichiers manifest.xml et .appcache dans /htdocs/
                */
                    grunt.task.run( [ 'clean:yesimlocal', 'copy:webapp' ] );
                break;
        }
    } );
    // MES TACHES
    grunt.registerTask( 'reloadFonts', function() {
        grunt.task.run( [ 'copy:libsFonts' ] );
    } );
    grunt.registerTask( 'reloadCss', function() {
        grunt.task.run( [ 'less:devstyle', 'autoprefixer:theme', 'cssmin:dev2theme' ] );
    } );
    grunt.registerTask( 'reloadJs', function( target ) {
        if ( target === 'prod' ) {
            grunt.task.run( [ 'jsbeautifier', 'jshint', 'uglify' ] );
        } else {
            grunt.task.run( [ 'jsbeautifier', 'jshint', 'uglify' ] );
        }
    } );
    grunt.registerTask( 'reloadImg', function() {
        grunt.task.run( [] );
    } );
    grunt.registerTask( 'reloadHtml', function() {
        grunt.task.run( [] );
    } );
    grunt.registerTask( 'responsive', function() {
        grunt.task.run( [] );
    } );
    ///// ETAPE DE JS DEV:PROD
    grunt.registerTask( 'reloadJsProd', function() {
        grunt.task.run( [ 'reloadFonts', 'reloadCss', 'reloadJs:prod', 'copy:versioning' ] );
    } );
    /*
    ##         ## ##      ########  ########   #######  ########
    ##         ## ##      ##     ## ##     ## ##     ## ##     ##
    ##       #########    ##     ## ##     ## ##     ## ##     ##
    ##         ## ##      ########  ########  ##     ## ##     ##
    ##       #########    ##        ##   ##   ##     ## ##     ##
    ##         ## ##      ##        ##    ##  ##     ## ##     ##
    ########   ## ##      ##        ##     ##  #######  ########
    /****************************/
    ///// ETAPE DE RELEASE
    grunt.registerTask( 'production', function() {
        grunt.task.run( [ 'copy:libsFonts', 'reloadCss', 'reloadJs:prod', 'copy:changelog', 'clean:changelog', 'changelog', 'copy:versioning', /*'reloadHtml',*/ 'dev:prod', 'reloadImg' ] );
    } );
    grunt.registerTask( 'optimize', function() {
        grunt.option( 'force', true );
        grunt.task.run( [] );
    } );
    // CLEAN, COMMIT, TAG, PUSH, DEPLOY
    grunt.registerTask( 'push', function() {
        grunt.log.warn( 'Preparation de l\'envoi...' );
        grunt.task.run( [ 'gitpush:originmaster', 'dev' ] );
    } );
    /*
    ##         ## ##       ######   ########  ##     ## ##    ## ########
    ##         ## ##      ##    ##  ##     ## ##     ## ###   ##    ##
    ##       #########    ##        ##     ## ##     ## ####  ##    ##
    ##         ## ##      ##   #### ########  ##     ## ## ## ##    ##
    ##       #########    ##    ##  ##   ##   ##     ## ##  ####    ##
    ##         ## ##      ##    ##  ##    ##  ##     ## ##   ###    ##
    ########   ## ##       ######   ##     ##  #######  ##    ##    ##
    /****************************/
    // CREER UN SERVEUR persistant avec connect et livereload
    grunt.registerTask( 'serve', function() {
        grunt.task.run( [ 'connect:livereload', 'watch' ] );
    } );
    // TACHE PAR DEFAUT
    grunt.registerTask( 'default', [ 'serve' ] );
};
