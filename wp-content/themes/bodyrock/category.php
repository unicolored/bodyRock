<?php

$tpl_content = 'gallery'; // blog, gallery, complet

get_header(); ?>

<div class="container">
	<div class="row">		
		<div class="span8">
			<ul class="thumbnails">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) : the_post(); ?>
						<li class="span4">
							<?php get_template_part( 'tpl/content/'.$tpl_content, get_post_format() ); ?>
						</li>
					<?php endwhile;
				else: get_template_part( 'tpl/nocontent_found' ); 
				endif; ?>
			</ul>
			<?php br_customsidebar('widgetarea-undercontent','br_undercontent'); ?>
		</div>
		<div class="span4">
			<div class="sidebar sidebar-right">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>