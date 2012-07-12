<?php get_header(); ?>
<div class="designed">
	<div class="container">
		<div class="row">		
			<div class="span8">				
				<div class="row br_content">
					<div id="contentsingle">
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
						<hr class="clear">
					</div>
					<?php br_customsidebar('widgetarea-undercontent','br_undercontent'); ?>
					<hr class="clear">
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