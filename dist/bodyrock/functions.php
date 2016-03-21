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
//////////////////////////////////////////////////////////////////////////////

define('THEME_PATH', 'wp-content/themes/bodyrock/');
define('BR_PATH', ABSPATH . THEME_PATH); // Liens absolus.
define('INC_PATH', BR_PATH . 'includes/');
define('ASSETS_PATH', BR_PATH . 'assets/inc/');
//define('JS_PATH', '/' . THEME_PATH . 'assets/js/');
define('BR_CSS_PATH', BR_PATH . 'css/');

// Attention ici, pour la fonction get_template_part(), il faut utiliser des liens relatifs.
define('TPL_PATH', 'tpl/');
define('TPL_SIDEBAR_PATH', TPL_PATH . 'sidebars/');
define('TPL_BOOTSTRAP_PATH', TPL_PATH . 'bootstrap/');
define('TPL_SINGULAR_PATH', TPL_PATH . 'singular/');


////// WALKERS /////////////////////////////////////////////
////// Chargement des différents walkers personnalisés
/*
Un 'walker' parcoure les éléments du menu et permet de personnaliser la sortie Html.
Les différents walkers ci-dessous servent à reproduire les composants Bootstrap.
*/
// FIXME : temporairement désactivés 12/11/2015
require_once(ASSETS_PATH.'wp-extend/walkers/navbar_walker.php');
//require_once(INC_PATH.'wp-extend/walkers/listgroup_walker.php');
//require_once(INC_PATH.'wp-extend/walkers/listgroupCat_walker.php');
//require_once(INC_PATH.'wp-extend/walkers/listgroupPage_walker.php');
//require_once(INC_PATH.'wp-extend/walkers/listgroupcustom_walker.php');
//require_once(INC_PATH.'wp-extend/walkers/navpills_walker.php');
//require_once(INC_PATH.'wp-extend/walkers/tabs_walker.php');

////// METABOX /////////////////////////////////////////////
// TODO : revoir l'utilisation des metabox !!!
//require_once INC_PATH.'wp-extend/br_metabox.php'; // metaboxs

////// _TMP /////////////////////////////////////////////
//require_once 'br_types.php'; // custom posts types
//require_once 'br_shortcodes.php'; // widgets
//require_once 'plugins/nextpost_plus.php'; // widgets

/*
##         ## ##      ########  ######## ########  ##     ##  ######
##         ## ##      ##     ## ##       ##     ## ##     ## ##    ##
##       #########    ##     ## ##       ##     ## ##     ## ##
##         ## ##      ##     ## ######   ########  ##     ## ##   ####
##       #########    ##     ## ##       ##     ## ##     ## ##    ##
##         ## ##      ##     ## ##       ##     ## ##     ## ##    ##
########   ## ##      ########  ######## ########   #######   ######
*/
// VARDUMP /////////////////////////////////////////////
// Fait un affichage propre de var_dump()
function vardump($v) {
	echo '<pre>';
	if(is_array($v) || is_object($v)) {
		var_dump($v);
	}
	else {
		var_dump(htmlentities($v));
	}
	echo '</pre>';
}

function Debug($var,$text=false) {
  if (is_array($var)) {
    print '<pre class="debug" style="background:#fff; color:#000; padding:1em; font-size:14px;">';
    print $text != false ? '<strong>'.$text.'</strong><br>' : false;
    print_r($var);
    print '</pre>';
  }
  else {
    vardump($var);
  }
}
// DEPRECATED /////////////////////////////////////////////
// Renvoie un avertiseement concernant les fonctions périmées
function deprecated($oldfunction,$newfunction) {
	if (current_user_can('list-users')) {
		echo '<pre> • <strong>AVERTISSEMENT</strong> <strong>Fonction dépréciée</strong> Remplacer <em>'.$oldfunction.'</em> par <em>'.$newfunction.'</em></pre>';
	}
}
function list_thumbnail_sizes() {
	// Liste les tailles d'images personnalisées des thèmes parent et enfant
	global $_wp_additional_image_sizes;
 	$sizes = array();
	foreach( get_intermediate_image_sizes() as $s ) {
		$sizes[ $s ] = array( 0, 0 );
		if( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) ) {
			$sizes[ $s ][0] = get_option( $s . '_size_w' );
			$sizes[ $s ][1] = get_option( $s . '_size_h' );
		}
		else {
			if( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $s ] ) ) {
				$sizes[ $s ] = array( $_wp_additional_image_sizes[ $s ]['width'], $_wp_additional_image_sizes[ $s ]['height'], );
			}
		}
	}

 	foreach( $sizes as $size => $atts ) {
 		echo $size . ' ' . implode( 'x', $atts ) . "<br>";
 	}
}
/*
// IMG /////////////////////////////////////////////
// Retourne une image placeholder de dimensions égales aux configurations de wordpress : thumbnail, medium, large
function img($thumbnail="large",$class="img-rounded img-responsive") {
	if (is_int($thumbnail)) {
		return false;
	}
	foreach( get_intermediate_image_sizes() as $s ){
		$sizes[ $s ] = array( 0, 0 );
		if( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) ){
			$sizes[ $s ][0] = get_option( $s . '_size_w' );
			$sizes[ $s ][1] = get_option( $s . '_size_h' );
		}else{
			if( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $s ] ) )
				$sizes[ $s ] = array( $_wp_additional_image_sizes[ $s ]['width'], $_wp_additional_image_sizes[ $s ]['height'], );
		}
	}
	return "<img src='http://placehold.it/".$sizes[$thumbnail][0]."x".$sizes[$thumbnail][1]."' class='".$class."' width='".$sizes[$thumbnail][0]."' height='".$sizes[$thumbnail][1]."' alt='Image'>";
}
*/
/*
##         ## ##       ######   ######## ######## ####  ######   #######  ##    ##
##         ## ##      ##    ##  ##          ##     ##  ##    ## ##     ## ###   ##
##       #########    ##        ##          ##     ##  ##       ##     ## ####  ##
##         ## ##      ##   #### ######      ##     ##  ##       ##     ## ## ## ##
##       #########    ##    ##  ##          ##     ##  ##       ##     ## ##  ####
##         ## ##      ##    ##  ##          ##     ##  ##    ## ##     ## ##   ###
########   ## ##       ######   ########    ##    ####  ######   #######  ##    ##
*/
// GET ICON /////////////////////////////////////////////
// Affiche l'icône choisie en fonction de la police (Glyphicons, Font-Awesome, Elusive)
if(!function_exists('br_getIcon')) { // Permet l'override par le thème child
	function br_getIcon($id = false) {
		switch(BR_ICONSET) {
			default :
				return "<span class='glyphicon glyphicon-".br_getPageIcon($id)."'></span>";
			break;
			case 'fontawesome' :
				return "<i class='fa fa-".br_getPageIcon($id)."'></i>";
			break;
			case 'linearicons';
				return "<span class='lnr lnr-".br_getPageIcon($id)."'></span>";
			break;
			case 'octicons';
				return "<span class='octicon octicon-".br_getPageIcon($id)."'></span>";
			break;
		}
	}
}
function br_Icon($id = false) { echo br_getIcon($id); }

