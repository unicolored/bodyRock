<?php

// excerpt cleanup
function bodyrock_excerpt_length($length) {
  return 40;
}

function bodyrock_excerpt_more($more) {
  return ' &hellip; <a href="' . get_permalink() . '">' . __( 'Continued', 'bodyrock' ) . '</a>';
}

add_filter('excerpt_length', 'bodyrock_excerpt_length');
add_filter('excerpt_more', 'bodyrock_excerpt_more');


function bodyrock_posted_on() {
	printf( __( '<span class="sep">Posté le </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>
		<!--<span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>-->', 'twentyeleven' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'twentyeleven' ), get_the_author() ) ),
		get_the_author()
	);
}


if ( ! function_exists( 'bodyrock_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function bodyrock_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentyeleven' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyeleven' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}
endif; // twentyeleven_content_nav

?>