<?php get_header();

query_posts('cat=-41,-5&paged='.get_query_var('paged'));

?>

<div class="row-fluid">
	<?php get_sidebar('left'); ?>
		<div class="row-fluid">
			<div class="navigation span2"><p><?php posts_nav_link('','<span class="navbefore"><em class="hide">Précédent</em></span>','<span class="hide">Suivant</span>'); ?></p></div>
			<div class="span8">
		    <ul class="thumbnails">    
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
//						if(get_post_format()!='video') :
					?>
						<li class="span5">
						<?php echo get_image_path(get_post_meta($post->ID, 'thumb', true)); ?>
							<?php
								/* Include the Post-Format-specific template for the content.
								 * If you want to overload this in a child theme then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'content', get_post_format() );
							?>
						</li>
						<?php
	//					endif;
					endwhile;
				else: ?>
					<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
				<?php
				endif;
				wp_reset_query();
				?>
			</ul>
			</div>
			<div class="navigation span2"><p><?php posts_nav_link('','<span class="hide">Précédent</span>','<span class="navafter"><em class="hide">Suivant</em></span>'); ?></p></div>
		</div>
		<?php // primary widget area
		if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
		<div class="container">
		<div id="undercontent" class="row">
			<div class="span12">
			<?php dynamic_sidebar( 'sidebar-footer' ); ?>
			<hr class="clear">
			</div>
		</div>
		</div>
		<?php endif; // end primary widget area ?>
	<?php get_sidebar('right'); ?>
</div>

<?php get_footer();?>