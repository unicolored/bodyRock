// matching one level down:
// 'test/spec/{,*/}*.js'
// recursively match all subfolders:
// 'test/spec/**/*.js'
module.exports = function( grunt ) {
    'use strict';
    // Module qui affiche le temps d'éxécution de chaque tâche.
    // Utile pour détecter des anomalies et vérifier la performance des tâches.
    require( 'time-grunt' )( grunt );
    // Mozjpeg est un compresseur d'images
    // Il est utilisé par le plugin grunt-imagemin pour compresser les jpeg.
    var mozjpeg = require( 'imagemin-mozjpeg' );
    var jpegRecompress = require( 'imagemin-jpeg-recompress' );
    var jpegoptim = require( 'imagemin-jpegoptim' );
    // Config
    grunt.initConfig( {
        /*************************************************************************************************************************************************/
        pkg: grunt.file.readJSON( 'package.json' ),
        //////////// Project settings
        gh: {
            /* VARIABLES DU PROJET */
            app: require( './bower.json' ).appPath || '',
            themename: 'Rock Gilles Hoarau',
            themeuri: 'https://www.gilleshoarau.com',
            themeauthor: 'Gilles Hoarau',
            themeauthoruri: 'https://www.gilleshoarau.com',
            themetemplate: 'bodyrock',
            themetextdomain: 'rock-gilleshoarau',
            /* PATHS */
            mainsitepath: 'htdocs/',
            contentpath: 'htdocs/wp-content/',
            themepath: 'htdocs/wp-content/themes/rock-gilleshoarau/',
            relativethemepath: 'wp-content/themes/rock-gilleshoarau/',
            libspath: 'bower_components/',
            assetspath: 'htdocs/devassets/',
            devpath: 'dev/',
            temppath: 'tmp/',
            /* ASSETS */
            htmlAssets: [ '<%= gh.temppath %>html/front-page.html', '<%= gh.temppath %>html/services.html', '<%= gh.temppath %>html/projets.html', '<%= gh.temppath %>html/contact.html', '<%= gh.temppath %>html/single.html' ],
            cssFonts: [ '<%= gh.temppath %>fonts/font1.css', '<%= gh.temppath %>fonts/font2.css', '<%= gh.temppath %>fonts/font3.css' ],
            jsAssets: [ '<%= gh.devpath %>js/totoro.js', '<%= gh.devpath %>js/angular/*.js' ],
            jsScripts: [ '<%= gh.devpath %>js/scripts/script_nicescroll.js', '<%= gh.devpath %>js/scripts/analytics.js' ],
            iconsSet: '<%= gh.libspath %>elusive-iconfont/css/elusive-webfont.css'
        },
        humans_txt: {
            external_file: {
                options: {
                    intro: "Bonjour, ça va ?",
                    commentStyle: 'u',
                    content: grunt.file.readJSON( 'humans.json' ),
                    includeUpdateIn: 'string',
                },
                dest: 'htdocs/humans.txt',
            },
        },
        /*
        ##          ###     ######   ######  ######## ########  ######
        ##         ## ##   ##    ## ##    ## ##          ##    ##    ##
        ##        ##   ##  ##       ##       ##          ##    ##
        ##       ##     ##  ######   ######  ######      ##     ######
        ##       #########       ##       ## ##          ##          ##
        ##       ##     ## ##    ## ##    ## ##          ##    ##    ##
        ######## ##     ##  ######   ######  ########    ##     ######
        */
        /*
        ########   ## ##       ######   ######   ######
        ##         ## ##      ##    ## ##    ## ##    ##
        ##       #########    ##       ##       ##
        ######     ## ##      ##        ######   ######
        ##       #########    ##             ##       ##
        ##         ## ##      ##    ## ##    ## ##    ##
        ########   ## ##       ######   ######   ######
        */
        /*************************************************************************************************************************************************/
        // GENERATION DU CSS
        less: {
            options: {
                compress: false,
                yuicompress: false,
            },
            // COMPILATION des deux fichiers .less principaux : bootstrap et style
            wordpress: {
                files: {
                    //"<%= gh.assetspath %>css/bootstrap.css": "<%= gh.devpath %>less/bootstrap.less",
                    "<%= gh.assetspath %>css/styles-login.css": "<%= gh.devpath %>less/login-style.less"
                }
            },
            style: {
                files: {
                    "<%= gh.assetspath %>css/style.css": "<%= gh.devpath %>less/style.less",
                }
            },
            snake: {
                files: {
                    "<%= gh.mainsitepath %>apps/snake/snake.css": "<%= gh.devpath %>less/apps/snake.less"
                }
            }
        },
        /*
        ########   ## ##       ######  ##     ## ########  ##
        ##         ## ##      ##    ## ##     ## ##     ## ##
        ##       #########    ##       ##     ## ##     ## ##
        ######     ## ##      ##       ##     ## ########  ##
        ##       #########    ##       ##     ## ##   ##   ##
        ##         ## ##      ##    ## ##     ## ##    ##  ##
        ########   ## ##       ######   #######  ##     ## ########
        */
        // DEBUG // BACKGROUND
        curl: {
            fonts1: {
                dest: '<%= gh.assetspath %>fonts/font1.css',
                src: 'https://fonts.googleapis.com/css?family=Share+Tech'
            },
            fonts2: {
                dest: '<%= gh.assetspath %>fonts/font2.css',
                src: 'https://fonts.googleapis.com/css?family=Open+Sans:800italic,400,800,300'
            },
            fonts3: {
                dest: '<%= gh.assetspath %>fonts/font3.css',
                src: 'https://fonts.googleapis.com/css?family=Roboto:400italic,100,700italic,700,100italic,400'
            },
            gravatar: {
                dest: '<%= gh.devpath %>img/ico/gravatar.jpg',
                src: 'https://www.gravatar.com/avatar/9a424bfbb842ed0e00426d5470f09be3?s=120'
            },
            ga: {
                dest: '<%= gh.devpath %>js/tmp/analytics.js',
                src: 'https://www.google-analytics.com/analytics.js'
            }
        },
        // AUTOPREFIXER
        autoprefixer: {
            options: {
                browsers: [ 'last 2 versions', 'ie 8', 'ie 9' ]
            },
            iconsset: {
                src: '<%= gh.iconsSet %>',
                dest: '<%= gh.assetspath %>css/icons.ap.css'
            },
            /*,
                        bootstrap: {
                          src: '<%= gh.assetspath %>css/bootstrap.css',
                          dest: '<%= gh.assetspath %>css/bootstrap.ap.css'
                        }*/
            theme: {
                src: '<%= gh.assetspath %>css/theme.css',
                dest: '<%= gh.assetspath %>css/theme.ap.css'
            },
        },
        // MINIFICATION
        cssmin: {
            style: {
                options: {
                    banner: '/*\nTheme Name: <%= gh.themename %>\nTheme URI: <%= gh.themeuri %>\nDescription: <%= pkg.description %>\nAuthor: <%= gh.themeauthor %>\nAuthorURI: <%= gh.themeauthoruri %>\nTemplate: <%= gh.themetemplate %>\nVersion: <%= pkg.version %>\nText Domain: <%= gh.themetextdomain %>\n*/'
                },
                files: {
                    "<%= gh.themepath %>style.css": [ "<%= gh.assetspath %>fonts/font1.css", "<%= gh.assetspath %>fonts/font2.css", "<%= gh.assetspath %>fonts/font3.css", "<%= gh.assetspath %>css/icons.ap.css", "<%= gh.assetspath %>css/bootstrap.ap.css", "<%= gh.assetspath %>css/theme.ap.css" ]
                }
            },
            devtheme: {
                options: {
                    banner: '/*\nTheme Name: <%= gh.themename %>\nTheme URI: <%= gh.themeuri %>\nDescription: <%= pkg.description %>\nAuthor: <%= gh.themeauthor %>\nAuthorURI: <%= gh.themeauthoruri %>\nTemplate: <%= gh.themetemplate %>\nVersion: <%= pkg.version %>\nText Domain: <%= gh.themetextdomain %>\n*/'
                },
                files: {
                    "<%= gh.assetspath %>css/theme.css": [ "<%= gh.devpath %>css/icomoon.css", "<%= gh.assetspath %>css/style.css" ]
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
            default: {
                src: [ "<%= gh.devpath %>js/**/*.js" ],
            },
            test: {
                src: [ "test/spec/{,*/}*.js" ],
            },
            apps: {
                src: [ "<%= gh.mainsitepath %>apps/{,*/}*.js" ],
            },
            grunt: {
                src: [ "Gruntfile.js" ]
            }
        },
        jshint: {
            options: {
                reporter: require( 'jshint-stylish' ),
            },
            //beforeconcat: '<%= gh.jsAssets %>',
            all: [ '<%= gh.devpath %>js/{angular}/*.js' ],
            grunt: [ 'Gruntfile.js' ],
            apps: [ "<%= gh.mainsitepath %>apps/{,*/}*.js" ]
        },
        ngAnnotate: {
            options: {
                singleQuotes: true,
            },
            app1: {
                files: {
                    //'<%= gh.devpath %>js/tmp/bower_concat.js': [ '<%= gh.devpath %>js/tmp/bower_concat.js' ],
                    '<%= gh.devpath %>js/tmp/totoro.js': [ '<%= gh.devpath %>js/totoro.js' ],
                    '<%= gh.devpath %>js/tmp/angular/carousel.js': [ '<%= gh.devpath %>js/angular/carousel.js' ],
                    '<%= gh.devpath %>js/tmp/angular/contact.js': [ '<%= gh.devpath %>js/angular/contact.js' ],
                    '<%= gh.devpath %>js/tmp/angular/console.js': [ '<%= gh.devpath %>js/angular/console.js' ],
                    '<%= gh.devpath %>js/tmp/angular/modal.js': [ '<%= gh.devpath %>js/angular/modal.js' ],
                    '<%= gh.devpath %>js/tmp/angular/navbot.js': [ '<%= gh.devpath %>js/angular/navbot.js' ],
                    '<%= gh.devpath %>js/tmp/angular/portfolio.js': [ '<%= gh.devpath %>js/angular/portfolio.js' ],
                    '<%= gh.themepath %>js/scripts.js': [ '<%= gh.themepath %>js/scripts.js' ]
                },
            },
            /*
          snake: {
          files: {
          '<%= gh.devpath %>js/apps/snake.js': [ '<%= gh.devpath %>js/apps/snake.js' ],
        },
      }*/
        },
        uglify: {
            options: {
                preserveComments: 'some'
            },
            my_target: {
                files: {
                    '<%= gh.themepath %>js/scripts.min.js': [ '<%= gh.themepath %>js/scripts.js' ],
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
        bower_concat: {
            all: {
                dest: '<%= gh.devpath %>js/tmp/bower_concat.js',
                // je ne charge pas les css de bower actuellement
                cssDest: '<%= gh.temppath %>bower_concat.css',
                exclude: [ 'json3', 'es5-shim', 'jquery', 'jquery-ui', 'angular-scenario', 'angular-mocks', 'angular-bootstrap', 'gmaps', 'jquery-ui', 'elusive-iconfont' ],
                dependencies: {
                    'jquery': 'angular',
                    'jquery.easing': 'jquery',
                    'bootstrap': 'jquery',
                },
                bowerOptions: {
                    relative: false
                },
                mainFiles: {
                    'angular': [ 'angular.min.js' ],
                    'angular-local-storage': [ 'dist/angular-local-storage.min.js' ],
                    'angular-file-upload': [ 'angular-file-upload.min.js' ],
                }
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
                    '<%= gh.themepath %>js/scripts.js': [ '<%= gh.devpath %>js/jquery-ui-custom.js', '<%= gh.devpath %>js/tmp/bower_concat.js', '<%= gh.devpath %>js/tmp/totoro.js', '<%= gh.devpath %>js/tmp/angular/*.js', '<%= gh.jsScripts %>' ]
                }
            },
            jqueryui: {
                options: {
                    separator: ' ',
                    stripBanners: true,
                    banner: '',
                    process: function( src, filepath ) {
                        return '\n//####' + filepath + '\n' + src;
                    },
                    nonull: true,
                },
                files: {
                    '<%= gh.devpath %>js/jquery-ui-custom.js': [ '<%= gh.libspath %>jquery-ui/ui/core.js', '<%= gh.libspath %>jquery-ui/ui/widget.js', '<%= gh.libspath %>jquery-ui/ui/mouse.js', '<%= gh.libspath %>jquery-ui/ui/draggable.js', '<%= gh.libspath %>jquery-ui/ui/droppable.js', '<%= gh.libspath %>jquery-ui/ui/resizable.js', '<%= gh.libspath %>jquery-ui/ui/selectable.js', '<%= gh.libspath %>jquery-ui/ui/sortable.js', '<%= gh.libspath %>jquery-ui/ui/datepicker.js', '<%= gh.libspath %>jquery-ui/ui/i18n/datepicker-fr.js' ]
                }
            },
            /*
      snake: {
      files: {
      '<%= gh.mainsitepath %>apps/snake/snake.js': [ '<%= gh.devpath %>js/apps/snake-yahoo-dom-event.js', '<%= gh.devpath %>js/apps/snake-container-min.js', '<%= gh.devpath %>js/apps/snake.js' ]
    }
  },*/
        },
        /*
        ########   ## ##      #### ##     ##    ###     ######   ########  ######
        ##         ## ##       ##  ###   ###   ## ##   ##    ##  ##       ##    ##
        ##       #########     ##  #### ####  ##   ##  ##        ##       ##
        ######     ## ##       ##  ## ### ## ##     ## ##   #### ######    ######
        ##       #########     ##  ##     ## ######### ##    ##  ##             ##
        ##         ## ##       ##  ##     ## ##     ## ##    ##  ##       ##    ##
        ########   ## ##      #### ##     ## ##     ##  ######   ########  ######
        */
        /*************************************************************************************************************************************************/
        // OPTIMISATION D'IMAGES
        imagemin: { // Task
            dynamic: { // Another target
                options: {
                    optimizationLevel: 3,
                    svgoPlugins: [ {
                        removeViewBox: false
      } ],
                    use: [ mozjpeg() ]
                },
                files: [ {
                    expand: true, // Enable dynamic expansion
                    cwd: '<%= gh.devpath %>img/', // Src matches are relative to this path
                    src: [ '**/*.{png,jpg,gif,ico,svg}' ], // Actual patterns to match
                    dest: '<%= gh.themepath %>img/' // Destination path prefix
    } ]
            },
            uploads: { // Another target
                options: {
                    optimizationLevel: 3,
                    svgoPlugins: [ {
                        removeViewBox: false
      } ],
                    use: [ mozjpeg() ]
                },
                files: [ {
                    expand: true, // Enable dynamic expansion
                    cwd: '<%= gh.contentpath %>uploads/', // Src matches are relative to this path
                    src: [ '**/*.{png,jpg,gif,ico,svg}' ], // Actual patterns to match
                    dest: '<%= gh.temppath %>uploads/' // Destination path prefix
    } ]
            }
        },
        webp: {
            uploads: {
                options: {
                    //binpath: 'C:/Users/Administrator/AppData/Roaming/npm/node_modules/webp-bin/bin',
                    binpath: 'C:/Program Files (x86)/Webp/bin/cwebp',
                    preset: 'photo',
                    verbose: true,
                    quality: 70,
                    alphaQuality: 70,
                    compressionMethod: 4,
                    segments: 4,
                    psnr: 42,
                    sns: 50,
                    filterStrength: 0,
                    filterSharpness: 3,
                    simpleFilter: true,
                    partitionLimit: 50,
                    analysisPass: 6,
                    multiThreading: true,
                    lowMemory: false,
                    alphaMethod: 0,
                    alphaFilter: 'best',
                    alphaCleanup: true,
                    noAlpha: false,
                    lossless: false,
                    force: true
                },
                files: [ {
                    expand: true,
                    cwd: '<%= gh.temppath %>uploads/2014',
                    src: [ '**/*.jpg' ],
                    dest: '<%= gh.temppath %>uploads2/2014'
    } ],
            },
            images: {
                options: {
                    //binpath: 'C:/Users/Administrator/AppData/Roaming/npm/node_modules/webp-bin/bin',
                    binpath: 'C:/Program Files (x86)/Webp/bin/cwebp',
                    preset: 'default',
                    verbose: true,
                    quality: 80,
                    alphaQuality: 70,
                    compressionMethod: 3,
                    segments: 4,
                    psnr: 42,
                    sns: 50,
                    filterStrength: 0,
                    filterSharpness: 3,
                    //simpleFilter: true,
                    partitionLimit: 50,
                    analysisPass: 6,
                    multiThreading: true,
                    lowMemory: false,
                    alphaMethod: 0,
                    alphaFilter: 'best',
                    alphaCleanup: true,
                    noAlpha: false,
                    lossless: true,
                    force: true
                },
                files: [ {
                    expand: true,
                    cwd: '<%= gh.themepath %>img/',
                    src: [ '**/*.{jpg,png,gif,ico}' ],
                    dest: '<%= gh.themepath %>img/'
    } ],
            }
        },
        /*
        ########   ## ##      ##     ## ######## ##     ## ##
        ##         ## ##      ##     ##    ##    ###   ### ##
        ##       #########    ##     ##    ##    #### #### ##
        ######     ## ##      #########    ##    ## ### ## ##
        ##       #########    ##     ##    ##    ##     ## ##
        ##         ## ##      ##     ##    ##    ##     ## ##
        ########   ## ##      ##     ##    ##    ##     ## ########
        */
        /*************************************************************************************************************************************************/
        exec: {
            front: 'curl -k https://www.gilleshoarau.com/ > <%= gh.temppath %>html/front-page.html',
            services: 'curl -k https://www.gilleshoarau.com/a-propos/ > <%= gh.temppath %>html/services.html',
            projets: 'curl -k https://www.gilleshoarau.com/projets/ > <%= gh.temppath %>html/projets.html',
            contact: 'curl -k https://www.gilleshoarau.com/contact/ > <%= gh.temppath %>html/contact.html',
            single: 'curl -k https://www.gilleshoarau.com/creation-3d-champagne-clerambault/ > <%= gh.temppath %>html/single.html',
            application: 'curl -k https://www.gilleshoarau.com/ > <%= gh.mainsitepath %>application.html',
        },
        prettify: {
            options: {
                indent: 4,
                indent_char: ' ',
                wrap_line_length: 78,
                brace_style: 'expand',
                //unformatted: [ 'a', 'sub', 'sup', 'b', 'i', 'u' ]
                unformatted: [ 'php' ]
            },
            /*
            one: {
                src: '<%= gh.themepath %>assets/html/front-page.html',
                dest: '<%= gh.themepath %>assets/html/front-page.pf.html'
            },*/
            p404: {
                src: '<%= gh.themepath %>404.php',
                dest: '<%= gh.themepath %>404.php',
            },
            cprojets: {
                src: '<%= gh.themepath %>category-projets.php',
                dest: '<%= gh.themepath %>category-projets.php',
            },
            category: {
                src: '<%= gh.themepath %>category.php',
                dest: '<%= gh.themepath %>category.php',
            },
            footer: {
                src: '<%= gh.themepath %>footer.php',
                dest: '<%= gh.themepath %>footer.php',
            },
            front: {
                src: '<%= gh.themepath %>front-page.php',
                dest: '<%= gh.themepath %>front-page.php',
            },
            header: {
                src: '<%= gh.themepath %>header.php',
                dest: '<%= gh.themepath %>header.php',
            },
            headercache: {
                src: '<%= gh.themepath %>header-cache.php',
                dest: '<%= gh.themepath %>header-cache.php',
            },
            footercache: {
                src: '<%= gh.themepath %>footer-cache.php',
                dest: '<%= gh.themepath %>footer-cache.php',
            },
            index: {
                src: '<%= gh.themepath %>index.php',
                dest: '<%= gh.themepath %>index.php',
            },
            contact: {
                src: '<%= gh.themepath %>page-contact.php',
                dest: '<%= gh.themepath %>page-contact.php',
            },
            servicescompetences: {
                src: '<%= gh.themepath %>page-servicescompetences.php',
                dest: '<%= gh.themepath %>page-servicescompetences.php',
            },
            single: {
                src: '<%= gh.themepath %>single.php',
                dest: '<%= gh.themepath %>single.php',
            },
            // -------------- Views
            views: {
                expand: true,
                cwd: '<%= gh.themepath %>js/navbot/',
                ext: '.html',
                src: [ '*.html' ],
                dest: '<%= gh.themepath %>js/navbot/'
            },
            // -------------- Apps
            apps: {
                expand: true,
                cwd: '<%= gh.mainsitepath %>apps/*/',
                ext: '.html',
                src: [ '*.html' ],
                dest: '<%= gh.mainsitepath %>apps/*/'
            },
            // -------------- Tpl
            /*
            single: {
                src: '<%= gh.themepath %>single.php',
                dest: '<%= gh.themepath %>single.php',
            }*/
        },
        htmlhint: {
            options: {
                'tag-pair': true, // Tag must be paired.
                'tagname-lowercase': true, //Tagname must be lowercase.
                'attr-lowercase': true,
                'attr-value-double-quotes': true,
                'attr-value-not-empty': true,
                'attr-no-duplication': true,
                'doctype-first': true,
                'doctype-html5': true,
                'tag-self-close': true,
                'spec-char-escape': true,
                'id-unique': true,
                'src-not-empty': true,
                //Perfomance
                'head-script-disabled': true,
                'img-alt-require': true,
                'id-class-value': true,
                'style-disabled': true,
                'space-tab-mixed-disabled': true,
                'id-class-ad-disabled': true, // Id and class can not use ad keyword, it will blocked by adblock software.
                'href-abs-or-rel': false,
                'attr-unsafe-chars': true,
            },
            html1: {
                src: '<%= gh.htmlAssets %>'
            }
        },
        /*
        ########   ## ##      ##     ##    ###    ##       #### ########     ###    ######## ####  #######  ##    ##
        ##         ## ##      ##     ##   ## ##   ##        ##  ##     ##   ## ##      ##     ##  ##     ## ###   ##
        ##       #########    ##     ##  ##   ##  ##        ##  ##     ##  ##   ##     ##     ##  ##     ## ####  ##
        ######     ## ##      ##     ## ##     ## ##        ##  ##     ## ##     ##    ##     ##  ##     ## ## ## ##
        ##       #########     ##   ##  ######### ##        ##  ##     ## #########    ##     ##  ##     ## ##  ####
        ##         ## ##        ## ##   ##     ## ##        ##  ##     ## ##     ##    ##     ##  ##     ## ##   ###
        ########   ## ##         ###    ##     ## ######## #### ########  ##     ##    ##    ####  #######  ##    ##
        */
        /*************************************************************************************************************************************************/
        validation: {
            options: {
                reset: grunt.option( 'reset' ) || false,
                stoponerror: true,
                doctype: 'HTML5',
                charset: 'utf-8',
                //remotePath: 'http://decodize.com/',
                //remoteFiles: [ 'html/moving-from-wordpress-to-octopress/', 'css/site-preloading-methods/' ], //or
                //remoteFiles: 'validation-files.json', // JSON file contains array of page paths.
                //relaxerror: [ 'Bad value X-UA-Compatible for attribute http-equiv on element meta.' ] //ignores these errors
                //serverUrl: 'http://validator.gh.com/'
            },
            files: {
                src: '<%= gh.htmlAssets %>'
            }
        },
        pagespeed: {
            options: {
                nokey: true,
                //key : "AIzaSyBa68iLR7ludZoab6Wf9xYt0cPbKhsUgus",
                url: "https://www.gilleshoarau.com"
            },
            gh: {
                options: {
                    //paths: ["/"],
                    //key : "AIzaSyBa68iLR7ludZoab6Wf9xYt0cPbKhsUgus",
                    url: "https://www.gilleshoarau.com/",
                    locale: "fr_FR",
                    strategy: "desktop",
                    threshold: 80
                }
            }
        },
        /*
        ########   ## ##      ######## ########  ######  ########  ######
        ##         ## ##         ##    ##       ##    ##    ##    ##    ##
        ##       #########       ##    ##       ##          ##    ##
        ######     ## ##         ##    ######    ######     ##     ######
        ##       #########       ##    ##             ##    ##          ##
        ##         ## ##         ##    ##       ##    ##    ##    ##    ##
        ########   ## ##         ##    ########  ######     ##     ######
        */
        /*************************************************************************************************************************************************/
        // Test settings
        karma: {
            unit: {
                configFile: 'test/karma.conf.js',
                singleRun: true
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
            serve: {
                src: [ "<%= gh.temppath %>*", "<%= gh.libspath %>**/*.md", "<%= gh.libspath %>**/*LICENSE", "<%= gh.libspath %>**/*.txt", "<%= gh.libspath %>**/*.json", "<%= gh.libspath %>**/*.hbs", "<%= gh.libspath %>**/*.gzip", "<%= gh.libspath %>**/*.map", "<%= gh.libspath %>**/*.coffee", "<%= gh.libspath %>**/CHANGES", "<%= gh.libspath %>**/Makefile", ]
            },
            images: {
                src: [ "<%= gh.themepath %>img/**/*.jpg", "<%= gh.themepath %>img/**/*.png", "<%= gh.themepath %>img/**/*.gif", "<%= gh.themepath %>img/**/*.ico", "<%= gh.themepath %>img/**/*.webp" ]
            },
            changelog: {
                src: [ "./CHANGELOG.md" ]
            },
            screenshots: {
                src: [ "./dev/screenshots/**/*.png" ]
            },
            bodyRock: {
                src: [ "./bodyRock/**/*" ]
            },
            yesimlocal: {
                src: [ "./dev/yesimlocal.php" ]
            },
            webapp: {
                src: [ "./htdocs/manifest.webapp", "./htdocs/offline.appcache" ]
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
        sftp: {
            test: {
                files: {
                    "./": "*json"
                },
                options: {
                    path: '/tmp/',
                    config: 'myhost',
                    showProgress: true
                }
            }
        },
        // DIST
        changelog: {
            options: {
                // Task-specific options go here.
            }
        },
        gitpush: {
            originmaster: {
                options: {
                    verbose: true,
                    remote: 'origin',
                    //cwd: "ssh+git://133080@git.dc0.gpaas.net"
                }
            }
        },
        // DEPLOY
        sshconfig: {
            "myhost": grunt.file.readJSON( 'myhost.json' ),
        },
        sshexec: {
            deploy: {
                command: 'deploy gilleshoarau.com.git',
                options: {
                    config: 'myhost'
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
                livereload: true // activation du reload
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
                files: [ '<%= gh.devpath %>less/{,*/,*/*/}*.less' ],
                tasks: [ 'less:style', 'cssmin:devtheme' ],
            },
            // VIEWS
            views: { // Au changement d'un fichier .less, on appelle la tâche de compilation
                files: [ '<%= gh.themepath %>js/{navbot/,contact/}*.html' ],
                tasks: [ 'prettify:views' ],
            },
            // SCRIPTS
            scriptsEdited: {
                options: {
                    nospawn: true,
                    livereload: true // activation du reload
                },
                // Au changement d'un fichier .less, on appelle la tâche de compilation
                files: [ '<%= gh.devpath %>js/{,angular/}*.js', 'test/spec/{,*/}*.js' ], // which files to watch
                tasks: [ 'reloadJs' ],
            },
            // LIVERELOAD : fichiers modifiés qui n'appellent pas d'autres tâches que le reload
            livereload: {
                files: [ '<%= gh.themepath %>{,*/}*.php', 'htdocs/.htaccess' ]
            },
            // APPS
            apps: { // Au changement d'un fichier .less, on appelle la tâche de compilation
                files: [ '<%= gh.mainsitepath %>apps/{,*/}*.js', '<%= gh.mainsitepath %>apps/{,*/}*.html' ],
                tasks: [ 'jsbeautifier:apps', 'jshint:apps', 'prettify:apps' ],
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
            options: { // Port 8000 par défaut
                protocol: 'https',
                port: 9000,
                hostname: 'gilleshoarau.com',
                livereload: 35729,
                base: '',
                key: grunt.file.read( 'monserveur.key' ).toString(),
                cert: grunt.file.read( 'certificate-96884.crt' ).toString()
            },
            livereload: {
                options: {
                    open: 'https://www.gilleshoarau.com/',
                    //open:true,
                    //protocol: 'https',
                    base: '<%= gh.dist %>',
                    key: grunt.file.read( 'monserveur.key' ),
                    cert: grunt.file.read( 'certificate-96884.crt' )
                }
            },
            test: {
                options: {
                    port: 9001,
                    middleware: function( connect ) {
                        return [
                            connect.static( '.tmp' ),
                            connect.static( 'test' ),
                            connect().use( '/bower_components', connect.static( './bower_components' ) ),
                            connect.static( 'htdocs/' )
                        ];
                    }
                }
            },
        },
        phantom: {
            options: {
                port: 4444
            },
            your_target: {
                src: 'https://www.gilleshoarau.com'
            }
        },
        /*
        ########   ## ##         ###    ##     ## ########  #######   ######  ##     ##  #######  ########
        ##         ## ##        ## ##   ##     ##    ##    ##     ## ##    ## ##     ## ##     ##    ##
        ##       #########     ##   ##  ##     ##    ##    ##     ## ##       ##     ## ##     ##    ##
        ######     ## ##      ##     ## ##     ##    ##    ##     ##  ######  ######### ##     ##    ##
        ##       #########    ######### ##     ##    ##    ##     ##       ## ##     ## ##     ##    ##
        ##         ## ##      ##     ## ##     ##    ##    ##     ## ##    ## ##     ## ##     ##    ##
        ########   ## ##      ##     ##  #######     ##     #######   ######  ##     ##  #######     ##
        */
        /*************************************************************************************************************************************************/
        autoshot: {
            default_options: {
                options: {
                    // necessary config
                    path: '<%= gh.devpath %>screenshots/',
                    // optional config, must set either remote or local
                    remote: {
                        files: [ {
                            src: "https://www.gilleshoarau.com/",
                            dest: "front-page.png"
                        }, {
                            src: "https://www.gilleshoarau.com/a-propos",
                            dest: "services.png"
                        }, {
                            src: "https://www.gilleshoarau.com/projets",
                            dest: "portfolio.png"
                        }, {
                            src: "https://www.gilleshoarau.com/contact",
                            dest: "contact.png"
                        }, {
                            src: "https://www.gilleshoarau.com/creation-3d-champagne-clerambault/",
                            dest: "single.png"
                        } ],
                    },
                    local: {
                        path: './tmp/html/', // path to directory of the webpage
                        port: 8080, // port of startup http server
                        files: [ // local filename and screenshot filename
                            {
                                src: "front-page.html",
                                dest: "test.jpg",
                                delay: 3000
                            }
                        ]
                    },
                    viewport: [ '320x480', '1366x768', '1922x1200' /*, '480x854', '768x1024', '992x992', '1600x1200', '1922x1200'*/ ]
                },
            },
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
            bodyRock: {
                files: [
                    // makes all src relative to cwd
                    {
                        expand: true,
                        cwd: 'htdocs/wp-content/themes/bodyrock/',
                        src: [ '**' ],
                        dest: './bodyRock/'
                    },
                ],
            },
            libsFonts: {
                /*
                files: [
                    // makes all src relative to cwd
                    {
                        expand: true,
                        cwd: '<%= gh.devpath %>fonts/',
                        src: [ '**' ],
                        dest: '<%= gh.theme %>fonts/'
                    },
                ],*/
                files: [
                // makes all src relative to cwd
                    {
                        src: '<%= gh.devpath %>fonts/icomoon.eot',
                        dest: '<%= gh.themepath %>fonts/icomoon.<%= pkg.version %>.eot',
                },
                    {
                        src: '<%= gh.devpath %>fonts/icomoon.woff',
                        dest: '<%= gh.themepath %>fonts/icomoon.<%= pkg.version %>.woff',
                },
                    {
                        src: '<%= gh.devpath %>fonts/icomoon.ttf',
                        dest: '<%= gh.themepath %>fonts/icomoon.<%= pkg.version %>.ttf',
                },
                    {
                        src: '<%= gh.devpath %>fonts/icomoon.svg',
                        dest: '<%= gh.themepath %>fonts/icomoon.<%= pkg.version %>.svg',
                },
                ],
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
                        src: '<%= gh.themepath %>style.css',
                        dest: '<%= gh.themepath %>style.<%= pkg.version %>.css',
                      },
                    {
                        src: '<%= gh.themepath %>js/scripts.min.js',
                        dest: '<%= gh.themepath %>js/scripts.<%= pkg.version %>.min.js',
                      },
              ],
            },
            versioningImg: {
                files: [
              // makes all src relative to cwd
                    {
                        src: '<%= gh.devpath %>img/ico/logo.svg',
                        dest: '<%= gh.devpath %>img/ico/logo.<%= pkg.version %>.svg',
              },
                    {
                        src: '<%= gh.devpath %>img/ico/gravatar.jpg',
                        dest: '<%= gh.devpath %>img/ico/gravatar.<%= pkg.version %>.jpg',
              },
                    {
                        src: '<%= gh.devpath %>img/ico/favicon.ico',
                        dest: '<%= gh.devpath %>img/ico/favicon.<%= pkg.version %>.ico',
              },
                    {
                        src: '<%= gh.devpath %>img/ico/144.png',
                        dest: '<%= gh.devpath %>img/ico/144.<%= pkg.version %>.png',
              },
                    {
                        src: '<%= gh.devpath %>img/ico/16.png',
                        dest: '<%= gh.devpath %>img/ico/16.<%= pkg.version %>.png',
              },
                    {
                        src: '<%= gh.devpath %>img/ico/48.png',
                        dest: '<%= gh.devpath %>img/ico/48.<%= pkg.version %>.png',
              },
                    {
                        src: '<%= gh.devpath %>img/ico/128.png',
                        dest: '<%= gh.devpath %>img/ico/128.<%= pkg.version %>.png',
              }
              ],
            },
            yesimlocal: {
                files: [
              // makes all src relative to cwd
                    {
                        src: 'yesimlocal.php',
                        dest: '<%= gh.devpath %>yesimlocal.php',
              }
              ],
            },
            webapp: {
                files: [
              // makes all src relative to cwd
                    {
                        src: 'manifest.webapp',
                        dest: 'htdocs/manifest.webapp',
              },
                    {
                        src: 'offline.appcache',
                        dest: 'htdocs/offline.appcache',
              },
              ],
            },
        },
        /*
        ##         ## ##      ########  ######## ########  ##          ###     ######  ########
        ##         ## ##      ##     ## ##       ##     ## ##         ## ##   ##    ## ##
        ##       #########    ##     ## ##       ##     ## ##        ##   ##  ##       ##
        ##         ## ##      ########  ######   ########  ##       ##     ## ##       ######
        ##       #########    ##   ##   ##       ##        ##       ######### ##       ##
        ##         ## ##      ##    ##  ##       ##        ##       ##     ## ##    ## ##
        ########   ## ##      ##     ## ######## ##        ######## ##     ##  ######  ########
        */
        /*
        replace: {
            example: {
                src: [ 'dev/manifest.appcache' ], // source files array (supports minimatch)
                dest: 'dev/', // destination directory or file
                replacements: [ {
                        from: '"version": "\d.\d.\d"', // string replacement
                        to: '"version": "<%= pkg.version %>"'
            }
                    , {
                                        from: /(f|F)(o{2,100})/g, // regex replacement ('Fooo' to 'Mooo')
                                        to: 'M$2'
                                }, {
                                        from: 'Foo',
                                        to: function( matchedWord ) { // callback replacement
                                            return matchedWord + ' Bar';
                                        }
                                }
                    ]
            }
        }*/
    } );
    /*************************************************************************************************************************************************/
    /*************************************************************************************************************************************************/
    /*************************************************************************************************************************************************/
    /*************************************************************************************************************************************************/
    /*************************************************************************************************************************************************/
    /*************************************************************************************************************************************************/
    /*
    ########   ## ##      ##     ## ########  ######     ########    ###     ######  ##     ## ########  ######
    ##         ## ##      ###   ### ##       ##    ##       ##      ## ##   ##    ## ##     ## ##       ##    ##
    ##       #########    #### #### ##       ##             ##     ##   ##  ##       ##     ## ##       ##
    ######     ## ##      ## ### ## ######    ######        ##    ##     ## ##       ######### ######    ######
    ##       #########    ##     ## ##             ##       ##    ######### ##       ##     ## ##             ##
    ##         ## ##      ##     ## ##       ##    ##       ##    ##     ## ##    ## ##     ## ##       ##    ##
    ########   ## ##      ##     ## ########  ######        ##    ##     ##  ######  ##     ## ########  ######
    */
    // Import des modules inclus dans package.json
    require( 'load-grunt-tasks' )( grunt );
    // TESTS
    grunt.registerTask( 'test', [ 'connect:test', 'karma' ] );
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
        //grunt.task.run( [ 'curl:fonts1', 'curl:fonts2', 'curl:fonts3', 'copy:libsFonts' ] );
    } );
    // MES TACHES
    grunt.registerTask( 'reloadFonts', function( target ) {
        grunt.task.run( [ 'curl:fonts1', 'curl:fonts2', 'curl:fonts3', 'copy:libsFonts' ] );
    } );
    grunt.registerTask( 'reloadCss', function( target ) {
        grunt.task.run( [ 'less', 'autoprefixer:theme', 'autoprefixer:iconsset', 'cssmin' ] );
    } );
    grunt.registerTask( 'reloadJs', function( target ) {
        grunt.task.run( [ 'curl:ga', 'jsbeautifier', 'jshint', 'ngAnnotate', 'concat', 'uglify' ] );
    } );
    grunt.registerTask( 'reloadImg', function( target ) {
        grunt.task.run( [ 'curl:gravatar', 'clean:images', 'copy:versioningImg', 'imagemin:dynamic', 'webp:images' ] );
    } );
    grunt.registerTask( 'reloadHtml', function( target ) {
        grunt.task.run( [ 'exec', 'prettify', 'htmlhint', 'validation', 'pagespeed' ] );
    } );
    grunt.registerTask( 'responsive', function( target ) {
        grunt.task.run( [ 'clean:screenshots', 'autoshot' ] );
    } );
    ///// ETAPE DE RELEASE
    grunt.registerTask( 'release', function( target ) {
        grunt.task.run( [ 'humans_txt', 'reloadFonts', 'reloadCss', 'reloadJs', 'copy:versioningImg', 'reloadImg' /*, 'reloadHtml'*/ , 'pagespeed', 'copy:changelog', 'clean:changelog', 'changelog', 'copy:versioning', 'dev:prod' ] );
    } );
    grunt.registerTask( 'production', function( target ) {
        grunt.task.run( [ 'release' ] );
    } );
    grunt.registerTask( 'optimize', function() {
        grunt.option( 'force', true );
        grunt.task.run( [ 'newer:imagemin:uploads', 'newer:webp:uploads' ] );
    } );
    // CLEAN, COMMIT, TAG, PUSH, DEPLOY
    grunt.registerTask( 'push', function( target ) {
        grunt.log.warn( 'Preparation de l\'envoi...' );
        grunt.task.run( [ 'gitpush:originmaster', 'sshexec:deploy' ] );
    } );
    // CREER UN SERVEUR persistant avec connect et livereload
    grunt.registerTask( 'serve', function( target ) {
        grunt.task.run( [ 'connect:livereload', 'watch' ] );
    } );
    // TACHE PAR DEFAUT
    grunt.registerTask( 'default', [ 'serve' ] );
    // BODYROCK ************************
    grunt.registerTask( 'bodyRock', function( target ) {
        grunt.task.run( [ 'clean:bodyRock', 'copy:bodyRock' ] );
    } );
    // ************************
    // TACHES EN COURS D'INTEGRATION :
    grunt.registerTask( 'mochatest', function( target ) {
        grunt.task.run( [ 'phantom', 'mocha' ] );
    } );
};
