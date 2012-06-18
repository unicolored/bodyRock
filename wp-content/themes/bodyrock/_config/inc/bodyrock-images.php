<?php
	
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image', 'audio', 'video' ) );
	add_theme_support( 'post-thumbnails' );
	
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( 930, 430, true );
	//add_image_size( 'large-feature', 930, 430, true );
	add_image_size( 'small-feature', 465, 215 );

?>