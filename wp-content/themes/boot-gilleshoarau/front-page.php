<?php get_header();

query_posts('post_type=post&posts_per_page=12&paged='.get_query_var('paged'));

?>
<div class="container-fluid" style="background:#000;">
	<div class="container">
		<div class="row">
			<div class="span8">
				<div class="diaporama">
							
					<style type='text/css'>
						#gallery-1 {
							margin: auto;
							text-align: center;
						}
						#gallery-1 .gallery-item {
							float: left;
							text-align: center;
							width: 100%;
						}
						#gallery-1 .gallery-caption {
							margin-left: 0;
						}
					</style>
					<!-- see gallery_shortcode() in wp-includes/media.php -->

					<div id="myCarousel" class="carousel slide">
						<div class="carousel-inner">
							<?php
							if ( have_posts() ) :
								while ( have_posts() ) : the_post();
									// if(get_post_format()!='video') :
									$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'projet-medium' );
									global $blog_id;
									$url = theImgSrc($blog_id, $thumb['0']);
									if($url!=NULL) {
										?>
										<div class='item'>
											<?php get_template_part( 'content', get_post_format().'-carousel' ); ?>
										</div>									
										<?php
									}
									// endif;
								endwhile;
								else: ?>
								<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
								<?php
							endif;
							//wp_reset_query();
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="span4">
				<?php // primary widget area
				if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
					<?php dynamic_sidebar( 'sidebar-footer' ); ?>
				<?php endif; // end primary widget area ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer();?>