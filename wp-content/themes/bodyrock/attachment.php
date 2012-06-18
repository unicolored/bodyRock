<?php get_header(); ?>

<div class="row">
	<?php get_sidebar('left'); ?>
	<div class="span8">
		<?php get_template_part( 'loop', 'attachment' ); ?>
	</div>	
	<?php get_sidebar('right'); ?>
</div>

<?php get_footer();?>