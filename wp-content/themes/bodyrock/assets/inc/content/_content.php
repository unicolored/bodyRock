<?php

// CONTENT /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Tout ce qui concerne l'inclusion de contenus.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


require_once 'bootstrap.php';  		// Tout ce qui concerne les paramètres liés aux sons.
require_once 'bodyrock.php';  		// Tout ce qui concerne les paramètres liés aux sons.

require_once 'audio.php';  		// Tout ce qui concerne les paramètres liés aux sons.
require_once 'images.php'; 			// Tout ce qui concerne les paramètres liés aux images.
require_once 'textes.php';  		// Tout ce qui concerne les paramètres liés aux textes.

// Gestion de l'affichage de plus d'articles en Ajax
function pbd_alp_init() {
	global $wp_query;

	// Add code to index pages.
	if( !is_singular() ) { 		
	    wp_enqueue_script( 'script-ajax-load-posts', JS_PATH.'ajax-load-posts.js', array('jquery'), 'fev14' );
	
		// What page are we on? And what is the pages limit?
		$max = $wp_query->max_num_pages;
		$paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
		
		// Add some parameters for the JS.
		wp_localize_script(
		'script-ajax-load-posts',
		'pbd_alp',
		array(
		'startPage' => $paged,
		'maxPages' => $max,
		'nextLink' => next_posts($max, false)
		)
		);
	}
}
?>