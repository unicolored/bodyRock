<?php



function br_register_sidebars() {    
    
	register_sidebar( array(
		'name' => __( 'Sidebar Left', 'bodyrock' ),
		'id' => 'sidebar-left',
		'before_widget' => '<aside class="widget %2$s" id="%1$s"><div class="galaxie">',
		'after_widget' => "</div></aside>",
		'before_title' => '<h1>',
		'after_title' => '</h1>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Sidebar Right', 'bodyrock' ),
		'id' => 'sidebar-right',
		'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="galaxie">',
		'after_widget' => "</div></aside>",
		'before_title' => '<h1>',
		'after_title' => '</h1>',
	) );
	
}

?>