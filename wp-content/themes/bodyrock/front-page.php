<?php get_header();

query_posts('cat=-41,-5&posts_per_page=6&paged='.get_query_var('paged'));

?>
<div class="container">
	<div class="span10 offset1">
		<div class="row">
			<div id="myCarousel" class="carousel">
			  <!-- Carousel items -->
			  <div class="carousel-inner">
			    <?php
					if ( have_posts() ) :
					while ( have_posts() ) : the_post();
					//						if(get_post_format()!='video') :
					?>
					<li class="item">
					<?php // echo get_image_path(get_post_meta($post->ID, 'thumb', true)); ?>
						<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to overload this in a child theme then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format().'-carousel' );
						?>
					</li>
					<?php
					//					endif;
					endwhile;
					else: ?>
					<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
					<?php
					endif;
					//wp_reset_query();
					?>
			  </div>
			  <!-- Carousel nav -->
			  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
			  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
			</div>
		</div>
	</div>
	<div class="span12">
		<div class="row">
			<ul class="thumbnails">    
			<?php
			if ( have_posts() ) :
			while ( have_posts() ) : the_post();
			//						if(get_post_format()!='video') :
			?>
			<li class="span4">
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
			<?php // primary widget area
			if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
			<div class="span12">
			<?php dynamic_sidebar( 'sidebar-footer' ); ?>
			</div>
			<?php endif; // end primary widget area ?>
		</div>
	</div>
<?php get_footer();?>