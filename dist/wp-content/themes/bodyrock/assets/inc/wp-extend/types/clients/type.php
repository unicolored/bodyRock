<?php
if ( ! function_exists('custom_clients') ) {

// Register Custom Post Type
function custom_clients() {

	$labels = array(
		'name'                => _x( 'Clients', 'Post Type General Name', 'bodyrock' ),
		'singular_name'       => _x( 'Client', 'Post Type Singular Name', 'bodyrock' ),
		'menu_name'           => __( 'Clients', 'bodyrock' ),
		'parent_item_colon'   => __( 'Client parent :', 'bodyrock' ),
		'all_items'           => __( 'Tous', 'bodyrock' ),
		'view_item'           => __( 'Afficher l\'client', 'bodyrock' ),
		'add_new_item'        => __( 'Ajouter un client', 'bodyrock' ),
		'add_new'             => __( 'Ajouter un nouveau', 'bodyrock' ),
		'edit_item'           => __( 'Editer', 'bodyrock' ),
		'update_item'         => __( 'Mettre à jour', 'bodyrock' ),
		'search_items'        => __( 'Rechercher un client', 'bodyrock' ),
		'not_found'           => __( 'Aucun client trouvé.', 'bodyrock' ),
		'not_found_in_trash'  => __( 'Aucun client dans la corbeille.', 'bodyrock' ),
	);
	$args = array(
		'label'               => __( 'clients', 'bodyrock' ),
		'description'         => __( 'Date, concert, spectacle, sortie, ...', 'bodyrock' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', ),
		'taxonomies'          => array( 'client-type', 'client-cat', 'client-tag' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'query_var'           => 'client',
		'capability_type'     => 'page',
	);
	register_post_type( 'clients', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_clients', 0 );

}
?>