<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>


				<?php while ( have_posts() ) : the_post(); ?>

					

					<?php get_template_part( 'content', 'singleprojet' ); ?>


				<?php endwhile; // end of the loop. ?>


<?php get_footer(); ?>