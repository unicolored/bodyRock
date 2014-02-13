<?php

// functions.php /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Le fichier de fonctions de Wordpress.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/

/*

Toutes les fonctions PHP de Bodyrock sont liées à ce fichier.
La référence des noms commence au dossier assets/inc/.

Un nom de fonction peut comporter des lettres, des chiffres et les caractères _ et & (les espaces ne sont pas autorisés).
Le nom de la fonction, comme celui des variables est sensible à la casse (différenciation entre les minuscules et majuscules).

Si une fonction doit changer de nom, on doit conserver l'ancienne fonction appellant la nouvelle.

Les fonctions sont rangées par ordre alphabétique par sections par fichiers, dès que possible avec une priorité sur les fonctions br_

Nomenclature des fonctions :
----------------------------
prefix ::
br_ : Optionnel :devant la fonction lorsqu'elle peut être appelé depuis vos templates ou des thèmes enfants.
sousdossier_ :: nom du sous-dossier
nomdufichier : nom du fichier php qui héberge la fonction (ne s'applique pas aux fonctions déclarées dans functions.php).

Method ::
init : initialisation de composant
get : récupération de valeur (et affichage)
set : définit (et enregistrer une valeur) etc...

_suffix ::
_* : spécificité dela fonction
----------------------------
exemples :
br_nomdufichierMethod() : destinée à être appellée depuis les templates, elle se trouve dans le fichier assets/inc/nomdufichier.php
themeoptionsInit() se trouve dans le fichier (assets/inc/)themes-options.php
br_themeoptionsGet_default() se trouve dans le fichier (assets/inc/)themes-options.php, elle récupère les options par défaut.

*/

add_image_size( 'article', 960, 320, 1 );
add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
add_action('wp_footer', 'getImgVideo', 100);

// Retire une partie des variables disqus non utiles à mon avis.
// Evite notamment l'inclusion de code sur les pages qui ne comportent pas de commentaires.
remove_action('wp_footer', 'dsq_output_footer_comment_js');

define( 'THEME_PATH' , 'wp-content/themes/bodyrock/' ); // Liens absolus.
define( 'BR_PATH' , ABSPATH.THEME_PATH ); // Liens absolus.
define( 'ASSETS_PATH' , BR_PATH.'assets/' );
define( 'INC_PATH' , ASSETS_PATH.'inc/' );
define( 'LESS_PATH' , ASSETS_PATH.'less/' );
define( 'JS_PATH' , '/'.THEME_PATH.'assets/js/' );

define( 'BR_CSS_PATH' , BR_PATH.'css/' );

// Attention ici, pour la fonction get_template_part(), il faut utiliser des liens relatifs.
define( 'TPL_PATH' , 'assets/tpl/' );
define( 'TPL_SIDEBAR_PATH' , TPL_PATH.'sidebars/' );
define( 'TPL_BOOTSTRAP_PATH' , TPL_PATH.'bootstrap/' );
define( 'TPL_SINGULAR_PATH' , TPL_PATH.'singular/' );


// LOAD PHP /////////////////////////////////////////////
// Inclusions des extensions de fonctionnalités
//require_once INC_PATH.'_tmp/beta.php';  			// Fonctions betas, en développement.

require_once INC_PATH.'customize.php';  			// Personnalisation de Wordpress.
require_once INC_PATH.'themeoptions.php';			// Les options du thème accessibles via Wordpress.
require_once INC_PATH.'br_interface.php';			// Génération d'éléments Html utiles au thème.

require_once INC_PATH.'backend/_backend.php';		// Chargement des fonctions en arrière plan.
require_once INC_PATH.'content/_content.php'; 		// Tout ce qui concerne l'inclusion de contenus.
require_once INC_PATH.'modules/_modules.php'; 		// Tout ce qui concerne l'inclusion de contenus.
require_once 'assets/inc/wp-extend/_wp-extend.php';	// Chargement des fonctions qui étendent la gamme d'éléments de Wordpress.


// DEFINE /////////////////////////////////////////////
// Assignation des options du thème à des constantes.
// Les options sont converties en constantes pour être accessible dans tout le code.
$options = get_option('brthemeoptions', themeoptionsGet_default());