/*
##         ## ##      ######## #### ##     ## ########         ########     ###     ######   ######  ######## ########
##         ## ##         ##     ##  ###   ### ##               ##     ##   ## ##   ##    ## ##    ## ##       ##     ##
##       #########       ##     ##  #### #### ##               ##     ##  ##   ##  ##       ##       ##       ##     ##
##         ## ##         ##     ##  ## ### ## ######           ########  ##     ##  ######   ######  ######   ##     ##
##       #########       ##     ##  ##     ## ##               ##        #########       ##       ## ##       ##     ##
##         ## ##         ##     ##  ##     ## ##               ##        ##     ## ##    ## ##    ## ##       ##     ##
########   ## ##         ##    #### ##     ## ######## ####### ##        ##     ##  ######   ######  ######## ########
*/
// Retourne la date sous la forme "il&nbsp;y&nbsp;a&nbsp;... ans, ... mois, ... jours, ec..."
function time_passed($timestamp){
    //type cast, current time, difference in timestamps
    $timestamp      = (int) $timestamp;
    $current_time   = time();
    $diff           = $current_time - $timestamp;

    //intervals in seconds
    $intervals      = array (
        'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
    );

    //now we just find the difference
    if ($diff == 0)
    {
        return 'à l\'instant';
    }

    if ($diff < 60)
    {
        return $diff == 1 ? 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;seconde' : 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;secondes';
    }

    if ($diff >= 60 && $diff < $intervals['hour'])
    {
        $diff = floor($diff/$intervals['minute']);
        return $diff == 1 ? 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;minute' : 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;minutes';
    }

    if ($diff >= $intervals['hour'] && $diff < $intervals['day'])
    {
        $diff = floor($diff/$intervals['hour']);
        return $diff == 1 ? 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;heure' : 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;heures';
    }

    if ($diff >= $intervals['day'] && $diff < $intervals['week'])
    {
        $diff = floor($diff/$intervals['day']);
        return $diff == 1 ? 'hier' : 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;jours';
    }

    if ($diff >= $intervals['week'] && $diff < $intervals['month'])
    {
        $diff = floor($diff/$intervals['week']);
        return $diff == 1 ? 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;semaine' : 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;semaines';
    }

    if ($diff >= $intervals['month'] && $diff < $intervals['year'])
    {
        $diff = floor($diff/$intervals['month']);
        return $diff == 1 ? 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;mois' : 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;mois';
    }

    if ($diff >= $intervals['year'])
    {
        $diff = floor($diff/$intervals['year']);
        return $diff == 1 ? 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;an' : 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;ans';
    }
}
/*
##         ## ##      ##        #######     ###    ########
##         ## ##      ##       ##     ##   ## ##   ##     ##
##       #########    ##       ##     ##  ##   ##  ##     ##
##         ## ##      ##       ##     ## ##     ## ##     ##
##       #########    ##       ##     ## ######### ##     ##
##         ## ##      ##       ##     ## ##     ## ##     ##
########   ## ##      ########  #######  ##     ## ########
*/

// LOAD PHP /////////////////////////////////////////////
//require 'includes/__debug.php';
//require 'includes/functions__deprecated.php';
// Inclusions des extensions de fonctionnalités
// TODO : remettre dans un même dossier, simplifier les includes
require_once INC_PATH . 'br_themeoptions.php'; // Les options du thème accessibles via Wordpress.
//require_once INC_PATH . 'br_icones.php'; // Génération d'éléments relatifs aux icônes
//require_once INC_PATH . 'br_images.php'; // Tout ce qui concerne les paramètres liés aux images.
//require_once INC_PATH . 'br_textes.php'; // Tout ce qui concerne les paramètres liés aux textes.

require 'includes/functions__hook.php';
require 'includes/functions__hook_custom.php';
require 'includes/functions_customize.php';
require 'includes/functions_extend.php';
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if(is_plugin_active('woocommerce/woocommerce.php')) {
  require 'includes/functions_woocommerce.php';
}
?>
