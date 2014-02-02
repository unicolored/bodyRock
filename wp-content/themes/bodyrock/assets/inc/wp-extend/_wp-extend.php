<?php

// WP EXTEND /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Chargement des fonctions qui étendent la gamme d'éléments de Wordpress.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


require_once 'br_sidebars.php';  // sidebars
add_action( 'widgets_init', 'br_register_sidebars' );

require_once 'br_widgets.php'; // widgets
add_action( 'widgets_init', 'br_register_widgets' );

require_once 'br_menus.php'; // widgets

require_once 'br_metabox.php'; // metaboxs
require_once 'br_types.php'; // custom posts types
require_once 'br_shortcodes.php'; // widgets

// BODY CLASS /////////////////////////////////////////////
// Génère les classes du body qui sont fonctions de la page
function bodyrock_body_class() {
	$term = get_queried_object();
	/*
	
	get_queried_object()
	:: Retrieve the currently-queried object. For example:
	
	if you're on a single post, it will return the post object
	if you're on a page, it will return the page object
	if you're on a category archive, it will return the category object
	if you're on an author archive, it will return the author object 
	
	*/	
	if ( is_single() ) {
		$cat = get_the_category();
	}
	
	if( !empty($cat) ) {
		return $cat[0]->slug;
	}
	elseif( isset($term->slug) ) {
		return $term->slug;
	}
	elseif( isset($term->page_name) ) {
		return $term->page_name;
	}
	elseif( isset($term->post_name) ) {
		return $term->post_name;
	}
	else {
		return;
	}
}
