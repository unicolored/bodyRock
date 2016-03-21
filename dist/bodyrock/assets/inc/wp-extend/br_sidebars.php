<?php
// Ajout de sidebars pour l'insertion des widgets

function br_register_sidebars() {

	register_sidebar( array(
		'name' => __( 'Dummy', 'bodyrock' ),
		'id' => 'Dummy',
		'before_widget' => '<aside class="hidden">',
		'after_widget' => "</aside>",
		'before_title' => '',
		'after_title' => '',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar Left', 'bodyrock' ),
		'id' => 'sidebar-left',
		'before_widget' => '<section class="widget %2$s" id="%1$s">',
		'after_widget' => "</section>",
		'before_title' => '<h1>',
		'after_title' => '</h1>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar Right', 'bodyrock' ),
		'id' => 'sidebar-right',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => "</section>",
		'before_title' => '<h1>',
		'after_title' => '</h1>',
	) );

}

?>
