<?php
/**
 * The loop that displays a single post.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-single.php.
 *
 * @package Skeleton WordPress Theme Framework
 * @subpackage bodyrock
 * @author Simple Themes - www.simplethemes.com
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>	
<div class="container">
<div class="row">
	<article id="post-<?php the_ID(); ?>" <?php post_class('single'); ?>>
		<div class="span8">
			<header>
				<h1><?php the_title() ?></h1>
			</header>
			<div id="contentsingle">		
				<section>
					<?php the_content() ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'bodyrock' ), 'after' => '</div>' ) ); ?>
				</section>
				<footer>
					<div class="entry-utility">
						<div class="entry-meta">
							<?php bodyrock_posted_on(); ?>
							<br>
							<?php
							echo get_the_tag_list('<p>Tags: ',', ','</p>');
							?>
						</div><!-- .entry-meta -->	
					</div><!-- .entry-utility -->
				</footer>
			</div>
			<?php get_sidebar('right'); ?>
		</div>
		<div class="span4">
			<?php // primary widget area
			if ( is_active_sidebar( 'sidebar-single' ) ) : ?>
				<div id="sidebarsingle">
					<?php dynamic_sidebar( 'sidebar-single' ); ?>
				</div>
			<?php endif; // end primary widget area ?>
		</div>	
	</article>
</div>				
</div>
<?php endwhile; // end of the loop. ?>