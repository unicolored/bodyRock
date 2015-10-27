<?php

// THEME OPTIONS /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Les options du thème accessibles via Wordpress.
// wp-admin/themes.php?page=theme_options
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


require_once('themeoptions/backoffice.php');
add_action('admin_init', 'themeoptions_backofficeRegister');
add_action('admin_menu', 'themeoptions_backofficeAdd_page');

add_action('admin_enqueue_scripts', 'themeoptions_backofficeEnqueue_scripts'); // Ajout des liens CSS et JS de la page d'administration.
add_action('wp_before_admin_bar_render', 'themeoptions_backofficeBar_render'); // Ajout d'un lien dans la barre d'administration de Wordpress.

add_filter('option_page_capability_bodyrock_options', 'themeoptions_backofficeCapability'); // Gestion des droits d'accès à la page.


if ( is_admin() ) : // Load only if we are viewing an admin page
	// Rendu de la page Options du thème dans l'administration de Wordpress.
	require 'themeoptions/view.php';
	// Validation des données à l'enregistrement des données.
	require 'themeoptions/validation.php';
endif;  // EndIf is_admin()


// GET /////////////////////////////////////////////
// Retourne les options actives
function br_themeoptionsGet($check_option=false) { // bodyrock_get_theme_options

	if($check_option!=false) {

		$options=get_option('brthemeoptions', themeoptionsGet_default());
		return (isset($options[$check_option]) ? $options[$check_option] : 'Option non existante.');

	}
	else return get_option('brthemeoptions', themeoptionsGet_default());

}

// GET DEFAULT /////////////////////////////////////////////
// Récupère les valeurs par défaut des options
function themeoptionsGet_default()
{
	$default = array(
		'iconset'  			=> '',
		'allbsjs'  			=> 1,
		'image_sizes' 		=> '',
		'fonts_google'		=> '',
		'googleanalyticsid'     => false
	);

	return apply_filters('brthemeoptions', $default);
}

// DEFINE /////////////////////////////////////////////
// Assignation des options du thème à des constantes.
// Les options sont converties en constantes pour être accessible dans tout le code.
$options = br_themeoptionsGet();
// Sélection du set d'icône parmis Glyphicon, Font-Awesome, Elusive, etc...
define('BR_ICON_SET', $options['iconset']);
// Fonts chargées par Google
define('BR_FONTS', $options['fonts_google']);
// Active la compilation .less en .css (utile si les .less ont été modifiés)
// Charge tous les scripts .js de bootstrap
define('BR_ALLBSJS', $options['allbsjs']);
// Charge les ailles des images - sous la forme : nomdelataille,width,height; nomdelataille2,width2,height2; ...
define('BR_IMAGE_SIZES', $options['image_sizes']);
// L'identifiant du compte Anakytics
if(isset($options['google_analytics_id'])) {
  define('BR_GOOGLE_ANALYTICS', $options['google_analytics_id']);
}
?>
