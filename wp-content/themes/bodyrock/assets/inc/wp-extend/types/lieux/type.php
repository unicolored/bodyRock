<?php
if ( ! function_exists('custom_lieux') ) {

// Register Custom Post Type
function custom_lieux() {

	$labels = array(
		'name'                => _x( 'Lieux', 'Post Type General Name', 'bodyrock' ),
		'singular_name'       => _x( 'Lieu', 'Post Type Singular Name', 'bodyrock' ),
		'menu_name'           => __( 'Lieux', 'bodyrock' ),
		'parent_item_colon'   => __( 'Lieu parent :', 'bodyrock' ),
		'all_items'           => __( 'Tous', 'bodyrock' ),
		'view_item'           => __( 'Afficher le lieu', 'bodyrock' ),
		'add_new_item'        => __( 'Ajouter un lieu', 'bodyrock' ),
		'add_new'             => __( 'Ajouter un nouveau', 'bodyrock' ),
		'edit_item'           => __( 'Editer', 'bodyrock' ),
		'update_item'         => __( 'Mettre à jour', 'bodyrock' ),
		'search_items'        => __( 'Rechercher un lieu', 'bodyrock' ),
		'not_found'           => __( 'Aucun lieu trouvé.', 'bodyrock' ),
		'not_found_in_trash'  => __( 'Aucun lieu dans la corbeille.', 'bodyrock' ),
	);
	$args = array(
		'label'               => __( 'lieux', 'bodyrock' ),
		'description'         => __( 'Restaurants, Bars, Musées, Théâtres, ...', 'bodyrock' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', ),
		'taxonomies'          => array( 'lieu-type', 'lieu-cat', 'lieu-tag' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 8,
		'menu_icon'           => 'map',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'query_var'           => '',
		'capability_type'     => 'page',
	);
	register_post_type( 'lieux', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_lieux', 0 );

}
?>