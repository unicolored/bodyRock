<?php get_header();

query_posts('post_type=post&posts_per_page=12&paged='.get_query_var('paged'));

?>
<div class="container">
	<div class="span12">
		<div class="row">
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
		<div id='gallery-1' class='gallery galleryid-22 gallery-columns-1 gallery-size-diaporama'>			
			<?php
					if ( $attachments ) {
						foreach ( $attachments as $attachment ) {
							echo '<li class="span2">';
							$image_src=wp_get_attachment_image_src( $attachment->ID, 'projet-thumbsquare' );
							$input = array("1", "-1", "2", "-2", "3", "-3");
							$rand_keys = array_rand($input);
							echo '<a class="thumbnail rotate'.$input[$rand_keys].'"><img src="'.str_replace("files","wp-content/blogs.dir/9/files",$image_src[0]).'" alt="'.trim(strip_tags( get_post_meta($attachment_id, '_wp_attachment_image_alt', true) )).'" title="'.trim(strip_tags( $attachment->post_title )).'">';
							//echo apply_filters( 'the_title', $attachment->post_title );
							echo '</a></li>';
						}
					}
					if ( have_posts() ) :
					while ( have_posts() ) : the_post();
					//						if(get_post_format()!='video') :
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'carousel' );
					global $blog_id;
					$url = theImgSrc($blog_id, $thumb['0']);
					if($url!=NULL) {
					?>
						<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to overload this in a child theme then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format().'-carousel' );
						?>
			<br style="clear: both" />
			
					<?php
					}
					//					endif;
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

<?php get_footer();?>