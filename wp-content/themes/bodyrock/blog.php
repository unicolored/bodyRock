<?php
/*
Template Name: Blog
*/

$query_variables = array(
	'post_type' =>	'post', // post ou custom_type
	'cat'		=>	'', // exemple : 1,52,20
	'posts_per_page' => '12'
);

$tpl_content = '/complet'; // /blog, /gallery, /complet

get_header(); ?>
<div class="container-fluid">
	<div class="container">
		<div class="row">
			<div class="span8">
				<div class="br_content">
					<?php
					query_posts('paged='.get_query_var('paged').br_query($query_variables));
					if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							get_template_part( 'tpl/content'.$tpl_content, get_post_format() );
						endwhile;
					else: get_template_part( 'tpl/nocontent_found' ); 
					endif; ?>
				</div>
				<?php br_customsidebar('widgetarea-undercontent','br_undercontent'); ?>
			</div>
			<div class="span4">
				<div class="sidebar sidebar-right">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer();?>