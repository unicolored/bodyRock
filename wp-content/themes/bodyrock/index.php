<?php

$tpl_content = '/complet'; // /blog, /gallery, /complet

get_header(); ?>
<div class="designed">
<div class="container">
	<div class="row">		
		<div class="span8">
			<div id="contentsingle" class="br_content">
				<div class="wrapped">
					<?php
					if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							get_template_part( 'tpl/content'.$tpl_content, get_post_format() );
						endwhile;
					else: get_template_part( 'tpl/nocontent_found' ); 
					endif; ?>
					<?php br_customsidebar('widgetarea-undercontent','br_undercontent'); ?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="sidebardesigned sidebar-right">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div>
</div>
<?php global $tpl_content; echo is_super_admin() ? '!!'.__FILE__.':'.$tpl_content.'!!' : false; ?>
<?php get_footer();?>