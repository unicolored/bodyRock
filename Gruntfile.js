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
    // loads the various task configuration files from the config/ directory
    var configs = require( 'load-grunt-configs' )( grunt );
    grunt.initConfig( configs );
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
            - suppression du manifest.xml et du .appcache dans /dist/
            */
                grunt.task.run( [ 'copy:yesimlocal', 'clean:webapp' ] );
            break;
            case 'prod':
                /*
                Préparation du mode production
                - suppression du fichier imlocal.php dans /dev/
                - copie des fichiers manifest.xml et .appcache dans /dist/
                */
                    grunt.task.run( [ 'clean:yesimlocal', 'copy:webapp' ] );
                break;
        }
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
        grunt.task.run( [ 'clean:images', 'copy:versioningImg', 'imagemin:dynamic', 'webp:images' ] );
    } );
    grunt.registerTask( 'reloadHtml', function( target ) {
        grunt.task.run( [ 'exec', 'prettify', 'htmlhint', 'validation', 'pagespeed' ] );
    } );
    grunt.registerTask( 'responsive', function( target ) {
        grunt.task.run( [ 'clean:screenshots', 'autoshot' ] );
    } );
    ///// ETAPE DE RELEASE
    grunt.registerTask( 'release', function( target ) {
        grunt.task.run( [ 'humans_txt', 'reloadFonts', 'reloadCss', 'reloadJs', 'copy:versioningImg', 'reloadImg', 'pagespeed', 'copy:changelog', 'clean:changelog', 'changelog', 'copy:versioning', 'dev:prod' ] );
    } );
    grunt.registerTask( 'production', function( target ) {
        grunt.task.run( [ 'release' ] );
    } );
    // CLEAN, COMMIT, TAG, PUSH, DEPLOY
    grunt.registerTask( 'push', function( target ) {
        grunt.log.warn( 'Preparation de l\'envoi...' );
        grunt.task.run( [ 'gitpush:originmaster' ] );
    } );
    // CREER UN SERVEUR persistant avec connect et livereload
    grunt.registerTask( 'serve', function( target ) {
        grunt.task.run( [ 'connect:livereload', 'watch' ] );
    } );
    // TACHE PAR DEFAUT
    grunt.registerTask( 'default', [ 'serve' ] );
};
