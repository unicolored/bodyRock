<?php
// Thumbnail & Featured Image Support
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 280, 210, true ); // Normal post thumbnails
	add_image_size( 'screen-shot', 720, 540 ); // Full size screen
}

// Adding Some Display Functions
add_filter('excerpt_length', 'my_excerpt_length');

function my_excerpt_length($length) {

	return 25; 

}

add_filter('excerpt_more', 'new_excerpt_more');  

function new_excerpt_more($text){  

	return ' ';  

}  

function portfolio_thumbnail_url($pid){
	$image_id = get_post_thumbnail_id($pid);
	$image_url = wp_get_attachment_image_src($image_id,'screen-shot');
	return  $image_url[0];
}

function portfolio_posts_per_page( $query ) {
    if ( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'portfolio' ) $query->query_vars['posts_per_page'] = 1;
    return $query;
}
if ( !is_admin() ) add_filter( 'pre_get_posts', 'portfolio_posts_per_page' );

?>