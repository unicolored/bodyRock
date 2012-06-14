<?php
/* Template Name: Twitter */
get_header(); 
$page_data = get_page( get_the_ID() ); 
?>
<div class="container-fluid" style="background:#000;">
	<div class="row-fluid">
		<ul class="thumbnails">
			<?php
			query_posts('post_type=projet&post_status=draft,publish&orderby=post_date&order=DESC&posts_per_page=20&paged='.$_GET['paged']);
			
			
			if (have_posts()) : while (have_posts()) : the_post(); ?>
			
				<?php
					$title= str_ireplace('"', '', trim(get_the_title()));
					$desc= str_ireplace('"', '', trim(get_the_content()));
				?>	
				<?php
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'projet-thumb' );
				global $blog_id;
				$url = theImgSrc($blog_id, $thumb['0']);
				//echo $url;
				?>
				
			
					<li class="span5"><a class="thumbnail" href="<?php print  the_permalink() ?>"><img class="thumb" src="<?php echo $url?>" alt="<?php the_title(); ?>" />
					<h5><?php echo $title?></h5></a></li>
																		
		
				<?php endwhile; 
			else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
				<?php
			endif;
			wp_reset_query();
			?>
		</ul>
	</div>
	<div class="row">
		<?php // primary widget area
		if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
		<div class="span12">
		<?php dynamic_sidebar( 'sidebar-footer' ); ?>
		</div>
		<?php endif; // end primary widget area ?>
	</div>
</div>

<?php get_footer(); ?>
