<?php get_header(); ?>
<div class="container-fluid designed">
	<div class="row-fluid">
		<div class="span2">
			<?php // primary widget area
			if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
				<?php dynamic_sidebar( 'sidebar-footer' ); ?>
			<?php endif; // end primary widget area ?>
			<div class=""><p><?php posts_nav_link(); ?></p></div>
		</div>
		<div class="span10">
			<?php
			if ( have_posts() ) : while ( have_posts() ) : the_post(); ?> 
				<div class="span4" style="margin:0 2px; margin-top:10px;">
					<article>
						<header>
						<?php
							$url= false;
							$i=0;
							$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
							global $blog_id;
							$url[$i] = theImgSrc($blog_id, $thumb['0']);
							if ($url[$i]!=NULL) {
								$thethumb = '<a class="thumbnail" href="'.get_permalink().'"><img style="border:4px solid #333" class="thumb" src="'.$url[$i].'" alt="'.get_the_title().'" /></a>';
							}
							else $thethumb=false;
							$i++;
							?>
							<?php echo $thethumb ?>
							<hr class="clear" />
							<h1 id="target"> <a href="<?php echo get_permalink() ?>"><?php the_title() ?></a></h1>
							
							
						</header>
						<!--<section>
							<?php the_excerpt() ?>
						</section>
						<footer>
						</footer>-->
					</article>
				</div>
			<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer();?>