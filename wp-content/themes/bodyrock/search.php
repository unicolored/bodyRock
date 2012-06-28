<?php

$tpl_content = '/blog'; // /blog, /gallery, /complet

get_header(); ?>

<div class="container">
	<div class="row">
		<div class="span12">
			<h1>Recherche <small>"<?php printf( get_query_var('s'), '' . single_tag_title( '', false ) . '' );?>"</small></h1>
		</div>
		<div class="span8">
			<div class="br_content">
				<?php
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
<?php global $tpl_content; echo is_super_admin() ? '!!'.__FILE__.':'.$tpl_content.'!!' : false; ?>
<?php get_footer();?>