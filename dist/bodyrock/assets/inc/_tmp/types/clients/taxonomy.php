<?php
/* ALERTE : register_taxonomy devraient être dans un plugin et non dans le thème Bodyrock */
// Register Custom Taxonomy
/*
function client_type() {

	$labels = array(
		'name'                       => _x( 'Genres', 'Taxonomy General Name', 'bodyrock' ),
		'singular_name'              => _x( 'Genre', 'Taxonomy Singular Name', 'bodyrock' ),
		'menu_name'                  => __( 'Genres', 'bodyrock' ),
		'all_items'                  => __( 'Tous', 'bodyrock' ),
		'parent_item'                => __( 'Genre parent', 'bodyrock' ),
		'parent_item_colon'          => __( 'Genre parent', 'bodyrock' ),
		'new_item_name'              => __( 'Nouveau genre', 'bodyrock' ),
		'add_new_item'               => __( 'Ajouter un genre', 'bodyrock' ),
		'edit_item'                  => __( 'Editer', 'bodyrock' ),
		'update_item'                => __( 'Mettre à jour', 'bodyrock' ),
		'separate_items_with_commas' => __( 'Séparer avec des virgules', 'bodyrock' ),
		'search_items'               => __( 'Rechercher', 'bodyrock' ),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer', 'bodyrock' ),
		'choose_from_most_used'      => __( 'Choisir parmis les plus utilisés', 'bodyrock' ),
		'not_found'                  => __( 'Aucun résultat.', 'bodyrock' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'client-type', 'clients', $args );

}
*/

// Hook into the 'init' action
//add_action( 'init', 'client_type', 0 );


// Register Custom Taxonomy
/*
function client_cat() {

	$labels = array(
		'name'                       => _x( 'Catégories', 'Taxonomy General Name', 'bodyrock' ),
		'singular_name'              => _x( 'Catégorie', 'Taxonomy Singular Name', 'bodyrock' ),
		'menu_name'                  => __( 'Catégories', 'bodyrock' ),
		'all_items'                  => __( 'Toutes', 'bodyrock' ),
		'parent_item'                => __( 'Catégorie parente', 'bodyrock' ),
		'parent_item_colon'          => __( 'Catégorie parente', 'bodyrock' ),
		'new_item_name'              => __( 'Nouvelle catégorie', 'bodyrock' ),
		'add_new_item'               => __( 'Ajouter une catégorie', 'bodyrock' ),
		'edit_item'                  => __( 'Editer', 'bodyrock' ),
		'update_item'                => __( 'Mettre à jour', 'bodyrock' ),
		'separate_items_with_commas' => __( 'Séparer avec des virgules', 'bodyrock' ),
		'search_items'               => __( 'Rechercher', 'bodyrock' ),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer', 'bodyrock' ),
		'choose_from_most_used'      => __( 'Choisir parmis les plus utilisées', 'bodyrock' ),
		'not_found'                  => __( 'Aucun résultat.', 'bodyrock' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'client-cat', 'clients', $args );

}*/

// Hook into the 'init' action
//add_action( 'init', 'client_cat', 0 );


// Register Custom Taxonomy
/*
function client_tag() {

	$labels = array(
		'name'                       => _x( 'Tags', 'Taxonomy General Name', 'bodyrock' ),
		'singular_name'              => _x( 'Tag', 'Taxonomy Singular Name', 'bodyrock' ),
		'menu_name'                  => __( 'Tags', 'bodyrock' ),
		'all_items'                  => __( 'Tous', 'bodyrock' ),
		'parent_item'                => __( 'Tag parent', 'bodyrock' ),
		'parent_item_colon'          => __( 'Tag parent', 'bodyrock' ),
		'new_item_name'              => __( 'Nouveau tag', 'bodyrock' ),
		'add_new_item'               => __( 'Ajouter un tag', 'bodyrock' ),
		'edit_item'                  => __( 'Editer', 'bodyrock' ),
		'update_item'                => __( 'Mettre à jour', 'bodyrock' ),
		'separate_items_with_commas' => __( 'Séparer avec des virgules', 'bodyrock' ),
		'search_items'               => __( 'Rechercher', 'bodyrock' ),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer', 'bodyrock' ),
		'choose_from_most_used'      => __( 'Choisir parmis les plus utilisés', 'bodyrock' ),
		'not_found'                  => __( 'Aucun résultat.', 'bodyrock' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'client-tag', 'clients', $args );

}

// Hook into the 'init' action
add_action( 'init', 'client_tag', 0 );*/
?>
