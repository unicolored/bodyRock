<?php get_header(); ?>
<div class="container-fluid designed">
	<div class="row-fluid">
		<div class="span2 sidebardesigned">
			<div class="navigation3">
				<?php wp_list_categories('orderby=name&use_desc_for_title=0&title_li=&hide_empty=1'); ?>
			</div>
			<div class=""><nav class="sidebar-navigation"><?php posts_nav_link(); ?></nav></div>
			<?php /*
			if (function_exists('social_media_mashup'))
				social_media_mashup(5);*/
			?>
		</div>
		<div class="span10">
			<?php
			if ( have_posts() ) : while ( have_posts() ) : the_post(); ?> 
				<div class="span4 imagesindex">
					<article>
						<header>
							<?php get_template_part( 'content', get_post_format() ); ?>
						</header>
					</article>
					<h1 class="target"><a href="<?php echo get_permalink() ?>"><?php the_title() ?></a></h1>
				</div>
			<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer();?>