define('BR_ICON_SET',$options['iconset']); // Sélection du set d'icône parmis Glyphicon, Font-Awesome, Elusive, etc...
define('BR_COMPILELESS_ON',$options['compileless_on']); // Active la compilation .less en .css (utile si les .less ont été modifiés)
define('BR_VIDEO_AUTOPLAY',$options['video_autoplay']); // Active l'autoplay des vidéos sur les pages single
define('BR_VIDEO_HEIGHT',$options['video_height']); // La hauteur de l'iframe contenant le lecteur vidéo
define('BR_NORESPONSIVE',$options['noresponsive']); // Desactiver le "responsive"
define('BR_AUDIO_HEIGHT',$options['audio_height']); // La hauteur de l'iframe contenant le lecteur audio

// AUTRES VARIABLES (A mettre en option) ///////////////////////////////////////////// BODYROCK
// Récupération des options du thème BODYROCK
define('CDN_PATH','http://senzu.fr/'.strtolower(get_bloginfo('name')).'/'); // Chemin d'accès au CDN.


// BODYROCK /////////////////////////////////////////////
// Création des liens CSS et JS
// Register style sheet.

add_action( 'wp_enqueue_scripts', 'head_scripts' );
add_action( 'wp_footer', 'footer_scripts' );

function head_scripts() {
	switch ( BR_ICON_SET ) {
		case 'elusive': 	wp_enqueue_style( 'icon_set-elusive', get_template_directory_uri() . '/assets/icon_set/elusive-webfont.css', array(), '2.0.0', false  ); break;
//		case 'font-awesome': wp_enqueue_style( 'icon_set-fontawesome', get_template_directory_uri().'/assets/icon_set/font-awesome.min.css', array(), '4.0.3', false  ); break;
		case 'font-awesome': wp_enqueue_style( 'icon_set-fontawesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css', array(), '4.0.3', false  ); break;
		case 'glyphicon': wp_enqueue_style( 'icon_set-glyphicon', get_template_directory_uri() . '/assets/icon_set/glyphicons.css', array(), '1.0.0', false  ); break;
	}

    if(!is_child_theme()) {
//		wp_enqueue_style( 'bs', 				"//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css", false, 'fev14', false  );
//        wp_enqueue_style( 'bs-slate', 			"//netdna.bootstrapcdn.com/bootswatch/3.1.0/slate/bootstrap.min.css", array('bs'), 'fev14', false  );
        wp_enqueue_style( 'style', 				get_template_directory_uri() . '/css/style.css', false, '1.0.0', false  );
    }
	else {
		// CHILD /////////////////////////////////////////////
		wp_enqueue_style( 'style-child',    	get_stylesheet_directory_uri().'/css/style.css', false, '1.0.0', false );
	}
}

function footer_scripts() {

    wp_enqueue_script( 'script', 				get_template_directory_uri().'/js/script.php', array('jquery'), '1.0.0', false  );
	
	global $options;

	$FG = explode(';',$options['fonts_google']);
	$i=0;
	$families = '';
	foreach ($FG as $F) {
		$families .= ($i>0 ? ', ' : false)."'".$F."'";
		$i++;
	}
	
	// Add some parameters for the JS.
	wp_localize_script(
	'script',
	'sc_val',
		array(
			'families' => json_encode($families)
		)
	);
}

if( BR_COMPILELESS_ON == 1 ) { // Via les options du thème, on vérifie que la compilation du fichier less est activée.
	backend_filesWrite_less(LESS_PATH.'editor-style.less', BR_CSS_PATH.'editor-style.css');
	backend_filesWrite_less(LESS_PATH.'style.less', BR_CSS_PATH.'style.css');
	backend_filesWrite_less(LESS_PATH.'debug.less', BR_CSS_PATH.'debug.css');
	backend_filesWrite_less(LESS_PATH.'video-js.less', ASSETS_PATH.'js/libs/video-js/video-js.css');
	// Compilation du fichier less si l'option est activée
	if( is_child_theme() ) {
		backend_filesWrite_less(get_stylesheet_directory().'/assets/less/style.less', get_stylesheet_directory().'/css/style.css');
	}
}
?>