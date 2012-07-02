<?php get_header(); ?>
<div class="designed">
	<div class="container">
		<div class="row show-grid">		
			<div class="span8">
				<div id="contentsingle">
					<div class="row br_content">
						<?php
						if ( have_posts() ) :
							while ( have_posts() ) : the_post();
							?>
								 <?php
									get_template_part( 'tpl/content'.bodyrock_getTplContent(get_query_var('cat')), get_post_format() );
									?>
							<?php
							endwhile;
						else: get_template_part( 'tpl/nocontent_found' ); 
						endif; ?>
					</div>
					<hr class="clear">
					<?php br_customsidebar('widgetarea-undercontent','br_undercontent'); ?>
				</div>
			</div>
			<div class="span4">
				<div class="sidebar sidebar-right">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php global $tpl_content; echo is_super_admin() ? '!!'.__FILE__.':'.$tpl_content.'!!' : false; ?>
<?php get_footer();?>