<?php
/* GESTION DES LANGUES */
add_action('after_setup_theme', 'br_load_languages');
function br_load_languages(){
	load_theme_textdomain('bodyrock', get_stylesheet_directory().'/languages');
}

/* br_function OVERRIDE */
function br_getPageIcon($id = false) {
	/* Récupérer l'icône d'une page d'après un identifiant texte. */
	// Actuellement si l'identifiant est un chiffre, la fonction retourne l'icone 'align-left'
	
	$ICONES[$id] = $id; // Par défaut, l'icône appellé est chargé sans traduction

	/*ICONS*/
	/*FORMATS*/	
	/*CATEGORIES*/
	/*PAGES*/
	
	if($id != false) {
		if(is_int($id)) {
			$icon = 'align-left';	
		}
		else {
			$icon = $ICONES[$id];
		}
	}
	else $icon = $id;
	
	return $icon;
}


?>