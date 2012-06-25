<?php
/*
Template Name: Blog
*/
get_header(); ?>
<div class="container-fluid designed">
	<div class="container">
		<div class="row">
			<div class="span8" style="background:#111">
				<?php
				wp_reset_query();
				query_posts('paged='.get_query_var('paged').'&post_type=post&cat=1,52&posts_per_page=6');
				if ( have_posts() ) : while ( have_posts() ) : the_post(); ?> 
					<article>
						<header>
							<?php get_template_part( 'tpl/content/blog', get_post_format() ); ?>
						</header>
					</article>
				<?php endwhile; else: ?>
					<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
				<?php endif; ?>
				
				<nav class="sidebar-navigation2">
					<?php
						global $wp_query;
						
						$big = 999999999; // need an unlikely integer
						
						echo paginate_links( array(
						'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'total' => $wp_query->max_num_pages
						) );
					?>
				</nav>
			</div>
			<div class="span4 sidebardesigned">
				<?php get_template_part( 'sidebar', 'blog' ); ?>
			</div>
		</div>
	</div>
</div>
<span class="wp">Page-508</span>
<?php get_footer();?>