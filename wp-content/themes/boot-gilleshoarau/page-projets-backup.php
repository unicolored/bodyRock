<?php
/* Template Name: Twitter */
get_header(); 
$page_data = get_page( get_the_ID() ); 
?>
<div class="container">
	<div class="span12">
		<div class="row">
			<div class="span2">
				<div class="promote grid_12">
			        <div class="wrapped">
			        	<?php echo $page_data->post_content; ?>
			        </div>
			    </div>
			</div>
			<div class="span10">
			<ul class="thumbnails">
				<?php
		        query_posts('post_type=projet&post_status=draft,publish&orderby=post_date&order=DESC&posts_per_page=20&paged='.$_GET['paged']);
				
				
		        if (have_posts()) : while (have_posts()) : the_post(); ?>
		        
		            <?php
		                $title= str_ireplace('"', '', trim(get_the_title()));
		                $desc= str_ireplace('"', '', trim(get_the_content()));
		            ?>	
		        
		        
		                <li class="span3"><a class="thumbnail" href="<?php print  the_permalink() ?>"><?php the_post_thumbnail('projetshot'); ?>
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
</div>

<?php get_footer(); ?>
