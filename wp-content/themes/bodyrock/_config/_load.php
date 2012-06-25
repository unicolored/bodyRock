<?php
require_once 'less/lessc035.inc.php';  // LESSCPHP

/*-----------------------------------------------------------------------------------------*/
/*Base on theme SKELETON*/

require_once 'inc/bodyrock-basics.php';  // basics
// Personnaliser l'administration du wordpress

require_once 'inc/bodyrock-options.php';     // theme options
// Ajoute des options d'administration au thème

require_once 'inc/bodyrock-cleanup.php';     // cleanup
// Quelques filtres de nettoyage des textes par défaut

require_once 'inc/bodyrock-activation.php';  // activation
// Déclenche les actions automatiques à l'activation du thème

require_once 'inc/bodyrock-htaccess.php';    // rewrites for assets, h5bp htaccess
// Génère le htaccess

require_once 'inc/bodyrock-images.php';  // images
// Configuration et ajout de tailles de thumbnails
require_once 'inc/bodyrock-textes.php';  // textes
// Ajoute des modifications aux articles

require_once 'inc/bodyrock-sidebars.php';  // sidebars
// Permet d'enregistrer des sidebars de widgets supplémentaires

require_once 'inc/bodyrock-widgets.php';     // widgets
// Répertorie les widgets persos à charger

require_once 'inc/bodyrock-menus.php';     // widgets
// Créer les menus persos à charger

require_once 'inc/bodyrock-hooks.php';     // hooks
require_once 'inc/bodyrock-actions.php';     // actions

//require_once 'inc/shortcodes/more.php';     // shortcodes // inutile
require_once 'inc/shortcodes/videos_embedded.php';     // shortcodes

/*-----------------------------------------------------------------------------------------*/
/* Types custom posts à activer */
if($custom_types_to_activate) :
	global $custom_types_to_activate;
	$i=0;
	foreach($custom_types_to_activate as $key=>$val) {
		require_once('inc/types/'.$val.'/main.php'); 
		$i++;
	}
	if($i>0) require_once('inc/types/taxonomies.php');
endif;

/*-----------------------------------------------------------------------------------------*/
/* Fonction globale pour timthumb */
function get_image_path ($post_id = null) {
	if ($post_id == null) {
		global $post;
		$post_id = $post->ID;
	}
	$theImageSrc = get_post_meta($post_id, 'Image', true);
	global $blog_id;
	if (isset($blog_id) && $blog_id > 0) {
		$theImageSrc = theImgSrc($blog_id,$theImageSrc);
	}
	return $theImageSrc;
}
function theImgSrc($blog_id,$src) {
	$imageParts = explode('/files/', $src);
	if (isset($imageParts[1])) {
		$src = '/wp-content/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
	}
	return $src;
}
/*-----------------------------------------------------------------------------------------*/
?>