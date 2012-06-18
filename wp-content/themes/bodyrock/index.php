<?php

global $query_string;
query_posts( $query_string . '&cat=-45&posts_per_page=5&paged='.get_query_var('paged') );

?>
<?php get_header(); ?>

<div class="row">
	<?php get_sidebar('left'); ?>
	<div class="span8">
<div class="navigation"><p><?php posts_nav_link(); ?></p></div>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<article>
			<header>
				<h1><a href="<?php echo the_permalink() ?>"><?php the_title() ?></a></h1>
				<p class="center"><?php the_post_thumbnail('small-feature'); ?></p>
			</header>
			<section>
				<?php the_excerpt() ?>
			</section>
			<footer>
			</footer>
		</article>
		<?php endwhile; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php endif; ?>
		
		
		<?php // primary widget area
		if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
		<div id="undercontent">
			<?php dynamic_sidebar( 'sidebar-footer' ); ?>
			<hr class="clear">
		</div>
		<?php endif; // end primary widget area ?>
		
	</div>
	<?php get_sidebar('right'); ?>
</div>

<?php get_footer();?>