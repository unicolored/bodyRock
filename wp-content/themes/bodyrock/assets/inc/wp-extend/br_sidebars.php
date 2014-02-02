<?php



function br_register_sidebars() {    
    
	register_sidebar( array(
		'name' => __( 'Sidebar Left', 'bodyrock' ),
		'id' => 'sidebar-left',
		'before_widget' => '<section class="widget %2$s" id="%1$s">',
		'after_widget' => "</section>",
		'before_title' => '<h1 class="title">',
		'after_title' => '</h1>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Sidebar Right', 'bodyrock' ),
		'id' => 'sidebar-right',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => "</section>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
}

?>