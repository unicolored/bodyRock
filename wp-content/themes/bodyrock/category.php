<?php get_header(); ?>

<div class="container">
	<div class="row">
		
		<ul class="thumbnails">    
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post(); ?>
					<li class="span3">
						<?php get_template_part( 'content', get_post_format() ); ?>
					</li>
				<?php endwhile;
				else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif;
			wp_reset_query();
			?>
		</ul>
			
		<div class="navigation span2 visible-desktop ">
			<p><?php posts_nav_link('','<span class="hide">Précédent</span>','<span class="navafter"><em class="hide">Suivant</em></span>'); ?></p>
		</div>
		
	</div>
</div>
<?php get_footer();?>