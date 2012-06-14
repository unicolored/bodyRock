<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage bodyrock
 * @since bodyrock 0.1
 */

get_header();
?>
	<?php get_template_part( 'loop', 'single'.get_post_format() ); ?>
	
<?php
get_footer();
?>